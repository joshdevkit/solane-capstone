<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ProductBarcodes;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'product_id' => 'required|array',
            'product_id.*' => 'required|string',
            'serial_no' => 'nullable|array',
            'serial_no.*' => 'nullable|string',
            'net_weight' => 'nullable|array',
            'net_weight.*' => 'nullable|string',
            'length' => 'nullable|array',
            'length.*' => 'nullable|string',
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

        $totalQuantity = count(array_filter($validatedData['serial_no'] ?? []));

        $product = Products::create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'barcode_symbology' => $validatedData['barcode_symbology'],
            'cost' => $validatedData['cost'],
            'price' => $validatedData['price'],
            'quantity' => $totalQuantity,
            'product_image' => $targetPath,
            'product_description' => $validatedData['product_description'],
        ]);

        if (!empty($validatedData['serial_no'])) {
            foreach ($validatedData['serial_no'] as $index => $serialNo) {
                if ($serialNo) {
                    ProductBarcodes::create([
                        'product_id' => $product->id,
                        'product_code' => $validatedData['product_id'][$index] ?? null,
                        'barcode' => $serialNo,
                        'net_weight' => $validatedData['net_weight'][$index] ?? null,
                        'length' => $validatedData['length'][$index] ?? null,
                    ]);
                }
            }
        }

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
        $products = Products::with('barcodes')->find($id);
        return view('admin.products.show', compact('products', 'categories'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Categories::all();
        $products = Products::with('barcodes')->find($id);
        return view('admin.products.edit', compact('products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
        $generalRules = [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'barcode_symbology' => 'required|string|max:255',
            'cost' => 'required|string',
            'price' => 'required|string',
            'product_description' => 'nullable|string',
            'replaced_image' => 'nullable|image',
            'product_id.*' => 'required|string|max:255',
            'serial_no.*' => 'required|string|max:255',
        ];

        $barcodes = $request->input('barcodes', []);
        if (isset($barcodes['new'])) {
            foreach ($barcodes['new']['product_code'] as $index => $product_code) {
                $barcodes['new_' . $index] = [
                    'product_code' => $product_code,
                    'barcode' => $barcodes['new']['barcode'][$index] ?? null,
                    'net_weight' => $barcodes['new']['net_weight'][$index] ?? null,
                    'length' => $barcodes['new']['length'][$index] ?? null,
                ];
            }
            unset($barcodes['new']);
        }

        $barcodeRules = [];
        foreach ($barcodes as $key => $barcode) {
            $barcodeRules["barcodes.$key.product_code"] = 'nullable|string';
            $barcodeRules["barcodes.$key.barcode"] = 'nullable|string';
            $barcodeRules["barcodes.$key.net_weight"] = 'nullable|string';
            $barcodeRules["barcodes.$key.length"] = 'nullable|string';
        }

        $validator = Validator::make($request->merge(['barcodes' => $barcodes])->all(), array_merge($generalRules, $barcodeRules));

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

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

        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->barcode_symbology = $request->barcode_symbology;
        $product->cost = $request->cost;
        $product->price = $request->price;
        $product->product_description = $request->product_description;
        $product->save();

        $existingBarcodes = ProductBarcodes::where('product_id', $product->id)->get();
        $existingIds = $existingBarcodes->pluck('id')->toArray();
        $submittedIds = array_keys(array_filter($barcodes, fn($k) => is_numeric($k), ARRAY_FILTER_USE_KEY));

        $idsToDelete = array_diff($existingIds, $submittedIds);
        ProductBarcodes::whereIn('id', $idsToDelete)->delete();

        foreach ($barcodes as $id => $data) {
            if (isset($data['barcode']) && $data['barcode'] !== null) {
                if (is_numeric($id) && in_array($id, $existingIds)) {
                    ProductBarcodes::where('id', $id)->update([
                        'product_code' => $data['product_code'] ?? null,
                        'barcode' => $data['barcode'],
                        'net_weight' => $data['net_weight'] ?? null,
                        'length' => $data['length'] ?? null,
                    ]);
                } else {
                    ProductBarcodes::create([
                        'product_id' => $product->id,
                        'product_code' => $data['product_code'] ?? null,
                        'barcode' => $data['barcode'],
                        'net_weight' => $data['net_weight'] ?? null,
                        'length' => $data['length'] ?? null,
                    ]);
                }
            }
        }

        $product->quantity = ProductBarcodes::where('product_id', $product->id)->count();
        $product->save();

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


    public function getProducts($categoryId)
    {
        $totalQuantity = Products::where('category_id', $categoryId)->first();
        $exists = $totalQuantity->quantity > 0;

        return response()->json([
            'exists' => $exists,
            'total_quantity' => $totalQuantity->quantity,
        ]);
    }


    public function checkSerialExistence(Request $request)
    {
        $serialNo = $request->input('serial_no');
        $exists = ProductBarcodes::where('barcode', $serialNo)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function check_code(Request $request)
    {
        $symbology = $request->input('symbology');

        $numericSymbology = preg_replace('/\D/', '', $symbology);

        $existsInSymbologies = Products::where('barcode_symbology', $symbology)->exists();
        $existsInBarcodes = ProductBarcodes::where('product_code', $numericSymbology)->exists();

        $exists = $existsInSymbologies || $existsInBarcodes;

        return response()->json([
            'exists' => $exists,
            'exists_in_symbologies' => $existsInSymbologies,
            'exists_in_barcodes' => $existsInBarcodes,
        ]);
    }
}
