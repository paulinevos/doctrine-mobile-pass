<?php

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use Vos\DoctrineMobilePass\Actions\Apple\NotifyAppleOfPassUpdateAction;
use Vos\DoctrineMobilePass\Actions\Google\NotifyGoogleOfPassUpdateAction;
use Vos\DoctrineMobilePass\Enums\Platform;
use Vos\DoctrineMobilePass\Jobs\PushPassUpdateJob;
use Vos\DoctrineMobilePass\Models\MobilePass;

it(
    'runs sync when no queue connection is configured', function () {
        config()->set('mobile-pass.queue.connection', null);
        Bus::fake();

        $pass = MobilePass::factory()->create(['platform' => Platform::Apple]);

        PushPassUpdateJob::dispatch($pass, NotifyAppleOfPassUpdateAction::class);

        Bus::assertDispatchedSync(PushPassUpdateJob::class);
    }
);

it(
    'queues when a queue connection is configured', function () {
        config()->set('mobile-pass.queue.connection', 'redis');
        config()->set('mobile-pass.queue.name', 'mobile-pass');
        Queue::fake();

        $pass = MobilePass::factory()->create(['platform' => Platform::Google]);

        PushPassUpdateJob::dispatch($pass, NotifyGoogleOfPassUpdateAction::class);

        Queue::assertPushedOn('mobile-pass', PushPassUpdateJob::class);
    }
);
