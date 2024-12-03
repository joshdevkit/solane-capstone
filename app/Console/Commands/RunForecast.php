<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ForecastService;
use Illuminate\Support\Facades\Log;

class RunForecast extends Command
{
    protected $signature = 'forecast:run';
    protected $description = 'Run the seasonal forecast when the system is up';

    protected $forecastService;

    public function __construct(ForecastService $forecastService)
    {
        parent::__construct();
        $this->forecastService = $forecastService;
    }

    public function handle()
    {
        // Run the forecast generation
        $forecast = $this->forecastService->generateForecast();

        foreach ($forecast as $dayForecast) {
            Log::info('Forecast for ' . $dayForecast['date'] . ': ' . $dayForecast['predicted_sales']);
        }

        $this->info('Seasonal forecast generated successfully.');
    }
}
