<?php

namespace Vos\DoctrineMobilePass\Http\Controllers\Apple;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Vos\DoctrineMobilePass\Models\MobilePass;
use Vos\DoctrineMobilePass\Support\Apple\DownloadableMobilePass;
use Vos\DoctrineMobilePass\Support\Config;

class DownloadApplePassController extends Controller
{
    public function __invoke(Request $request, string $mobilePass): DownloadableMobilePass
    {
        abort_unless($request->hasValidSignature(), 403);

        $modelClass = Config::mobilePassModel();

        /** @var MobilePass $pass */
        $pass = $modelClass::query()->findOrFail($mobilePass);

        return $pass->download();
    }
}
