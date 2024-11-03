<?php

namespace App\Http\Controllers;

use App\Models\Forms;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = Forms::all();
        return view('admin.forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.forms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'form_name' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:csv,xlsx',
        ]);

        $file = $request->file('file_path');

        $destinationPath = 'forms';

        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path($destinationPath), $filename);

        $filePath = $destinationPath . '/' . $filename;
        Forms::create(['form_name' => $request->form_name, 'file_path' => $filePath]);

        return redirect()->route('uploaded-forms.index')->with('success', 'Files Uploaded Successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Forms $forms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forms $forms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forms $forms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forms $forms)
    {
        //
    }
}
