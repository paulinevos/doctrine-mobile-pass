<?php

namespace Vos\DoctrineMobilePass\Exceptions;

use Exception;
use Vos\DoctrineMobilePass\Models\MobilePass;

class CannotDownload extends Exception implements MobilePassException
{
    public static function wrongPlatform(MobilePass $mobilePass): self
    {
        return new self("Only Apple passes can be downloaded. Pass `{$mobilePass->getKey()}` has platform `{$mobilePass->platform->value}`.");
    }
}
