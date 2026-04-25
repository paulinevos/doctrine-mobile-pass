<?php

namespace Vos\DoctrineMobilePass\Builders\Google\Validators;

use Symfony\Component\Validator\Constraints as Assert;

class GenericObjectValidator extends GooglePassObjectValidator
{
    protected function fields(): array
    {
        return [
            'id' => new Assert\Required(new Assert\NotBlank()),
            'classId' => new Assert\Required(new Assert\NotBlank()),
            'state' => new Assert\Optional(),
            'header' => new Assert\Optional(),
            'cardTitle' => new Assert\Optional(),
            'subheader' => new Assert\Optional(),
            'notifications' => new Assert\Optional(),
            'barcode' => new Assert\Optional(),
        ];
    }
}
