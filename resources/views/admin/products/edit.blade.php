@extends('layouts.app')

@section('title', 'EDIT PRODUCT - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-20">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                        <p class="font-bold">Please fill the following errors:</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-xl font-bold">Show Product</h1>

                    </div>
                    <form action="{{ route('products.update', ['product' => $products->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="max-h-100 overflow-y-auto">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="mb-4">
                                    <label for="category_id"
                                        class="block text-sm font-medium text-gray-700">Category</label>
                                    <select id="category_id" name="category_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $products->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Product
                                            Name</label>
                                        <input type="text" id="name" name="name" value="{{ $products->name }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="barcode_symbology"
                                            class="block text-sm font-medium text-gray-700">Product
                                            Code</label>
                                        <input type="text" id="barcode_symbology" name="barcode_symbology"
                                            value="{{ $products->barcode_symbology }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                                <div>
                                    <label for="product_barcodes" class="block text-sm font-medium text-gray-700">Product
                                        Barcodes</label>
                                    <div class="mt-2">
                                        <table class="table-auto w-full border-collapse border border-gray-300"
                                            id="barcodeTable">
                                            <thead>
                                                <tr class="bg-gray-100">
                                                    <th
                                                        class="border border-gray-300 px-4 py-2 text-left text-sm font-medium">
                                                        Product ID</th>
                                                    <th
                                                        class="border border-gray-300 px-4 py-2 text-left text-sm font-medium">
                                                        Serial Number</th>
                                                    <th
                                                        class="border border-gray-300 px-4 py-2 text-left text-sm font-medium">
                                                        Net Weight</th>
                                                    <th
                                                        class="border border-gray-300 px-4 py-2 text-left text-sm font-medium">
                                                        Length</th>
                                                    <th
                                                        class="border border-gray-300 px-4 py-2 text-left text-sm font-medium">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($products->barcodes as $barcode)
                                                    <tr>
                                                        <td class="border border-gray-300 px-4 py-2 text-sm">
                                                            <input type="text"
                                                                name="barcodes[{{ $barcode->id }}][product_code]"
                                                                value="{{ $barcode->product_code }}"
                                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                        </td>
                                                        <td class="border border-gray-300 px-4 py-2 text-sm">
                                                            <input type="text"
                                                                name="barcodes[{{ $barcode->id }}][barcode]"
                                                                value="{{ $barcode->barcode }}"
                                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                        </td>
                                                        <td class="border border-gray-300 px-4 py-2 text-sm">
                                                            <input type="number"
                                                                name="barcodes[{{ $barcode->id }}][net_weight]"
                                                                value="{{ $barcode->net_weight }}"
                                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                step="0.01">
                                                        </td>
                                                        <td class="border border-gray-300 px-4 py-2 text-sm">
                                                            <input type="number"
                                                                name="barcodes[{{ $barcode->id }}][length]"
                                                                value="{{ $barcode->length }}"
                                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                step="0.01">
                                                        </td>
                                                        <td class="border border-gray-300 px-4 py-2 text-sm text-center">
                                                            <button type="button"
                                                                class="text-red-500 remove-row">Remove</button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5"
                                                            class="border border-gray-300 px-4 py-2 text-center text-sm text-gray-500">
                                                            No barcodes available for this product.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-4">
                                        <button type="button" id="addRow"
                                            class="bg-green-600 text-white px-4 py-2 rounded">Add More</button>
                                    </div>
                                </div>



                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="cost" class="block text-sm font-medium text-gray-700">Cost
                                            Price</label>
                                        <input type="number" id="cost" name="cost" value="{{ $products->cost }}"
                                            step="0.01"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="price" class="block text-sm font-medium text-gray-700">Selling
                                            Price</label>
                                        <input type="number" id="price" name="price" value="{{ $products->price }}"
                                            step="0.01"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="current_image" class="block text-gray-700">Current Image</label>
                                    <div>
                                        <img id="current_image" src="{{ asset($products->product_image) }}"
                                            alt="{{ $products->name }}" class="mt-1 max-h-32">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="new_image">Replace Image</label>
                                    <input class="bg-gray-500 text-white w-full mt-6" type="file"
                                        name="replaced_image" id="new_image" accept="image/*">
                                </div>
                                <div>
                                    <label for="product_description"
                                        class="block text-sm font-medium text-gray-700">Product
                                        Description</label>
                                    <textarea id="product_description" name="product_description" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $products->product_description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update
                                Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('new_image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('current_image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#addRow').click(function() {
                const newRow = `
            <tr>
                <td class="border border-gray-300 px-4 py-2 text-sm">
                    <input type="text" name="barcodes[new][product_code][]"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </td>
                <td class="border border-gray-300 px-4 py-2 text-sm">
                    <input type="text" name="barcodes[new][barcode][]"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </td>
                <td class="border border-gray-300 px-4 py-2 text-sm">
                    <input type="number" name="barcodes[new][net_weight][]"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01">
                </td>
                <td class="border border-gray-300 px-4 py-2 text-sm">
                    <input type="number" name="barcodes[new][length][]"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01">
                </td>
                <td class="border border-gray-300 px-4 py-2 text-sm text-center">
                    <button type="button" class="text-red-500 remove-row">Remove</button>
                </td>
            </tr>`;
                $('#barcodeTable tbody').append(newRow);
            });

            $('#barcodeTable').on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
