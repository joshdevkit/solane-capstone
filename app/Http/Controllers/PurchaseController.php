<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Models\Products;
use App\Models\Purchase;
use App\Models\Suppliers;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('supplier')->get();
        return view('admin.purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Products::all();
        $supplier = Suppliers::all();
        return view('admin.purchase.create', compact('supplier', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        $validatedData = $request->validated();

        Purchase::create($validatedData);

        return redirect()->route('purchase.index')->with('success', 'Puchase successfully stored');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $supplier = Suppliers::all();
        $product = Products::all();
        return view('admin.purchase.edit', compact('purchase', 'supplier', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validatedData = $request->validate([
            'purchase_no' => 'required|string|max:255',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'supplier_id' => 'required|exists:suppliers,id',
            'shipping' => 'nullable|string',
            'payment' => 'required',
            'notes' => 'nullable|string|max:1000',
        ]);

        $purchase->update([
            'purchase_no' => $validatedData['purchase_no'],
            'product_id' => $validatedData['product_id'],
            'quantity' => $validatedData['quantity'],
            'supplier_id' => $validatedData['supplier_id'],
            'shipping' => $validatedData['shipping'],
            'payment' => $validatedData['payment'],
            'notes' => $validatedData['notes'],
        ]);

        return redirect()->route('purchase.index')->with('success', 'Purchase updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return redirect()->route('purchase.index')->with('success', 'Purchase Record deleted successfully.');
    }
}
