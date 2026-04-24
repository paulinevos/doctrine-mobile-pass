<?php

namespace Vos\DoctrineMobilePass\Actions\Apple;

use Vos\DoctrineMobilePass\Events\MobilePassAdded;
use Vos\DoctrineMobilePass\Models\Apple\AppleMobilePassDevice;
use Vos\DoctrineMobilePass\Models\Apple\AppleMobilePassRegistration;
use Vos\DoctrineMobilePass\Models\MobilePass;
use Vos\DoctrineMobilePass\Support\Config;

class RegisterDeviceAction
{
    public function execute(
        string $deviceId,
        string $pushToken,
        string $passTypeId,
        string $passSerial,
    ): AppleMobilePassRegistration {
        $pass = $this->mobilePass($passSerial);
        $device = $this->device($deviceId, $pushToken);

        $registration = $pass->registrations()->firstOrCreate([
            'device_id' => $device->getKey(),
            'pass_type_id' => $passTypeId,
            'pass_serial' => $passSerial,
        ]);

        if ($registration->wasRecentlyCreated) {
            event(new MobilePassAdded($pass));
        }

        return $registration;
    }

    protected function mobilePass(string $passSerial): MobilePass
    {
        $mobilePassModel = Config::mobilePassModel();

        return $mobilePassModel::query()->findOrFail($passSerial);
    }

    protected function device(string $deviceId, string $pushToken): AppleMobilePassDevice
    {
        $mobilePassDeviceModel = Config::appleDeviceModel();

        return $mobilePassDeviceModel::query()->updateOrCreate(
            ['id' => $deviceId],
            ['push_token' => $pushToken],
        );
    }
}
