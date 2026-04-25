<?php

use Illuminate\Support\Facades\Route;
use Vos\DoctrineMobilePass\Http\Controllers\Apple\CheckForUpdatesController;
use Vos\DoctrineMobilePass\Http\Controllers\Apple\DownloadApplePassController;
use Vos\DoctrineMobilePass\Http\Controllers\Apple\GetAssociatedSerialsForDeviceController;
use Vos\DoctrineMobilePass\Http\Controllers\Apple\MobilePassLogController;
use Vos\DoctrineMobilePass\Http\Controllers\Apple\RegisterDeviceController;
use Vos\DoctrineMobilePass\Http\Controllers\Apple\UnregisterDeviceController;
use Vos\DoctrineMobilePass\Http\Controllers\Google\HandleCallbackController;
use Vos\DoctrineMobilePass\Http\Middleware\VerifyApplePasskitRequest;
use Vos\DoctrineMobilePass\Http\Middleware\VerifyGoogleCallbackRequest;

Route::macro('mobilePass', function (string $prefix = '') {
    Route::prefix("{$prefix}/passkit/v1")->group(function () {

        Route::middleware(VerifyApplePasskitRequest::class)->group(function () {
            Route::post('devices/{deviceId}/registrations/{passTypeId}/{passSerial}', RegisterDeviceController::class)
                ->name('mobile-pass.register-device');

            Route::get('passes/{passTypeId}/{passSerial}', CheckForUpdatesController::class)
                ->name('mobile-pass.check-for-updates');

            Route::delete('devices/{deviceId}/registrations/{passTypeId}/{passSerial}', UnregisterDeviceController::class)
                ->name('mobile-pass.unregister-device');
        });

        Route::get('devices/{deviceId}/registrations/{passTypeId}', GetAssociatedSerialsForDeviceController::class)
            ->name('mobile-pass.get-associated-serials-for-device');

        Route::post('log', MobilePassLogController::class)
            ->name('mobile-pass.logs');

        Route::get('apple/{mobilePass}/download', DownloadApplePassController::class)
            ->name('mobile-pass.apple.download');

        Route::post('google/callbacks', HandleCallbackController::class)
            ->middleware(VerifyGoogleCallbackRequest::class)
            ->name('mobile-pass.google.callback');
    });
});
