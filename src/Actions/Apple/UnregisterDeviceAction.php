<?php

namespace Vos\DoctrineMobilePass\Actions\Apple;

use Vos\DoctrineMobilePass\Events\MobilePassRemoved;
use Vos\DoctrineMobilePass\Models\Apple\AppleMobilePassRegistration;
use Vos\DoctrineMobilePass\Support\Config;

class UnregisterDeviceAction
{
    public function execute(string $deviceId, string $passSerial): void
    {
        $mobilePassRegistrationModel = Config::appleMobilePassRegistrationModel();

        $mobilePassRegistrationModel::query()
            ->with('pass')
            ->where(
                [
                'device_id' => $deviceId,
                'pass_serial' => $passSerial,
                ]
            )
            ->each(
                function (AppleMobilePassRegistration $registration) {
                    $pass = $registration->pass;

                    $registration->delete();

                    event(new MobilePassRemoved($pass));
                }
            );
    }
}
