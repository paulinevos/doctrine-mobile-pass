<?php

namespace Vos\DoctrineMobilePass\Http\Controllers\Apple;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Vos\DoctrineMobilePass\Actions\Apple\UnregisterDeviceAction;
use Vos\DoctrineMobilePass\Support\Config;

/**
 * Unregistering a Device
 * https://developer.apple.com/documentation/walletpasses/unregister-a-pass-for-update-notifications
 */
class UnregisterDeviceController extends Controller
{
    public function __invoke(Request $request): Response
    {
        /** @var class-string<UnregisterDeviceAction> $action */
        $action = Config::getActionClass('unregister_device', UnregisterDeviceAction::class);

        (new $action)->execute($request->deviceId, $request->passSerial);

        return response()->noContent();
    }
}
