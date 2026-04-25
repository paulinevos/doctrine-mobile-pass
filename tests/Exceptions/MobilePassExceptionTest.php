<?php

use Vos\DoctrineMobilePass\Enums\Platform;
use Vos\DoctrineMobilePass\Exceptions\AppleWalletRequestFailed;
use Vos\DoctrineMobilePass\Exceptions\CannotDownload;
use Vos\DoctrineMobilePass\Exceptions\GoogleWalletRequestFailed;
use Vos\DoctrineMobilePass\Exceptions\ImageNotFound;
use Vos\DoctrineMobilePass\Exceptions\InvalidCertificate;
use Vos\DoctrineMobilePass\Exceptions\InvalidConfig;
use Vos\DoctrineMobilePass\Exceptions\InvalidPass;
use Vos\DoctrineMobilePass\Exceptions\MobilePassException;
use Vos\DoctrineMobilePass\Exceptions\PlatformDoesntSupport;
use Vos\DoctrineMobilePass\Models\MobilePass;

it('lets you catch every package exception through the MobilePassException interface', function (string $exceptionClass) {
    expect(is_subclass_of($exceptionClass, MobilePassException::class))->toBeTrue();
})->with([
    AppleWalletRequestFailed::class,
    CannotDownload::class,
    GoogleWalletRequestFailed::class,
    ImageNotFound::class,
    InvalidCertificate::class,
    InvalidConfig::class,
    InvalidPass::class,
    PlatformDoesntSupport::class,
]);

it('can be caught generically', function () {
    $pass = MobilePass::factory()->make(['platform' => Platform::Google]);

    try {
        throw CannotDownload::wrongPlatform($pass);
    } catch (MobilePassException $exception) {
        expect($exception)->toBeInstanceOf(CannotDownload::class);
    }
});
