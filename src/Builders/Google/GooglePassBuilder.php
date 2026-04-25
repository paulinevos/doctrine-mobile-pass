<?php

namespace Vos\DoctrineMobilePass\Builders\Google;

use RuntimeException;
use Symfony\Component\Uid\Uuid;
use function Symfony\Component\String\u;
use Vos\DoctrineMobilePass\Actions\Google\CreateGoogleObjectAction;
use Vos\DoctrineMobilePass\Builders\Apple\Entities\Barcode;
use Vos\DoctrineMobilePass\Builders\Google\Validators\GooglePassObjectValidator;
use Vos\DoctrineMobilePass\Enums\BarcodeType;
use Vos\DoctrineMobilePass\Enums\PassType;
use Vos\DoctrineMobilePass\Enums\Platform;
use Vos\DoctrineMobilePass\Models\MobilePass;
use Vos\DoctrineMobilePass\Support\Config;
use Vos\DoctrineMobilePass\Support\Google\GoogleCredentials;
use Vos\DoctrineMobilePass\Support\WifiUri;

/**
 * @phpstan-consistent-constructor
 */
abstract class GooglePassBuilder
{
    protected ?string $classSuffix = null;

    protected ?string $objectSuffix = null;

    protected ?Barcode $barcode = null;

    protected string $state = 'ACTIVE';

    protected PassType $type;

    abstract protected static function validator(): GooglePassObjectValidator;

    abstract protected static function classResource(): string;

    abstract protected static function objectResource(): string;

    /**
     * @return array<string, mixed> 
     */
    abstract protected function compileData(): array;

    public static function make(): static
    {
        return new static;
    }

    public static function name(): string
    {
        $base = basename(str_replace('\\', '/', static::class));
        $pos = strrpos($base, 'PassBuilder');
        $stripped = $pos !== false ? substr($base, 0, $pos) : $base;

        return u($stripped)->snake()->toString();
    }

    public function platform(): Platform
    {
        return Platform::Google;
    }

    public function setClass(string $suffix): static
    {
        $this->classSuffix = $suffix;

        return $this;
    }

    public function setObjectSuffix(string $suffix): static
    {
        $this->objectSuffix = $suffix;

        return $this;
    }

    public function setBarcode(BarcodeType $format, string $message, ?string $altText = null): static
    {
        $barcode = Barcode::make($format, $message);

        if ($altText !== null) {
            $barcode->withAltText($altText);
        }

        $this->barcode = $barcode;

        return $this;
    }

    public function setWifiBarcode(
        string $ssid,
        ?string $password = null,
        bool $hidden = false,
        ?string $altText = null,
    ): static {
        return $this->setBarcode(
            BarcodeType::Qr,
            WifiUri::build($ssid, $password, $hidden),
            $altText ?? $ssid,
        );
    }

    public function objectId(): string
    {
        $this->objectSuffix ??= Uuid::v4()->toRfc4122();

        return GoogleCredentials::issuerId().'.'.$this->objectSuffix;
    }

    public function classId(): string
    {
        if ($this->classSuffix === null) {
            throw new RuntimeException('Call setClass() before saving a Google pass.');
        }

        return GoogleCredentials::issuerId().'.'.$this->classSuffix;
    }

    public function save(): MobilePass
    {
        $payload = $this->compileGoogleObjectPayload();

        static::validator()->validate($payload);

        app(CreateGoogleObjectAction::class)->execute(
            static::objectResource(),
            $this->objectId(),
            $payload,
        );

        $mobilePassClass = Config::mobilePassModel();

        return $mobilePassClass::query()->create(
            [
            'type' => $this->type->value,
            'platform' => Platform::Google,
            'builder_name' => static::name(),
            'content' => [
                'googleClassType' => static::classResource(),
                'googleObjectId' => $this->objectId(),
                'googleClassId' => $this->classId(),
                'googleObjectPayload' => $payload,
            ],
            'images' => [],
            ]
        );
    }

    /**
     * @return array<string, mixed> 
     */
    protected function compileGoogleObjectPayload(): array
    {
        return $this->filterEmpty(
            array_merge(
                [
                'id' => $this->objectId(),
                'classId' => $this->classId(),
                'state' => $this->state,
                'barcode' => $this->compileBarcode(),
                ], $this->compileData()
            )
        );
    }

    /**
     * @return array<string, mixed>|null 
     */
    protected function compileBarcode(): ?array
    {
        if ($this->barcode === null) {
            return null;
        }

        return $this->filterEmpty(
            [
            'type' => $this->translateBarcodeType($this->barcode->format),
            'value' => $this->barcode->message,
            'alternateText' => $this->barcode->altText,
            ]
        );
    }

    protected function translateBarcodeType(BarcodeType $type): string
    {
        return match ($type) {
            BarcodeType::Qr => 'QR_CODE',
            BarcodeType::Pdf417 => 'PDF_417',
            BarcodeType::Aztec => 'AZTEC',
            BarcodeType::Code128 => 'CODE_128',
        };
    }

    /**
     * @param  array<string, mixed> $values
     * @return array<string, mixed>
     */
    protected function filterEmpty(array $values): array
    {
        return array_filter($values, fn ($value) => $value !== null && $value !== []);
    }

}
