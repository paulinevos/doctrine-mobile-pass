<?php

namespace Vos\DoctrineMobilePass\Builders\Google\Validators;

use Symfony\Component\Validator\Constraints as Assert;

class LoyaltyClassValidator extends GooglePassClassValidator
{
    protected function fields(): array
    {
        return [
            'id' => new Assert\Required(new Assert\NotBlank()),
            'issuerName' => new Assert\Optional(),
            'programName' => new Assert\Required(new Assert\NotBlank()),
            'programLogo' => new Assert\Optional(),
            'rewardsTier' => new Assert\Optional(),
            'rewardsTierLabel' => new Assert\Optional(),
            'accountNameLabel' => new Assert\Optional(),
            'accountIdLabel' => new Assert\Optional(),
            'hexBackgroundColor' => new Assert\Optional(),
            'reviewStatus' => new Assert\Optional(),
        ];
    }
}
