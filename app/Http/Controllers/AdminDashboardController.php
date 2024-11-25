<?php

namespace App\Http\Controllers;

use App\Charts\SampleComparisonChart;
use App\Charts\SampleProductChart;
use App\Models\Income;
use App\Models\ProductBarcodes;
use App\Models\Products;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{

    public function sendLowStockNotifications()
    {
        $lastNotificationTime = Cache::get('last_low_stock_notification_time');

        if (!$lastNotificationTime || now()->diffInHours($lastNotificationTime) >= 24) {
            $lowStockProducts = Products::where('quantity', '<', 20)->get();
            if ($lowStockProducts->isNotEmpty()) {
                $users = User::whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'Sales');
                })->get();

                foreach ($users as $user) {
                    $user->notify(new LowStockNotification($lowStockProducts));
                }
                Cache::put('last_low_stock_notification_time', now());
            }
        }

        return response()->json(['message' => 'Low stock notifications sent successfully!']);
    }

    public function index(SampleProductChart $productChart, SampleComparisonChart $comparisonChart)
    {

        $topProducts = Income::with('product')
            ->select('incomes.product_id', DB::raw('COUNT(incomes.product_id) as total_items_sold'))
            ->groupBy('incomes.product_id')
            ->orderByDesc('total_items_sold')
            ->limit(3)
            ->get();

        $bestItems = Income::with('product')
            ->select('product_id', DB::raw('SUM(amount) as total_items_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_items_sold')
            ->limit(3)
            ->get();

        $totalSales = Income::sum('amount');
        $totalCost = ProductBarcodes::with('product')
            ->get()
            ->sum(function ($barcode) {
                return $barcode->product->cost;
            });

        $totalProductSold = Income::distinct('serial_id')->count('serial_id');

        $selectedMonth = request('month', date('n'));
        $selectedComparisonMonth = request('month_revenue_vs_cost', null);

        $productChartData = $productChart->build($selectedMonth);
        $comparisonChartData = $comparisonChart->build($selectedComparisonMonth);

        return view('dashboard', [
            'productChart' => $productChartData,
            'comparisonChart' => $comparisonChartData,
            'selectedMonth' => $selectedMonth,
            'selectedComparisonMonth' => $selectedComparisonMonth,
            'totalSales' => $totalSales,
            'totalCost' => $totalCost,
            'totalProductSold' => $totalProductSold,
            'topProducts' => $topProducts,
            'bestItems' => $bestItems
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
