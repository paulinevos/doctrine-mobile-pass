<?php

namespace Vos\DoctrineMobilePass\Builders\Google\Validators;

use Symfony\Component\Validator\Constraints as Assert;

class OfferClassValidator extends GooglePassClassValidator
{
    protected function fields(): array
    {
        return [
            'id' => new Assert\Required(new Assert\NotBlank()),
            'issuerName' => new Assert\Optional(),
            'title' => new Assert\Required(new Assert\NotBlank()),
            'redemptionChannel' => new Assert\Optional(),
            'provider' => new Assert\Optional(),
            'details' => new Assert\Optional(),
            'finePrint' => new Assert\Optional(),
            'logo' => new Assert\Optional(),
            'hexBackgroundColor' => new Assert\Optional(),
            'reviewStatus' => new Assert\Optional(),
        ];
    }
}
