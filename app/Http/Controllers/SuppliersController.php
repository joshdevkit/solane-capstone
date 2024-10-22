<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Suppliers::all();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email|max:255',
            'phone_number' => 'required|string|max:15',
            'gst_number' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:255',
        ]);

        Suppliers::create($validatedData);

        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $suppliers = Suppliers::find($id);
        return view('admin.suppliers.show', compact('suppliers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $suppliers = Suppliers::find($id);
        return view('admin.suppliers.edit', compact('suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customers = Suppliers::find($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:suppliers,email,' . $customers->id,
            'phone_number' => 'required|digits:11',
            'gst_number' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:255',
        ]);

        $customers->update($validatedData);

        return redirect()->route('suppliers.index')->with('success', 'Supplier details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customers = Suppliers::findOrFail($id);
        $customers->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supliers data removed successfully.');
    }
}
