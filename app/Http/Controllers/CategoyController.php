<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoyController extends Controller
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
            'image' => 'required|string',
        ]);

        // Decode the image data from the request
        $imageData = json_decode($request->input('image'), true);
        $tempPath = $imageData['path'] ?? null;

        // Check if the temporary path exists
        if ($tempPath && file_exists(storage_path('app/' . $tempPath))) {
            // Define the target path for the image in the public directory
            $targetPath = 'images/categories/' . basename($tempPath);
            $targetFullPath = public_path($targetPath); // Full path to the target directory

            // Ensure the directory exists
            if (!file_exists(dirname($targetFullPath))) {
                mkdir(dirname($targetFullPath), 0755, true);
            }

            // Move the file to the public directory
            if (rename(storage_path('app/' . $tempPath), $targetFullPath)) {
                // Save the category details in the database
                $category = new Categories();
                $category->name = $request->name;
                $category->code = $request->code;
                $category->image = $targetPath; // Store the relative path in the database
                $category->save();

                return redirect()->route('category.index')->with('success', 'Category created successfully!');
            } else {
                return back()->withErrors(['image' => 'Image upload failed.']);
            }
        } else {
            return back()->withErrors(['image' => 'Temporary image path does not exist.']);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Categories $categoy)
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
        // Remove the image from storage if exists
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        // Delete the category
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
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
