@extends('layouts.app')

@section('title', 'SHOW PRODUCT - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-20">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-xl font-bold">Show Product</h1>
                    </div>

                    <div class="max-h-100 overflow-y-auto">
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Category Dropdown -->
                            <div class="mb-4">
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <select id="category_id" name="category_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    disabled>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $products->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Product Name & Serial Number -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Product
                                        Name</label>
                                    <input type="text" id="name" name="name" value="{{ $products->name }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        disabled>
                                </div>
                                <div>
                                    <label for="barcode_symbology" class="block text-sm font-medium text-gray-700">Product
                                        Code</label>
                                    <input type="text" id="barcode_symbology" name="barcode_symbology"
                                        value="{{ $products->barcode_symbology }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        disabled>
                                </div>
                            </div>
                            <div>
                                <label for="product_barcodes" class="block text-sm font-medium text-gray-700">Product
                                    Barcodes</label>
                                <div class="mt-2">
                                    <table class="table-auto w-full border-collapse border border-gray-300">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium">
                                                    Product ID</th>
                                                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium">
                                                    Product Serial</th>
                                                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium">
                                                    Net Weight</th>
                                                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium">
                                                    Length</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($products->barcodes as $barcode)
                                                <tr>
                                                    <td class="border border-gray-300 px-4 py-2 text-sm">
                                                        {{ $barcode->product_code }}
                                                    </td>
                                                    <td class="border border-gray-300 px-4 py-2 text-sm">
                                                        {{ $barcode->barcode }}
                                                    </td>
                                                    <td class="border border-gray-300 px-4 py-2 text-sm">
                                                        {{ $barcode->net_weight ?? 'N/A' }}
                                                    </td>
                                                    <td class="border border-gray-300 px-4 py-2 text-sm">
                                                        {{ $barcode->length ?? 'N/A' }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3"
                                                        class="border border-gray-300 px-4 py-2 text-center text-sm text-gray-500">
                                                        No barcodes available for this product.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>



                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="cost" class="block text-sm font-medium text-gray-700">Cost Price</label>
                                    <input type="number" id="cost" name="cost" value="{{ $products->cost }}"
                                        step="0.01"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        disabled>
                                </div>

                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Selling
                                        Price</label>
                                    <input type="number" id="price" name="price" value="{{ $products->price }}"
                                        step="0.01"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        disabled>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="block text-gray-700">Image</label>
                                <div>
                                    @if ($products->product_image)
                                        <img src="{{ asset($products->product_image) }}" alt="{{ $products->name }}"
                                            class="mt-1 max-h-32 object-contain">
                                    @else
                                        <div class="text-gray-500 italic">No image available</div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label for="product_description" class="block text-sm font-medium text-gray-700">Product
                                    Description</label>
                                <textarea id="product_description" name="product_description" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    disabled>{{ $products->product_description }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('products.index') }}"
                            class="inline-flex bg-blue-800 justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
