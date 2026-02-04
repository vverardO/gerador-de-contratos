<?php

namespace App\Observers;

use App\Models\Driver;
use App\Services\SemprejuDriverService;

class DriverObserver
{
    public function __construct(
        private SemprejuDriverService $semprejuDriverService
    ) {}

    public function created(Driver $driver): void
    {
        $this->semprejuDriverService->sendDriver($driver);
    }
}
