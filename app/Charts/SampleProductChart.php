<?php

namespace App\Charts;

use App\Models\Income;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class SampleProductChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($month)
    {
        $query = Income::with('product')
            ->selectRaw('product_id, SUM(amount) as total_income')
            ->whereMonth('income_date', $month)
            ->groupBy('product_id')
            ->orderByDesc('total_income')
            ->take(5)
            ->get();

        // Ensure the query has results
        if ($query->isEmpty()) {
            return $this->chart->barChart()
                ->setTitle('Best Products of the Month')
                ->setSubtitle('No products found for the selected month')
                ->addData('Income', [])
                ->setXAxis([]);
        }

        $productNames = $query->map(function ($income) {
            return $income->product->name;
        })->toArray();

        $incomes = $query->pluck('total_income')->toArray();

        return $this->chart->barChart()
            ->setTitle('Best Products of the Month')
            ->setSubtitle('Top 5 products by income')
            ->addData('Income', $incomes)
            ->setXAxis($productNames);
    }
}
