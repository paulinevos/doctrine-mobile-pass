<?php

namespace Vos\DoctrineMobilePass\Builders\Apple;

use Vos\DoctrineMobilePass\Builders\Apple\Validators\ApplePassValidator;
use Vos\DoctrineMobilePass\Builders\Apple\Validators\EventTicketApplePassValidator;
use Vos\DoctrineMobilePass\Enums\PassType;

class EventTicketPassBuilder extends ApplePassBuilder
{
    protected PassType $type = PassType::EventTicket;

    protected static function validator(): ApplePassValidator
    {
        return new EventTicketApplePassValidator;
    }

    protected function compileData(): array
    {
        return array_merge(
            parent::compileData(),
            [
                'eventTicket' => array_filter([
                    'primaryFields' => $this->primaryFields?->values()->toArray(),
                    'secondaryFields' => $this->secondaryFields?->values()->toArray(),
                    'headerFields' => $this->headerFields?->values()->toArray(),
                    'auxiliaryFields' => $this->auxiliaryFields?->values()->toArray(),
                    'backFields' => $this->backFields?->values()->toArray(),
                ]),
            ],
        );
    }
}
