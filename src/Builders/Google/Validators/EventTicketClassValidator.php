<?php

namespace Vos\DoctrineMobilePass\Builders\Google\Validators;

use Symfony\Component\Validator\Constraints as Assert;

class EventTicketClassValidator extends GooglePassClassValidator
{
    protected function fields(): array
    {
        return [
            'id' => new Assert\Required(new Assert\NotBlank()),
            'issuerName' => new Assert\Optional(),
            'eventName' => new Assert\Required(
                new Assert\Collection(
                    allowExtraFields: true,
                    fields: [
                    'defaultValue' => new Assert\Required(
                        new Assert\Collection(
                            allowExtraFields: true,
                            fields: [
                            'value' => new Assert\Required(new Assert\NotBlank()),
                            ],
                        )
                    ),
                    ],
                )
            ),
            'venue' => new Assert\Optional(),
            'dateTime' => new Assert\Optional(),
            'logo' => new Assert\Optional(),
            'heroImage' => new Assert\Optional(),
            'hexBackgroundColor' => new Assert\Optional(),
            'reviewStatus' => new Assert\Optional(),
        ];
    }
}
