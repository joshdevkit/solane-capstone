<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ProductBarcodes;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with('category')->get();
        // dd($products);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'barcode_symbology' => 'required|string',
            'net_weight' => 'required|string',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'serial_number' => 'nullable|array',
            'serial_number.*' => 'nullable|string',
            'product_description' => 'nullable|string',
        ]);

        $tempPath = $validatedData['image'];
        $targetPath = 'images/products/' . basename($tempPath);
        $targetFullPath = public_path($targetPath);

        if (file_exists(storage_path('app/' . $tempPath))) {
            if (!file_exists(dirname($targetFullPath))) {
                mkdir(dirname($targetFullPath), 0755, true);
            }

            rename(storage_path('app/' . $tempPath), $targetFullPath);
        }

        $barcodeCount = count(array_filter($validatedData['serial_number'] ?? []));

        $product = Products::create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'barcode_symbology' => $validatedData['barcode_symbology'],
            'net_weight' => $validatedData['net_weight'],
            'cost' => $validatedData['cost'],
            'price' => $validatedData['price'],
            'quantity' => $barcodeCount,
            'product_image' => $targetPath,
            'product_description' => $validatedData['product_description'],
        ]);

        // Save each non-null serial number as a barcode
        if (!empty($validatedData['serial_number'])) {
            foreach ($validatedData['serial_number'] as $barcode) {
                if ($barcode) {
                    ProductBarcodes::create([
                        'product_id' => $product->id,
                        'barcode' => $barcode,
                    ]);
                }
            }
        }

        // Remove the temporary image file
        if (file_exists(storage_path('app/' . $tempPath))) {
            unlink(storage_path('app/' . $tempPath));
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categories = Categories::all();
        $products = Products::find($id);
        return view('admin.products.show', compact('products', 'categories'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Categories::all();
        $products = Products::find($id);
        return view('admin.products.edit', compact('products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'serial_number' => 'nullable|array',
            'serial_number.*' => 'nullable|string',
            'barcode_symbology' => 'required|string|max:255',
            'net_weight' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'product_description' => 'nullable|string',
            'replaced_image' => 'nullable|image',
        ]);

        if ($request->hasFile('replaced_image')) {
            $oldImagePath = public_path($product->product_image);

            if (file_exists($oldImagePath) && $product->product_image) {
                unlink($oldImagePath);
            }

            $image = $request->file('replaced_image');

            $path = 'images/products/';

            $filename = time() . '_' . $image->getClientOriginalName();

            $image->move(public_path($path), $filename);

            $product->product_image = $path . $filename;
        }

        $newBarcodes = $request->input('serial_number', []);
        $newBarcodes = array_filter($newBarcodes, fn($barcode) => !is_null($barcode) && $barcode !== '');
        $existingBarcodes = ProductBarcodes::where('product_id', $product->id)->get();
        $existingBarcodeValues = $existingBarcodes->pluck('barcode')->toArray();

        $barcodesToAdd = array_diff($newBarcodes, $existingBarcodeValues);
        $barcodesToRemove = array_diff($existingBarcodeValues, $newBarcodes);
        $barcodesToAdd = array_filter($barcodesToAdd, fn($barcode) => !is_null($barcode) && $barcode !== '');
        $totalNewOrEdited = count($newBarcodes);


        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->barcode_symbology = $request->barcode_symbology;
        $product->net_weight = $request->net_weight;
        $product->cost = $request->cost;
        $product->price = $request->price;
        $product->quantity = $totalNewOrEdited;
        $product->product_description = $request->product_description;

        $product->save();
        foreach ($barcodesToAdd as $barcode) {
            if ($existingBarcodes->where('barcode', $barcode)->isEmpty()) {
                ProductBarcodes::create([
                    'product_id' => $product->id,
                    'barcode' => $barcode,
                ]);
            }
        }

        foreach ($barcodesToRemove as $barcode) {
            ProductBarcodes::where('product_id', $product->id)
                ->where('barcode', $barcode)
                ->delete();
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        if ($product->product_image && Storage::disk('public')->exists('images/products/' . $product->product_image)) {
            Storage::disk('public')->delete('images/products/' . $product->product_image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,gif|max:2048',
        ]);

        $path = $request->file('image')->store('temp');

        return response()->json(['path' => $path]);
    }


    public function fetch_data(Request $request)
    {
        $excludedBarcodes = DB::table('incomes')->pluck('serial_id');
        $productData = ProductBarcodes::where('id', '!=', $request->input('sales_item_id'))
            ->whereNotIn('id', $excludedBarcodes)
            ->get();

        return response()->json($productData);
    }
}
