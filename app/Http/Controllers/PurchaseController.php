<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
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
        $supplier = Suppliers::all();
        return view('admin.purchase.create', compact('supplier'));
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
        return view('admin.purchase.edit', compact('purchase', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validatedData = $request->validate([
            'date_added' => 'required|date',
            'purchase_no' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'is_received' => 'required|boolean',
            'order_tax' => 'nullable|string',
            'discount' => 'nullable|string',
            'shipping' => 'nullable|string',
            'payment' => 'required|string|in:Paid,Pending',
            'notes' => 'nullable|string|max:1000',
        ]);

        $purchase->update([
            'date_added' => $validatedData['date_added'],
            'purchase_no' => $validatedData['purchase_no'],
            'supplier_id' => $validatedData['supplier_id'],
            'is_received' => $validatedData['is_received'],
            'order_tax' => $validatedData['order_tax'],
            'discount' => $validatedData['discount'],
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
