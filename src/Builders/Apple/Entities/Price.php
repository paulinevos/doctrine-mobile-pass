<?php

namespace Vos\DoctrineMobilePass\Builders\Apple\Entities;

class Price
{
    public function __construct(
        public ?string $amount = null,
        public ?string $currencyCode = null,
    ) {
    }

    public static function make(?string $amount = null, ?string $currencyCode = null): self
    {
        return new self($amount, $currencyCode);
    }

    /**
     * @param array<string, mixed> $values 
     */
    public static function fromArray(array $values): self
    {
        return new self(
            $values['amount'] ?? null,
            $values['currencyCode'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currencyCode' => $this->currencyCode,
        ];
    }
}
