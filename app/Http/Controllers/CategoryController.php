<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
        ]);
        $category = new Categories();
        $category->name = $request->name;
        $category->code = $request->code;

        $category->save();

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Categories $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categories $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100',
            'image' => 'nullable|image', // Allow image to be nullable during updates
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Define the path where the image will be stored
            $destinationPath = public_path('images/categories');

            // Get the file and its original name
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Unique filename

            // Move the file to the public folder (images/categories)
            $file->move($destinationPath, $fileName);

            // Save the relative image path
            $category->image = 'images/categories/' . $fileName;
        }

        // Update other category fields
        $category->update([
            'name' => $request->name,
            'code' => $request->code,
            'image' => $category->image, // Keep the image path in the update if it's set
        ]);

        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $category)
    {
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
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
