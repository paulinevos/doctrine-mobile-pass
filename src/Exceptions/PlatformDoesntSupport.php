<?php

namespace Vos\DoctrineMobilePass\Exceptions;

use Exception;
use Vos\DoctrineMobilePass\Enums\Platform;

class PlatformDoesntSupport extends Exception implements MobilePassException
{
    public static function cannotUpdateFields(Platform $platform): self
    {
        return new self("Platform {$platform->value} doesn't support updating fields by key. Use the platform-specific builder instead.");
    }
}
