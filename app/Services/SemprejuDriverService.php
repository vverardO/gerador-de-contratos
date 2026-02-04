<?php

namespace App\Services;

use App\Models\Driver;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SemprejuDriverService
{
    private ?string $accessToken = null;

    public function sendDriver(Driver $driver): bool
    {
        $endpoint = config('services.sempreju.endpoint');

        if (empty($endpoint)) {
            Log::warning('Sempreju endpoint not configured. Skipping driver sync.');

            return false;
        }

        $token = $this->getAccessToken();

        if ($token === null) {
            return false;
        }

        $response = Http::timeout(10)
            ->withToken($token)
            ->post($endpoint, [
                'name' => $driver->name,
                'document' => $driver->document,
            ]);

        if (! $response->successful()) {
            Log::error('Failed to send driver to Sempreju', [
                'driver_id' => $driver->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        }

        return true;
    }

    private function getAccessToken(): ?string
    {
        if ($this->accessToken !== null) {
            return $this->accessToken;
        }

        $tokenUrl = config('services.sempreju.token_url');
        $apiKey = config('services.sempreju.api_key');
        $type = config('services.sempreju.token_type');

        if (empty($tokenUrl) || empty($apiKey)) {
            Log::warning('Sempreju token URL or API key not configured.');

            return null;
        }

        $response = Http::timeout(10)
            ->asJson()
            ->withHeaders(['x-api-key' => $apiKey])
            ->post($tokenUrl, ['type' => $type]);

        if (! $response->successful()) {
            Log::error('Failed to fetch Sempreju access token', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        }

        $body = $response->json();
        $this->accessToken = $body['token'] ?? $body['access_token'] ?? $body['accessToken'] ?? null;

        if ($this->accessToken === null) {
            Log::error('Sempreju token response missing token field', ['body' => $body]);

            return null;
        }

        return $this->accessToken;
    }
}
