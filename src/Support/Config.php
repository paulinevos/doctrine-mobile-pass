<?php

namespace Vos\DoctrineMobilePass\Support;

use Vos\DoctrineMobilePass\Builders\Apple\AirlinePassBuilder;
use Vos\DoctrineMobilePass\Builders\Apple\ApplePassBuilder;
use Vos\DoctrineMobilePass\Builders\Apple\BoardingPassBuilder as AppleBoardingPassBuilder;
use Vos\DoctrineMobilePass\Builders\Apple\CouponPassBuilder;
use Vos\DoctrineMobilePass\Builders\Apple\EventTicketPassBuilder as AppleEventTicketPassBuilder;
use Vos\DoctrineMobilePass\Builders\Apple\GenericPassBuilder as AppleGenericPassBuilder;
use Vos\DoctrineMobilePass\Builders\Apple\StoreCardPassBuilder;
use Vos\DoctrineMobilePass\Builders\Google\BoardingPassBuilder as GoogleBoardingPassBuilder;
use Vos\DoctrineMobilePass\Builders\Google\EventTicketPassBuilder as GoogleEventTicketPassBuilder;
use Vos\DoctrineMobilePass\Builders\Google\GenericPassBuilder as GoogleGenericPassBuilder;
use Vos\DoctrineMobilePass\Builders\Google\GooglePassBuilder;
use Vos\DoctrineMobilePass\Builders\Google\LoyaltyPassBuilder;
use Vos\DoctrineMobilePass\Builders\Google\OfferPassBuilder;
use Vos\DoctrineMobilePass\Enums\Platform;
use Vos\DoctrineMobilePass\Exceptions\InvalidConfig;
use Vos\DoctrineMobilePass\Models\Apple\AppleMobilePassDevice;
use Vos\DoctrineMobilePass\Models\Apple\AppleMobilePassRegistration;
use Vos\DoctrineMobilePass\Models\Google\GoogleMobilePassEvent;
use Vos\DoctrineMobilePass\Models\MobilePass;

class Config
{
    /**
     * @return array<string, array<string, class-string>> 
     */
    protected static function defaultBuilders(): array
    {
        return [
            'apple' => [
                'airline' => AirlinePassBuilder::class,
                'boarding' => AppleBoardingPassBuilder::class,
                'coupon' => CouponPassBuilder::class,
                'event_ticket' => AppleEventTicketPassBuilder::class,
                'generic' => AppleGenericPassBuilder::class,
                'store_card' => StoreCardPassBuilder::class,
            ],
            'google' => [
                'boarding' => GoogleBoardingPassBuilder::class,
                'event_ticket' => GoogleEventTicketPassBuilder::class,
                'generic' => GoogleGenericPassBuilder::class,
                'loyalty' => LoyaltyPassBuilder::class,
                'offer' => OfferPassBuilder::class,
            ],
        ];
    }

    /**
     * @return class-string<MobilePass> 
     */
    public static function mobilePassModel(): string
    {
        return self::getModelClass('mobile_pass', MobilePass::class);
    }

    /**
     * @return class-string<AppleMobilePassRegistration> 
     */
    public static function appleMobilePassRegistrationModel(): string
    {
        return self::getModelClass('apple_mobile_pass_registration', AppleMobilePassRegistration::class);
    }

    /**
     * @return class-string<AppleMobilePassDevice> 
     */
    public static function appleDeviceModel(): string
    {
        return self::getModelClass('apple_mobile_pass_device', AppleMobilePassDevice::class);
    }

    /**
     * @return class-string<GoogleMobilePassEvent> 
     */
    public static function googleMobilePassEventModel(): string
    {
        return self::getModelClass('google_mobile_pass_event', GoogleMobilePassEvent::class);
    }

    protected static function getModelClass(string $modelName, string $defaultClass): string
    {
        $modelClass = config("mobile-pass.models.{$modelName}", $defaultClass);

        if (! is_a($modelClass, $defaultClass, true)) {
            throw InvalidConfig::invalidModel($modelName, $modelClass, $defaultClass);
        }

        return $modelClass;
    }

    /**
     * @param  class-string $shouldBeOrExtend
     * @return class-string
     */
    public static function getActionClass(string $actionName, string $shouldBeOrExtend): string
    {
        $actionClass = config("mobile-pass.actions.{$actionName}");

        if (! is_a($actionClass, $shouldBeOrExtend, true)) {
            throw InvalidConfig::invalidAction($actionName, $actionClass, $shouldBeOrExtend);
        }

        return $actionClass;
    }

    /**
     * @return class-string<ApplePassBuilder|GooglePassBuilder> 
     */
    public static function getPassBuilderClass(string $passBuilderName, Platform $platform): string
    {
        $configuredClass = config("mobile-pass.builders.{$platform->value}.{$passBuilderName}");
        $defaultClass = self::defaultBuilders()[$platform->value][$passBuilderName] ?? null;

        $passBuilderClass = $configuredClass ?? $defaultClass;

        if (! $passBuilderClass) {
            throw InvalidConfig::passBuilderNotRegistered($passBuilderName, $platform);
        }

        if (! class_exists($passBuilderClass)) {
            throw InvalidConfig::passBuilderNotFound($passBuilderName, $passBuilderClass);
        }

        $classToExtend = match ($platform) {
            Platform::Apple => ApplePassBuilder::class,
            Platform::Google => GooglePassBuilder::class,
        };

        if (! is_a($passBuilderClass, $classToExtend, true)) {
            throw InvalidConfig::invalidPassBuilderClass($passBuilderName, $passBuilderClass, $platform);
        }

        return $passBuilderClass;
    }
}
