<?php

namespace Vos\DoctrineMobilePass\Builders\Google\Validators;

use Symfony\Component\Validator\Constraints as Assert;

class BoardingObjectValidator extends GooglePassObjectValidator
{
    protected function fields(): array
    {
        return [
            'id' => new Assert\Required(new Assert\NotBlank()),
            'classId' => new Assert\Required(new Assert\NotBlank()),
            'state' => new Assert\Optional(),
            'passengerName' => new Assert\Optional(),
            'boardingAndSeatingInfo' => new Assert\Optional(),
            'reservationInfo' => new Assert\Optional(),
            'barcode' => new Assert\Optional(),
        ];
    }
}
