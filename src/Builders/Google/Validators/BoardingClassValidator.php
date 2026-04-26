<?php

namespace Vos\DoctrineMobilePass\Builders\Google\Validators;

use Symfony\Component\Validator\Constraints as Assert;

class BoardingClassValidator extends GooglePassClassValidator
{
    protected function fields(): array
    {
        return [
            'id' => new Assert\Required(new Assert\NotBlank()),
            'issuerName' => new Assert\Optional(),
            'localScheduledDepartureDateTime' => new Assert\Optional(),
            'flightHeader' => new Assert\Optional(),
            'origin' => new Assert\Optional(),
            'destination' => new Assert\Optional(),
            'logo' => new Assert\Optional(),
            'heroImage' => new Assert\Optional(),
            'hexBackgroundColor' => new Assert\Optional(),
            'reviewStatus' => new Assert\Optional(),
        ];
    }
}
