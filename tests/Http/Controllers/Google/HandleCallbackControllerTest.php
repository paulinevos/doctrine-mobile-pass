<?php

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Event;
use Vos\DoctrineMobilePass\Enums\Platform;
use Vos\DoctrineMobilePass\Events\MobilePassAdded;
use Vos\DoctrineMobilePass\Events\MobilePassRemoved;
use Vos\DoctrineMobilePass\Models\Google\GoogleMobilePassEvent;
use Vos\DoctrineMobilePass\Models\MobilePass;
use Vos\DoctrineMobilePass\Tests\TestSupport\Google\GoogleFixtures;

beforeEach(
    function () {
        config()->set('mobile-pass.google.callback_signing_key', GoogleFixtures::publicKey());
    }
);

it(
    'records a save event and fires the Laravel event', function () {
        Event::fake([MobilePassAdded::class]);

        $pass = MobilePass::factory()->create(
            [
            'platform' => Platform::Google,
            'content' => ['googleObjectId' => '3388.john'],
            ]
        );

        $jwt = JWT::encode(
            [
            'iss' => 'google',
            'iat' => time(),
            'eventType' => 'save',
            'objectId' => '3388.john',
            ],
            GoogleFixtures::privateKey(),
            'RS256'
        );

        $this->postJson(route('mobile-pass.google.callback'), [], ['Authorization' => 'Bearer '.$jwt])
            ->assertNoContent();

        expect(GoogleMobilePassEvent::where('mobile_pass_id', $pass->id)->saves()->count())->toBe(1);

        Event::assertDispatched(
            fn (MobilePassAdded $event) => $event->mobilePass->is($pass),
        );
    }
);

it(
    'records a remove event and fires the Laravel event', function () {
        Event::fake([MobilePassRemoved::class]);

        $pass = MobilePass::factory()->create(
            [
            'platform' => Platform::Google,
            'content' => ['googleObjectId' => '3388.john'],
            ]
        );

        $jwt = JWT::encode(
            ['iss' => 'google', 'iat' => time(), 'eventType' => 'del', 'objectId' => '3388.john'],
            GoogleFixtures::privateKey(),
            'RS256'
        );

        $this->postJson(route('mobile-pass.google.callback'), [], ['Authorization' => 'Bearer '.$jwt])
            ->assertNoContent();

        expect(GoogleMobilePassEvent::where('mobile_pass_id', $pass->id)->removes()->count())->toBe(1);

        Event::assertDispatched(
            fn (MobilePassRemoved $event) => $event->mobilePass->is($pass),
        );
    }
);
