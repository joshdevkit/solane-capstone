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
    public function edit($id)
    {
        $returns = Returns::find($id);
        $customer = Customers::all();
        return view('admin.returns.edit', compact('returns', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date_added' => 'required|date',
            'reference_no' => 'required|string',
            'customer_id' => 'required|integer',
            'order_tax' => 'required|string',
            'discount' => 'required|string',
            'shipping' => 'required|string',
            'attach_document' => 'nullable|file',
            'return_notes' => 'nullable|string',
        ]);

        $returns = Returns::findOrFail($id);

        if ($request->hasFile('attach_document')) {
            if ($returns->attach_document && file_exists(public_path($returns->attach_document))) {
                unlink(public_path($returns->attach_document));
            }

            $file = $request->file('attach_document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documents'), $fileName);

            $returns->attach_document = $fileName;
        }

        $returns->date_added = $request->input('date_added');
        $returns->reference_no = $request->input('reference_no');
        $returns->customer_id = $request->input('customer_id');
        $returns->order_tax = $request->input('order_tax');
        $returns->discount = $request->input('discount');
        $returns->shipping = $request->input('shipping');
        $returns->return_notes = $request->input('return_notes');

        $returns->save();

        return redirect()->route('returns.index')->with('success', 'Return updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $returns = Returns::findOrFail($id);

        if ($returns->attach_document && file_exists(public_path($returns->attach_document))) {
            unlink(public_path($returns->attach_document));
        }

        $returns->delete();

        return redirect()->route('returns.index')->with('success', 'Return deleted successfully.');
    }
}