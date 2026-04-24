<?php

namespace Vos\DoctrineMobilePass\Builders\Google;

use Vos\DoctrineMobilePass\Builders\Google\Validators\BoardingObjectValidator;
use Vos\DoctrineMobilePass\Builders\Google\Validators\GooglePassObjectValidator;
use Vos\DoctrineMobilePass\Enums\PassType;

class BoardingPassBuilder extends GooglePassBuilder
{
    protected PassType $type = PassType::BoardingPass;

    protected ?string $passengerName = null;

    protected ?string $seatNumber = null;

    protected ?string $confirmationCode = null;

    protected static function validator(): GooglePassObjectValidator
    {
        return new BoardingObjectValidator;
    }

    protected static function classResource(): string
    {
        return 'flightClass';
    }

    protected static function objectResource(): string
    {
        return 'flightObject';
    }

    public function setPassengerName(string $name): self
    {
        $this->passengerName = $name;

        return $this;
    }

    public function setSeatNumber(string $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    public function setConfirmationCode(string $confirmationCode): self
    {
        $this->confirmationCode = $confirmationCode;

        return $this;
    }

    /** @return array<string, mixed> */
    protected function compileData(): array
    {
        $boardingAndSeatingInfo = $this->filterEmpty([
            'seatNumber' => $this->seatNumber,
        ]);

        $reservationInfo = $this->filterEmpty([
            'confirmationCode' => $this->confirmationCode,
        ]);

        return $this->filterEmpty([
            'passengerName' => $this->passengerName,
            'boardingAndSeatingInfo' => $boardingAndSeatingInfo,
            'reservationInfo' => $reservationInfo,
        ]);
    }
}
