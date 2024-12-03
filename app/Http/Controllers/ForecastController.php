<?php

namespace App\Http\Controllers;

use App\Services\ForecastService;
use Illuminate\Http\Request;

class ForecastController extends Controller
{

    public function forecast()
    {
        return view('admin.forecasting.index');
    }

    public function generateForecast(ForecastService $forecastService)
    {
        $forecast = $forecastService->generateForecast();

        return response()->json([
            'status' => 'success',
            'forecast' => $forecast
        ]);
    }
}
