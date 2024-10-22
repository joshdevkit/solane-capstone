<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\ProductBarcodes;
use App\Models\Products;
use App\Models\Sales;
use App\Models\SalesItems;
use Illuminate\Http\Request;

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


        $products = Products::all();
        $customers = Customers::all();

        return view('admin.sales.create', compact('products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'date_added' => 'required|date',
            'reference_no' => 'required|string|max:255',
            'biller' => 'required|string|max:255',
            'customer_id' => 'required|exists:customers,id',
            'order_tax' => 'nullable|string|max:255',
            'order_discount' => 'nullable|string|max:255',
            'shipping' => 'nullable|string|max:255',
            'attached_document' => 'required',
            'sale_status' => 'required|string|max:255',
            'payment_status' => 'required|string|max:255',
            'sales_note' => 'required|string|max:1000',
        ], [
            'product_id.required' => 'Please select a product.',
            'product_id.array' => 'Invalid product selection.',
            'product_id.*.exists' => 'One or more selected products do not exist.',
            'date_added.required' => 'Please enter the date.',
            'date_added.date' => 'The date must be a valid date.',
            'reference_no.required' => 'Please enter a reference number.',
            'biller.required' => 'Please enter the biller name.',
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists' => 'The selected customer does not exist.',
            'attached_document.required' => 'Please attach the required document.',
            'attached_document.file' => 'The attached document must be a file.',
            'attached_document.mimes' => 'The attached document must be a file of type: pdf, jpg, jpeg, png.',
            'attached_document.max' => 'The attached document must not be greater than 2MB.',
            'sale_status.required' => 'Please select a sale status.',
            'payment_status.required' => 'Please select a payment status.',
            'sales_note.required' => 'Please enter sales notes.',
        ]);

        $filename = time() . '_' . $request->file('attached_document')->getClientOriginalName();
        $documentPath = public_path('documents');

        if (!file_exists($documentPath)) {
            mkdir($documentPath, 0755, true);
        }

        $request->file('attached_document')->move($documentPath, $filename);

        $sales = Sales::create([
            'date_added' => $validatedData['date_added'],
            'reference_no' => $validatedData['reference_no'],
            'biller' => $validatedData['biller'],
            'customer_id' => $validatedData['customer_id'],
            'order_tax' => $validatedData['order_tax'],
            'order_discount' => $validatedData['order_discount'],
            'shipping' => $validatedData['shipping'],
            'attached_documents' => 'documents/' . $filename,
            'sale_status' => $validatedData['sale_status'],
            'payment_status' => $validatedData['payment_status'],
            'sales_note' => $validatedData['sales_note'],
        ]);

        foreach ($validatedData['product_id'] as $productId) {
            $serialKey = "product_serial_id_$productId";
            if ($request->has($serialKey)) {
                $productSerialIds = $request->input($serialKey);
                foreach ($productSerialIds as $serialId) {
                    SalesItems::create([
                        'sales_id' => $sales->id,
                        'product_id' => $productId,
                        'product_serial_id' => $serialId,
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
}
