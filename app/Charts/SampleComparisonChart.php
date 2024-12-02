<?php

namespace App\Charts;

use App\Models\Income;
use App\Models\Product;
use App\Models\ProductBarcode;
use App\Models\ProductBarcodes;
use App\Models\Products;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class SampleComparisonChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($month = null): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        // Initialize arrays for revenue and cost values, filled with 0
        $revenueValues = array_fill(1, 12, 0);
        $costValues = array_fill(1, 12, 0);

        // Query to get revenue data
        $revenueDataQuery = Income::selectRaw('MONTH(created_at) as month, product_id, SUM(amount) as total_revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'product_id');

        // If a month is selected, filter by that month
        if ($month) {
            $revenueDataQuery->whereMonth('created_at', $month);
        }

        $revenueData = $revenueDataQuery->get();

        // Process the revenue and cost data
        foreach ($revenueData as $income) {
            $product = Products::find($income->product_id);
            $cost = $product ? $product->cost : 0;

            // Fetch quantity of the product (you may need to adjust this based on your database schema)
            $quantity = ProductBarcodes::where('product_id', $income->product_id)->count();
            $totalCost = $cost * $quantity;

            // Round revenue and cost values to 2 decimal places and accumulate them
            $revenueValues[$income->month] += round($income->total_revenue, 2);
            $costValues[$income->month] += round($totalCost, 2);
        }

        // If a specific month is selected, use that month's values
        if ($month) {
            $revenueValues = [$revenueValues[$month] ?? 0];
            $costValues = [$costValues[$month] ?? 0];
            $monthNames = [$months[$month]];
        } else {
            // Otherwise, get values for all months
            $revenueValues = array_map(function ($value) {
                return round($value, 2);
            }, array_values($revenueValues));
            $costValues = array_map(function ($value) {
                return round($value, 2);
            }, array_values($costValues));
            $monthNames = array_values($months);
        }

        // Build and return the chart
        return $this->chart->lineChart()
            ->setTitle('Revenue vs Cost')
            ->setSubtitle($month ? "Data for {$months[$month]}" : 'Monthly Revenue and Cost Comparison')
            ->addData('Revenue', $revenueValues)
            ->addData('Cost', $costValues)
            ->setXAxis($monthNames);
    }
}
