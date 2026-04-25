<?php

namespace Vos\DoctrineMobilePass\Actions\Google;

use Vos\DoctrineMobilePass\Support\Google\GoogleWalletClient;

class CreateGoogleObjectAction
{
    public function __construct(protected GoogleWalletClient $client) {}

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public function execute(string $resource, string $id, array $payload): array
    {
        return $this->client->insertObject($resource, $id, $payload);
    }
}
