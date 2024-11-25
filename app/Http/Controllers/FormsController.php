<?php

namespace App\Http\Controllers;

use App\Models\Forms;
use App\Models\Income;
use App\Models\Products;
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


    public function pullout_form()
    {
        return view('admin.forms.create-pullout');
    }

    public function getPulloutProducts()
    {
        $pulloutProducts = Income::with(['productBarcode' => function ($query) {
            $query->where('net_weight', '50.00');
        }])
            ->whereHas('productBarcode', function ($query) {
                $query->where('net_weight', '50.00');
            })
            ->where('tare_weight', '!=', null)
            ->get();

        return response()->json($pulloutProducts);
    }


    public function delivery_form()
    {
        // $products = Products::with(['barcodes' => function ($query) {
        //     $query->where('net_weight', '50.00');
        // }])
        //     ->whereHas('barcodes', function ($query) {
        //         $query->where('net_weight', '50.00');
        //     })
        //     ->get();

        return view('admin.forms.delivery-form');
    }

    public function getProductsForDelivery()
    {
        $products = Products::with(['barcodes' => function ($query) {
            $query->where('net_weight', '>', 50.00);
        }])
            ->whereHas('barcodes', function ($query) {
                $query->where('net_weight', '>', 50.00);
            })
            ->get();

        return response()->json($products);
    }




    public function delivery_receipt()
    {
        return view('admin.forms.delivery-receipt');
    }
}
