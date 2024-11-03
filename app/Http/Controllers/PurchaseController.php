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
        $purchase = Purchase::all();
        return view('admin.purchase.index', compact('purchase'));
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
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
