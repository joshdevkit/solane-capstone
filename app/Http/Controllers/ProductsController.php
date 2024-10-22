<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ProductBarcodes;
use App\Models\Products;
use Illuminate\Http\Request;
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
        // Validate the incoming data
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'barcode_symbology' => 'nullable|string',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'required|string', // Expecting a string path
            'serial_number' => 'nullable|array',
            'serial_number.*' => 'nullable|string',
            'product_description' => 'nullable|string',
        ]);

        // Define the temp path and target path for the image
        $tempPath = $validatedData['image'];
        $targetPath = 'images/products/' . basename($tempPath); // Destination path
        $targetFullPath = public_path($targetPath); // Full path in the public directory

        // Check if temp file exists and move it to the public directory
        if (file_exists(storage_path('app/' . $tempPath))) {
            // Ensure the target directory exists
            if (!file_exists(dirname($targetFullPath))) {
                mkdir(dirname($targetFullPath), 0755, true);
            }

            // Move the image from temp storage to the public directory
            rename(storage_path('app/' . $tempPath), $targetFullPath);
        }

        // Count the non-null serial numbers to set as product quantity
        $barcodeCount = count(array_filter($validatedData['serial_number'] ?? []));

        // Create the product record
        $product = Products::create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'barcode_symbology' => $validatedData['barcode_symbology'],
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
        // Validate the incoming request
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'serial_number' => 'nullable|array',
            'serial_number.*' => 'nullable|string',
            'barcode_symbology' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'product_description' => 'nullable|string',
            'replaced_image' => 'nullable|image',
        ]);

        // Check if a new image is uploaded
        if ($request->hasFile('replaced_image')) {
            // Define the path to the old image
            $oldImagePath = public_path($product->product_image);

            // Delete the old image if it exists
            if (file_exists($oldImagePath) && $product->product_image) {
                unlink($oldImagePath);
            }

            // Get the uploaded image
            $image = $request->file('replaced_image');

            // Define a path to save the new image
            $path = 'images/products/'; // Adjust the path as needed

            // Generate a unique filename
            $filename = time() . '_' . $image->getClientOriginalName();

            // Move the uploaded image to the specified path
            $image->move(public_path($path), $filename);

            // Update the product image path in the database
            $product->product_image = $path . $filename;
        }

        // Get the new barcodes from the request
        $newBarcodes = $request->input('serial_number', []);
        $newBarcodes = array_filter($newBarcodes, fn($barcode) => !is_null($barcode) && $barcode !== '');
        // Fetch existing barcodes for the product
        $existingBarcodes = ProductBarcodes::where('product_id', $product->id)->get();
        $existingBarcodeValues = $existingBarcodes->pluck('barcode')->toArray();

        // Find barcodes to add and remove
        $barcodesToAdd = array_diff($newBarcodes, $existingBarcodeValues);
        $barcodesToRemove = array_diff($existingBarcodeValues, $newBarcodes);
        // lets remove the null on new or edited serial, kanina kapang error ka
        $barcodesToAdd = array_filter($barcodesToAdd, fn($barcode) => !is_null($barcode) && $barcode !== '');
        // Count new or edited serial numbers
        $totalNewOrEdited = count($newBarcodes);

        // Update the product quantity based on the total new or edited serial numbers
        // Assuming you have a 'quantity' field in the products table

        // Update remaining product data
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->barcode_symbology = $request->barcode_symbology;
        $product->cost = $request->cost;
        $product->price = $request->price;
        $product->quantity = $totalNewOrEdited;
        $product->product_description = $request->product_description;

        // Save the updated product details
        $product->save();
        // Handle adding new barcodes
        foreach ($barcodesToAdd as $barcode) {
            // Create new barcode if it doesn't exist
            if ($existingBarcodes->where('barcode', $barcode)->isEmpty()) {
                ProductBarcodes::create([
                    'product_id' => $product->id,
                    'barcode' => $barcode,
                ]);
            }
        }

        // Remove old barcodes that are no longer needed
        foreach ($barcodesToRemove as $barcode) {
            ProductBarcodes::where('product_id', $product->id)
                ->where('barcode', $barcode)
                ->delete();
        }

        // Redirect or respond as needed
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
}
