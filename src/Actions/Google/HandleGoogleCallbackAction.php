<?php

namespace Vos\DoctrineMobilePass\Actions\Google;

use Illuminate\Http\Request;
use Vos\DoctrineMobilePass\Events\MobilePassAdded;
use Vos\DoctrineMobilePass\Events\MobilePassRemoved;
use Vos\DoctrineMobilePass\Models\MobilePass;
use Vos\DoctrineMobilePass\Support\Config;

class HandleGoogleCallbackAction
{
    public function execute(Request $request): void
    {
        /** @var array<string, mixed> $claims */
        $claims = (array) $request->attributes->get('google_callback_claims', []);

        $objectId = $claims['objectId'] ?? null;

        if ($objectId === null) {
            return;
        }

        $eventType = match ($claims['eventType'] ?? null) {
            'save' => 'save',
            'del' => 'remove',
            default => null,
        };

        if ($eventType === null) {
            return;
        }

        $mobilePass = $this->resolvePass((string) $objectId);

        if ($mobilePass === null) {
            return;
        }

        $eventModelClass = Config::googleMobilePassEventModel();

        $eventModelClass::query()->create([
            'mobile_pass_id' => $mobilePass->id,
            'event_type' => $eventType,
            'received_at' => now(),
            'raw_payload' => $claims,
        ]);

        event(match ($eventType) {
            'save' => new MobilePassAdded($mobilePass),
            'remove' => new MobilePassRemoved($mobilePass),
        });
    }

    protected function resolvePass(string $objectId): ?MobilePass
    {
        $modelClass = Config::mobilePassModel();

        return $modelClass::query()
            ->where('content->googleObjectId', $objectId)
            ->first();
    }
}
