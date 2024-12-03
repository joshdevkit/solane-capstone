<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Purchase;
use App\Models\ReturnItems;
use App\Models\Sales;
use App\Models\SalesItems;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


    public function returns()
    {
        return view('admin.returns.reports');
    }

    public function generate_returns(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


        $returns = ReturnItems::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with('serial')
            ->get();

        $totalReturns = ReturnItems::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();


        $pdf = Pdf::loadView(
            'admin.returns.downloadable',
            [
                'returns' => $returns,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'totalReturns' => $totalReturns
            ]
        );
        return $pdf->download('returns_reports.pdf');
    }


    public function purchase()
    {
        return view('admin.purchase.reports');
    }

    public function generate_purchase(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $purchase = Purchase::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with(['supplier', 'products'])
            ->get();

        $totalAmount = 0;
        $totalQuantity = 0;

        foreach ($purchase as $p) {
            $totalAmount += $p->products->price * $p->quantity;
            $totalQuantity += $p->quantity;
        }

        $pdf = Pdf::loadView(
            'admin.purchase.downloadable',
            [
                'purchase' => $purchase,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'totalAmount' => $totalAmount,
                'totalQuantity' => $totalQuantity,
            ]
        );

        return $pdf->download('purchase_reports.pdf');
    }


    public function sales()
    {
        return view('admin.sales.reports');
    }

    public function generate_sales(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $sales = DB::table('sales')
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
            ->leftJoin('sales_items', 'sales.id', '=', 'sales_items.sales_id')
            ->leftJoin('product_barcodes', 'sales_items.product_serial_id', '=', 'product_barcodes.id')
            ->leftJoin('products', 'sales_items.product_id', '=', 'products.id')
            ->select(
                'sales.id as sales_id',
                'sales.reference_no',
                'sales.payment_status',
                'sales.biller',
                'sales.created_at',
                'customers.name as customer_name',
                DB::raw('GROUP_CONCAT(DISTINCT sales_items.product_id) as product_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT sales_items.product_serial_id) as product_serial_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT product_barcodes.barcode) as barcodes'),
                DB::raw('SUM(products.price * COUNT(sales_items.product_serial_id)) OVER (PARTITION BY sales_items.product_id, sales.id) as total_amount')
            )
            ->whereDate('sales.created_at', '>=', $startDate)
            ->whereDate('sales.created_at', '<=', $endDate)
            ->orderBy('sales.created_at', 'asc')
            ->groupBy('sales.id', 'sales.reference_no', 'customers.name', 'sales.payment_status', 'sales.biller', 'sales.created_at')
            ->get();


        $totalRevenue = $sales->sum('total_amount');
        $totalPaidCount = $sales->where('payment_status', 'paid')->count();
        $totalUnpaidCount = $sales->where('payment_status', 'unpaid')->count();
        $totalCancelledAndPendingCount = $sales->whereIn('sales_status', ['pending', 'cancelled'])->count();

        $pdf = Pdf::loadView(
            'admin.sales.downloadable',
            [
                'sales' => $sales,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'totalRevenue' => $totalRevenue,
                'totalPaidCount' => $totalPaidCount,
                'totalUnpaidCount' => $totalUnpaidCount,
                'totalCancelledAndPendingCount' => $totalCancelledAndPendingCount,
            ]
        );

        return $pdf->download('sales_reports.pdf');
    }
}
