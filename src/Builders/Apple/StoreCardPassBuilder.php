<?php

namespace Vos\DoctrineMobilePass\Builders\Apple;

use Vos\DoctrineMobilePass\Builders\Apple\Validators\ApplePassValidator;
use Vos\DoctrineMobilePass\Builders\Apple\Validators\StoreCardApplePassValidator;
use Vos\DoctrineMobilePass\Enums\PassType;

class StoreCardPassBuilder extends ApplePassBuilder
{
    protected PassType $type = PassType::StoreCard;

    protected static function validator(): ApplePassValidator
    {
        return new StoreCardApplePassValidator;
    }

    protected function compileData(): array
    {
        return array_merge(
            parent::compileData(),
            [
                'storeCard' => array_filter([
                    'primaryFields' => $this->primaryFields?->values()->toArray(),
                    'secondaryFields' => $this->secondaryFields?->values()->toArray(),
                    'headerFields' => $this->headerFields?->values()->toArray(),
                    'auxiliaryFields' => $this->auxiliaryFields?->values()->toArray(),
                ]),
            ],
        );
    }
}
