<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\SalesItems;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    protected $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function inventory()
    {
        $inventory = [];
        return view('admin.products.reports', compact('inventory'));
    }


    public function generate_inventory(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $salesItems = SalesItems::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        $salesCounts = [];

        foreach ($salesItems as $item) {
            $key = $item->product_id . '-' . $item->product_serial_id;

            if (!isset($salesCounts[$item->product_id])) {
                $salesCounts[$item->product_id] = [];
            }

            $salesCounts[$item->product_id][$item->product_serial_id] = true;
        }

        $totalSalesByProduct = [];
        foreach ($salesCounts as $productId => $serials) {
            $totalSalesByProduct[$productId] = count($serials);
        }

        $productIds = array_keys($totalSalesByProduct);

        $products = Products::whereIn('id', $productIds)->get();
        $productNames = $products->pluck('name', 'id')->toArray();

        $inventory = [];
        $totalProducts = 0;
        $productsInStock = 0;
        $lowStockProducts = 0;
        $outOfStockProducts = 0;

        foreach ($products as $product) {
            $totalProducts++;

            $totalSales = $totalSalesByProduct[$product->id] ?? 0;
            $remainingStock = $product->quantity - $totalSales;
            $stocksTotal = $remainingStock * $product->price;

            if ($remainingStock > 0) {
                $productsInStock++;
            }

            if ($remainingStock > 0 && $remainingStock < 20) {
                $lowStockProducts++;
            }

            if ($remainingStock == 0) {
                $outOfStockProducts++;
            }

            $purchaseByProduct = Purchase::where('product_id', $product->id)
                ->sum('quantity');

            $inventory[] = [
                'product_id'   => $product->id,
                'product_name' => $productNames[$product->id],
                'total_sales'  => $totalSales,
                'stocks_total' => $stocksTotal,
                'remaining_stock' => $remainingStock,
                'purchase_by_product' => $purchaseByProduct,
            ];
        }

        $pdf = Pdf::loadView('admin.products.downloadable', [
            'inventory' => $inventory,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalProducts' => $totalProducts,
            'productsInStock' => $productsInStock,
            'lowStockProducts' => $lowStockProducts,
            'outOfStockProducts' => $outOfStockProducts
        ]);

        return $pdf->download('inventory_report.pdf');
    }
}
