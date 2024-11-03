<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customers::with('orders')->get();
        // dd($customers);
        return view('admin.customers.index', compact('customers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email|max:255',
            'phone_number' => 'required|string|max:15', // Adjust max length as necessary
            'country' => 'required|string|max:100',
            'address' => 'required|string|max:500', // Adjust max length as necessary
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'customer_group' => 'required|string|max:255', // Allow null values
        ]);

        Customers::create($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customers = Customers::find($id);
        return view('admin.customers.show', compact('customers'));
    }


    public function edit(Customers $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customers = Customers::find($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $customers->id,
            'phone_number' => 'required|digits:11',
            'country' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'customer_group' => 'required|string|max:255',
        ]);

        $customers->update($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer details updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customers = Customers::findOrFail($id);
        $customers->delete();
        return redirect()->route('customers.index')->with('success', 'Customer data removed successfully.');
    }
}
