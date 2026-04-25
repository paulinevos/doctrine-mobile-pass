<?php

namespace Vos\DoctrineMobilePass\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Vos\DoctrineMobilePass\Models\Concerns\HasMobilePasses;

class TestModel extends Model
{
    use HasMobilePasses;
}
