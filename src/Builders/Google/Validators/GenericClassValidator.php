<?php

namespace Vos\DoctrineMobilePass\Builders\Google\Validators;

use Symfony\Component\Validator\Constraints as Assert;

class GenericClassValidator extends GooglePassClassValidator
{
    protected function fields(): array
    {
        return [
            'id' => new Assert\Required(new Assert\NotBlank()),
            'issuerName' => new Assert\Optional(),
            'cardTitle' => new Assert\Optional(),
            'subheader' => new Assert\Optional(),
            'header' => new Assert\Optional(),
            'hexBackgroundColor' => new Assert\Optional(),
            'logo' => new Assert\Optional(),
            'heroImage' => new Assert\Optional(),
            'reviewStatus' => new Assert\Optional(),
        ];
    }
}
