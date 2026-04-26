<?php

namespace Vos\DoctrineMobilePass\Builders\Google\Validators;

use Symfony\Component\Validator\Constraints as Assert;

class LoyaltyObjectValidator extends GooglePassObjectValidator
{
    protected function fields(): array
    {
        return [
            'id' => new Assert\Required(new Assert\NotBlank()),
            'classId' => new Assert\Required(new Assert\NotBlank()),
            'state' => new Assert\Optional(),
            'accountId' => new Assert\Optional(),
            'accountName' => new Assert\Optional(),
            'loyaltyPoints' => new Assert\Optional(),
            'barcode' => new Assert\Optional(),
        ];
    }
}
