<?php

namespace Vos\DoctrineMobilePass\Builders\Apple\Validators;

use Symfony\Component\Validator\Constraints as Assert;

class EventTicketApplePassValidator extends ApplePassValidator
{
    protected function fields(): array
    {
        return array_merge(
            parent::fields(), [
            'eventTicket' => new Assert\Required(
                new Assert\Collection(
                    allowExtraFields: true,
                    fields: [
                    'headerFields' => new Assert\Optional(),
                    'primaryFields' => new Assert\Optional(),
                    'secondaryFields' => new Assert\Optional(),
                    'auxiliaryFields' => new Assert\Optional(),
                    'backFields' => new Assert\Optional(),
                    ],
                )
            ),
            ]
        );
    }
}
