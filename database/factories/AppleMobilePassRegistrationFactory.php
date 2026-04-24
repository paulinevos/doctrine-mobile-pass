<?php

namespace Vos\DoctrineMobilePass\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vos\DoctrineMobilePass\Models\Apple\AppleMobilePassDevice;
use Vos\DoctrineMobilePass\Models\Apple\AppleMobilePassRegistration;
use Vos\DoctrineMobilePass\Models\MobilePass;

class AppleMobilePassRegistrationFactory extends Factory
{
    protected $model = AppleMobilePassRegistration::class;

    public function definition(): array
    {
        return [
            'device_id' => AppleMobilePassDevice::factory(),
            'pass_type_id' => 'pass.com.example',
            'pass_serial' => MobilePass::factory(),
        ];
    }
}
