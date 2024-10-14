@extends('layouts.app')

@section('title', 'ADD PRODUCTS - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-20">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-xl font-bold">Add Product</h1>
                    </div>
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="max-h-100 overflow-y-auto">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="mb-4">
                                    <label for="category_id"
                                        class="block text-sm font-medium text-gray-700">Category</label>
                                    <select id="category_id" name="category_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Product
                                            Name</label>
                                        <input type="text" id="name" name="name"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial
                                            Number</label>
                                        <div class="relative">
                                            <div id="serial_number_tags"
                                                class="flex flex-wrap border border-gray-300 rounded-md shadow-sm bg-white p-1">
                                                <!-- Tags will be appended here -->
                                            </div>
                                            <input type="text" id="serial_number" name="serial_number[]"
                                                class="mt-1 block w-full border-0 focus:ring-0 bg-transparent text-gray-800"
                                                placeholder="Click here to add a serial number and press Enter">
                                        </div>
                                        @error('serial_number')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div>
                                    <label for="barcode_symbology" class="block text-sm font-medium text-gray-700">Barcode
                                        Symbology</label>
                                    <input type="text" id="barcode_symbology" name="barcode_symbology"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('barcode_symbology')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="cost" class="block text-sm font-medium text-gray-700">Cost
                                            Price</label>
                                        <input type="number" id="cost" name="cost" step="0.01"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('cost')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="price" class="block text-sm font-medium text-gray-700">Selling
                                            Price</label>
                                        <input type="number" id="price" name="price" step="0.01"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('price')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="image" class="block text-gray-700">Image</label>
                                    <input type="file" name="image" id="image" class="filepond mt-1"
                                        accept="image/*">
                                </div>
                                <div>
                                    <label for="product_description" class="block text-sm font-medium text-gray-700">Product
                                        Description</label>
                                    <textarea id="product_description" name="product_description" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    @error('product_description')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Product
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        const inputElement = document.querySelector('input[name="image"]');
        const pond = FilePond.create(inputElement);

        FilePond.setOptions({
            server: {
                process: {
                    url: '{{ route('product.upload') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        console.log(response);
                        const result = JSON.parse(response);
                        return result.path;
                    },
                    onerror: (response) => {
                        console.error("Upload failed:", response);
                        return response;
                    }
                },
                revert: null
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('serial_number');
            const tagsContainer = document.getElementById('serial_number_tags');

            input.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    addSerialNumber();
                }
            });

            function addSerialNumber() {
                const serialNumber = input.value.trim();

                if (serialNumber) {
                    const tag = document.createElement('div');
                    tag.className =
                        "flex items-center justify-between bg-blue-800 text-white rounded-md px-2 py-1 m-1";
                    tag.innerText = serialNumber;

                    // Create a hidden input for the serial number
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'serial_number[]';
                    hiddenInput.value = serialNumber; // Set the value to the valid serial number

                    // Create a remove button (X)
                    const removeButton = document.createElement('button');
                    removeButton.innerHTML = '&times;'; // X symbol
                    removeButton.className = 'ml-2 text-white focus:outline-none';

                    // Add event listener to the remove button
                    removeButton.addEventListener('click', function() {
                        // Remove the tag from the container
                        tagsContainer.removeChild(tag);
                    });

                    // Append the hidden input and remove button to the tag
                    tag.appendChild(hiddenInput);
                    tag.appendChild(removeButton);

                    // Append the new tag to the tags container
                    tagsContainer.appendChild(tag);

                    // Clear the input field for the next entry
                    input.value = '';
                }
            }
        });
    </script>
@endsection
