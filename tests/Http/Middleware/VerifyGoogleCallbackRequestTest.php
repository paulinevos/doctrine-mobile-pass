<?php

use Firebase\JWT\JWT;
use Illuminate\Auth\AuthenticationException;
use Vos\DoctrineMobilePass\Http\Middleware\VerifyGoogleCallbackRequest;
use Vos\DoctrineMobilePass\Tests\TestSupport\Google\GoogleFixtures;

beforeEach(function () {
    config()->set('mobile-pass.google.callback_signing_key', GoogleFixtures::publicKey());
});

it('rejects a request with no Authorization header', function () {
    $middleware = new VerifyGoogleCallbackRequest;
    $request = request();

    $middleware->handle($request, fn ($request) => response('ok'));
})->throws(AuthenticationException::class);

it('accepts a request with a valid signed JWT', function () {
    $jwt = JWT::encode(
        ['iss' => 'google', 'iat' => time(), 'eventType' => 'save'],
        GoogleFixtures::privateKey(),
        'RS256'
    );

    $middleware = new VerifyGoogleCallbackRequest;
    $request = request();
    $request->setMethod('POST');
    $request->headers->set('Authorization', 'Bearer '.$jwt);

    $response = $middleware->handle($request, fn ($request) => response('ok'));

    expect($response->getContent())->toBe('ok');
});
