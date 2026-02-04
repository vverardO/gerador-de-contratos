<?php

namespace Tests\Unit;

use App\Models\Driver;
use App\Services\SemprejuDriverService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SemprejuDriverServiceTest extends TestCase
{
    private string $driverEndpoint = 'https://driver-endpoint.test/send';

    private string $tokenUrl = 'https://token-endpoint.test/tokens';

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('services.sempreju.endpoint', $this->driverEndpoint);
        Config::set('services.sempreju.token_url', $this->tokenUrl);
        Config::set('services.sempreju.api_key', 'test-api-key');
        Config::set('services.sempreju.token_type', 'driver');
    }

    public function test_send_driver_sends_request_to_endpoint_with_name_and_document(): void
    {
        Http::fake([
            $this->tokenUrl => Http::response(['token' => 'fake-access-token'], 200),
            $this->driverEndpoint => Http::response([], 200),
        ]);

        $driver = new Driver([
            'id' => 1,
            'name' => 'John Doe',
            'document' => '12345678901',
        ]);

        $service = new SemprejuDriverService;
        $result = $service->sendDriver($driver);

        $this->assertTrue($result);

        Http::assertSent(function ($request) {
            if ($request->url() !== $this->driverEndpoint) {
                return false;
            }

            return $request->method() === 'POST'
                && $request->header('Authorization') === ['Bearer fake-access-token']
                && $request->data() === [
                    'name' => 'John Doe',
                    'document' => '12345678901',
                ];
        });
    }

    public function test_send_driver_returns_false_when_endpoint_not_configured(): void
    {
        Config::set('services.sempreju.endpoint', '');

        Http::fake([
            $this->tokenUrl => Http::response(['token' => 'fake-token'], 200),
        ]);

        $driver = new Driver(['id' => 1, 'name' => 'Jane', 'document' => '98765432100']);
        $service = new SemprejuDriverService;

        $this->assertFalse($service->sendDriver($driver));

        Http::assertNotSent(function ($request) {
            return str_contains($request->url(), 'driver-endpoint');
        });
    }

    public function test_send_driver_returns_false_when_driver_endpoint_responds_with_error(): void
    {
        Http::fake([
            $this->tokenUrl => Http::response(['token' => 'fake-token'], 200),
            $this->driverEndpoint => Http::response([], 500),
        ]);

        $driver = new Driver(['id' => 1, 'name' => 'John', 'document' => '11122233344']);
        $service = new SemprejuDriverService;

        $this->assertFalse($service->sendDriver($driver));

        Http::assertSent(function ($request) {
            return $request->url() === $this->driverEndpoint;
        });
    }
}
