<?php

namespace Vos\DoctrineMobilePass\Builders\Apple\Validators;

use Symfony\Component\Validator\Constraints as Assert;

class StoreCardApplePassValidator extends ApplePassValidator
{
    protected function fields(): array
    {
        return array_merge(parent::fields(), [
            'storeCard' => new Assert\Required(new Assert\Collection(
                allowExtraFields: true,
                fields: [
                    'headerFields' => new Assert\Optional(),
                    'primaryFields' => new Assert\Optional(),
                    'secondaryFields' => new Assert\Optional(),
                    'auxiliaryFields' => new Assert\Optional(),
                ],
            )),
        ]);
    }
}
