<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReturnsRequest;
use App\Models\Customers;
use App\Models\Returns;
use Illuminate\Http\Request;

class ReturnsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $returns = Returns::with('customer')->get();
        return view('admin.returns.index', compact('returns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customer = Customers::all();
        return view('admin.returns.create', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReturnsRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('attach_document')) {
            $filePath = $request->file('attach_document')->store('documents', 'public');

            $validatedData['attach_document'] = $filePath;
        }

        Returns::create($validatedData);

        return redirect()->route('returns.index')->with('success', 'Returns data added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Returns $returns)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Returns $returns)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Returns $returns)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Returns $returns)
    {
        //
    }
}
