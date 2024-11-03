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

        $revenueValues = array_fill(1, 12, 0);
        $costValues = array_fill(1, 12, 0);

        $revenueDataQuery = Income::selectRaw('MONTH(income_date) as month, product_id, SUM(amount) as total_revenue')
            ->whereYear('income_date', date('Y'))
            ->groupBy('month', 'product_id');

        if ($month) {
            $revenueDataQuery->whereMonth('income_date', $month);
        }

        $revenueData = $revenueDataQuery->get();

        foreach ($revenueData as $income) {
            $product = Products::find($income->product_id);
            $cost = $product ? $product->cost : 0;
            $quantity = ProductBarcodes::where('product_id', $income->product_id)->count();
            $totalCost = $cost * $quantity;

            $revenueValues[$income->month] += $income->total_revenue;
            $costValues[$income->month] += $totalCost;
        }

        if ($month) {
            $revenueValues = [$revenueValues[$month] ?? 0];
            $costValues = [$costValues[$month] ?? 0];
            $monthNames = [$months[$month]];
        } else {
            $revenueValues = array_values($revenueValues);
            $costValues = array_values($costValues);
            $monthNames = array_values($months);
        }

        return $this->chart->lineChart()
            ->setTitle('Revenue vs Cost')
            ->setSubtitle($month ? "Data for {$months[$month]}" : 'Monthly Revenue and Cost Comparison')
            ->addData('Revenue', $revenueValues)
            ->addData('Cost', $costValues)
            ->setXAxis($monthNames);
    }
}
