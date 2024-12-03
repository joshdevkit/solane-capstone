<?php

namespace App\Services;

use App\Models\Income;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Preprocessing\StandardScaler;
use Carbon\Carbon;

class ForecastService
{
    public function generateForecast()
    {
        // Fetch sales data from the last year, grouped by sales_id and month
        $salesData = Income::where('created_at', '>=', Carbon::now()->subYear())
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m'); // Group by Year-Month
            });

        $samples = [];
        $labels = [];

        foreach ($salesData as $month => $data) {
            // For each unique month, get the first occurrence of the sales_id and its amount
            $firstData = $data->first(); // Get the first entry for this month

            // Use the month as the key
            $monthStart = Carbon::parse($month)->startOfMonth()->format('Y-m-d');
            if (!isset($samples[$monthStart])) {
                $samples[$monthStart] = 0;
            }

            // Add the amount (first occurrence for the month)
            $samples[$monthStart] += (float) $firstData->amount;
        }

        // Prepare the data for training
        $sampledMonths = array_keys($samples); // Get all months
        $monthlySales = array_values($samples); // Get sales data for each month

        // Log for debugging
        \Log::info('Monthly Sales Data: ', $monthlySales);

        // Convert months to numerical values for training (e.g., 1, 2, 3 for Jan, Feb, Mar)
        $numericalMonths = [];
        foreach ($sampledMonths as $key => $month) {
            $date = Carbon::parse($month);
            $numericalMonths[] = [$date->month + ($date->year - 2000) * 12]; // Map months to a single number
        }

        // Log numerical months data for debugging
        \Log::info('Numerical Months Data: ', $numericalMonths);

        // Scale the data using StandardScaler
        $scaler = new StandardScaler();
        $numericalMonths = $scaler->transform($numericalMonths);
        $monthlySales = $scaler->transform([$monthlySales])[0];

        if (count($numericalMonths) < 2) {
            throw new \Exception('Not enough data to train the model');
        }

        // Train the model with the scaled data
        $svr = new SVR(Kernel::RBF, $cost = 1000, $epsilon = 0.001);
        $svr->train($numericalMonths, $monthlySales);

        // Predict sales for the next 12 months
        $forecast = [];
        for ($i = 1; $i <= 12; $i++) {
            $forecastMonth = Carbon::now()->addMonths($i); // Predict for the next 12 months
            $forecastMonthNumerical = [$forecastMonth->month + ($forecastMonth->year - 2000) * 12];

            // Scale the input data
            $forecastMonthNumerical = $scaler->transform($forecastMonthNumerical);

            $predictedSales = $svr->predict($forecastMonthNumerical);
            $predictedSales = $scaler->inverseTransform([[$predictedSales]])[0][0]; // Rescale the predicted value

            $forecast[] = [
                'date' => $forecastMonth->format('Y-m'), // Forecast date in Year-Month format
                'predicted_sales' => $predictedSales // Predicted sales
            ];
        }

        return $forecast;
    }
}
