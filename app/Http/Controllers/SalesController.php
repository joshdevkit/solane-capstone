<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesRequest;
use App\Models\Customers;
use App\Models\Income;
use App\Models\ProductBarcodes;
use App\Models\Products;
use App\Models\ReturnItems;
use App\Models\Returns;
use App\Models\Sales;
use App\Models\SalesItems;
use Illuminate\Http\Request;
use Phpml\Math\Product;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sales::with(['items.product'])->get();
        // dd($sales);
        return view('admin.sales.index', compact('sales'));
    }

    public function getSerialNumbers($productId)
    {
        $serialNumbers = ProductBarcodes::with('product:id,name')
            ->where('product_id', $productId)
            ->whereDoesntHave('income')
            ->get(['id', 'barcode', 'product_id']);

        $serialNumbersWithProductName = $serialNumbers->map(function ($serial) {
            return [
                'id' => $serial->id,
                'barcode' => $serial->barcode,
                'product_name' => $serial->product->name,
            ];
        });

        return response()->json($serialNumbersWithProductName);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ref = Sales::count();
        if ($ref >= 0) {
            $ref++;
        }
        $refNo = " DR-" . date('Y') . "-00" . $ref;
        $products = Products::all();
        $customers = Customers::all();
        return view('admin.sales.create', compact('products', 'customers', 'refNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesRequest $request)
    {
        $validatedData = $request->validated();

        $filename = null;
        if ($request->hasFile('attached_document')) {
            $filename = time() . '_' . $request->file('attached_document')->getClientOriginalName();
            $documentPath = public_path('documents');

            if (!file_exists($documentPath)) {
                mkdir($documentPath, 0755, true);
            }

            $request->file('attached_document')->move($documentPath, $filename);
        }

        $sales = Sales::create([
            'reference_no' => $validatedData['reference_no'],
            'biller' => $validatedData['biller'],
            'customer_id' => $validatedData['customer_id'],
            'order_tax' => $validatedData['order_tax'],
            'order_discount' => $validatedData['order_discount'],
            'shipping' => $validatedData['shipping'],
            'attached_documents' => $filename ? 'documents/' . $filename : '',
            'sale_status' => $validatedData['sale_status'],
            'payment_status' => $validatedData['payment_status'],
            'sales_note' => $validatedData['sales_note'],
        ]);


        foreach ($validatedData['product_id'] as $productId) {
            $serialKey = "product_serial_id_$productId";
            if ($request->has($serialKey)) {
                $product = Products::find($productId);
                $discount = ($validatedData['order_discount'] === 'pwd' || $validatedData['order_discount'] === 'senior') ? 0.95 : 1;

                foreach ($request->input($serialKey) as $serialId) {
                    $amount = $product->price * $discount;
                    $taxDeduction = ($validatedData['order_tax'] / 100) * $amount;
                    $finalAmount = $amount - $taxDeduction;

                    SalesItems::create([
                        'sales_id' => $sales->id,
                        'product_id' => $productId,
                        'product_serial_id' => $serialId,
                    ]);

                    Income::create([
                        'sales_id' => $sales->id,
                        'product_id' => $productId,
                        'serial_id' => $serialId,
                        'amount' => $finalAmount,
                    ]);
                }
            }
        }

        return redirect()->route('sales.index')->with('success', 'Sale created successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sales = Sales::with(['customer', 'salesItems.product', 'salesItems.productSerial'])->find($id);
        // dd($sales);
        return view('admin.sales.view-sales', compact('sales'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sales = Sales::with(['customer', 'salesItems.product', 'salesItems.productSerials'])->find($id);
        $customers = Customers::all();
        $products = Products::all();

        return view('admin.sales.edit-sales', compact('sales', 'customers', 'products'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sales = Sales::find($id);
        if (!$sales->exists) {
            return redirect()->route('sales.index')->with('error', 'Sales record not found.');
        }

        $request->validate([
            'sale_status' => 'required|string',
            'payment_status' => 'required|string',
        ]);

        $sales->update([
            'sale_status' => $request->input('sale_status'),
            'payment_status' => $request->input('payment_status'),
        ]);

        return redirect()->route('sales.index')->with('success', 'Sales updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sales = Sales::findOrFail($id);
        $sales->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }




    /**
     * pull out method from sales to dapat
     */

    public function pullout()
    {
        $products = Products::all();
        $pullout = Income::with(['product', 'productBarcode', 'sales.customer'])->get();

        return view('admin.purchase.pullout', compact('pullout', 'products'));
    }


    public function updateTareWeight($id, Request $request)
    {
        $request->validate([
            'tare_weight' => 'required|string|min:0',
        ]);

        $income = Income::findOrFail($id);

        $income->tare_weight = $request->tare_weight;
        $income->save();

        return response()->json(['success' => true]);
    }

    public function return_items($id)
    {
        $total = ReturnItems::count();
        $total++;
        $returnNo = "RN" . "-" . date('Y') . "-00" . $total;
        $items = [];
        $salesItems = SalesItems::with(['productSerial', 'product'])->where('sales_id', $id)->get();
        return view('admin.returns.create', compact('salesItems', 'returnNo', 'id'));
    }
}
