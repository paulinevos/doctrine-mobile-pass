<?php

namespace Vos\DoctrineMobilePass\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Vos\DoctrineMobilePass\Models\MobilePass;

class MobilePassRemoved
{
    use Dispatchable;

    public function __construct(public MobilePass $mobilePass) {}
}
