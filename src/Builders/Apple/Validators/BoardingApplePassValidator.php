<?php

namespace Vos\DoctrineMobilePass\Builders\Apple\Validators;

use Symfony\Component\Validator\Constraints as Assert;
use Vos\DoctrineMobilePass\Enums\TransitType;

class BoardingApplePassValidator extends ApplePassValidator
{
    protected function fields(): array
    {
        return array_merge(parent::fields(), [
            'boardingPass' => new Assert\Required(new Assert\Collection(
                allowExtraFields: true,
                fields: [
                    'transitType' => new Assert\Required([
                        new Assert\NotBlank(),
                        new Assert\Choice(choices: array_column(TransitType::cases(), 'value')),
                    ]),
                    'headerFields' => new Assert\Optional(),
                    'primaryFields' => new Assert\Optional(),
                    'secondaryFields' => new Assert\Optional(),
                    'auxiliaryFields' => new Assert\Optional(),
                    'backFields' => new Assert\Optional(),
                ],
            )),
        ]);
    }
}
