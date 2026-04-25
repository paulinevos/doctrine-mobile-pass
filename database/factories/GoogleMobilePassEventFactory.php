<?php

namespace Vos\DoctrineMobilePass\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vos\DoctrineMobilePass\Models\Google\GoogleMobilePassEvent;
use Vos\DoctrineMobilePass\Models\MobilePass;

/**
 * @extends Factory<GoogleMobilePassEvent>
 */
class GoogleMobilePassEventFactory extends Factory
{
    protected $model = GoogleMobilePassEvent::class;

    public function definition(): array
    {
        return [
            'mobile_pass_id' => MobilePass::factory(),
            'event_type' => 'save',
            'received_at' => now(),
            'raw_payload' => [],
        ];
    }
}
