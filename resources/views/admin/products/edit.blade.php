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

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Product
                                            Name</label>
                                        <input type="text" id="name" name="name" value="{{ $products->name }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial
                                            Number</label>
                                        <div class="relative">
                                            <div id="serial_number_tags"
                                                class="flex flex-wrap border border-gray-300 rounded-md shadow-sm bg-white p-1">
                                                @foreach ($products->barcodes as $barcode)
                                                    <div
                                                        class="flex items-center justify-between bg-blue-800 text-white rounded-md px-2 py-0 m-1">
                                                        <input type="text"
                                                            class="bg-blue-800 text-white border-0 serial-input"
                                                            value="{{ $barcode->barcode }}"
                                                            onblur="updateSerialNumber(this)" />
                                                        <button type="button"
                                                            class="ml-2 text-white focus:outline-none remove-serial"
                                                            onclick="removeExistingSerial(this);">&times;</button>
                                                        <input type="hidden" name="serial_number[]"
                                                            value="{{ $barcode->barcode }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="text" id="new_serial_number" name="serial_number[]"
                                                class="mt-1 block w-full border-0 focus:ring-0 bg-transparent text-gray-800"
                                                placeholder="Add a new serial number and press Enter">
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
                                        value="{{ $products->barcode_symbology }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                                    <input class="bg-gray-500 text-white w-full mt-6" type="file" name="replaced_image"
                                        id="new_image" accept="image/*">
                                </div>

                                <div>
                                    <label for="product_description" class="block text-sm font-medium text-gray-700">Product
                                        Description</label>
                                    <textarea id="product_description" name="product_description" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $products->product_description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('new_image').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Get the selected file
            if (file) {
                const reader = new FileReader(); // Create a FileReader to read the file
                reader.onload = function(e) {
                    // Update the src attribute of the current image to the new file
                    document.getElementById('current_image').src = e.target.result;
                };
                reader.readAsDataURL(file); // Read the file as a Data URL (base64)
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('new_serial_number');
            const tagsContainer = document.getElementById('serial_number_tags');

            input.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent form submission on Enter key
                    addSerialNumber();
                }
            });

            function addSerialNumber() {
                const serialNumber = input.value.trim();

                if (serialNumber) {
                    const tag = document.createElement('div');
                    tag.className =
                        "flex items-center justify-between bg-blue-800 text-white rounded-md px-2 py-1 m-1";

                    // Create an input for the new serial number
                    const serialInput = document.createElement('input');
                    serialInput.type = 'text';
                    serialInput.className = 'bg-blue-800 text-white border-0 serial-input';
                    serialInput.value = serialNumber;
                    serialInput.onblur = function() {
                        updateSerialNumber(this);
                    };

                    // Create a hidden input for the serial number to submit with the form
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'serial_number[]';
                    hiddenInput.value = serialNumber;

                    // Create a remove button (X)
                    const removeButton = document.createElement('button');
                    removeButton.innerHTML = '&times;'; // X symbol
                    removeButton.className = 'ml-2 text-white focus:outline-none';
                    removeButton.type = 'button'; // Set type to "button" to prevent form submission
                    removeButton.onclick = function(event) {
                        event.preventDefault(); // Prevent default action of button
                        hiddenInput.remove(); // Remove the hidden input
                        tagsContainer.removeChild(tag); // Remove the tag from the tags container
                    };

                    // Append the input, hidden input, and remove button to the tag
                    tag.appendChild(serialInput);
                    tag.appendChild(hiddenInput); // Keep the hidden input in the tag
                    tag.appendChild(removeButton);

                    // Append the new tag to the tags container
                    tagsContainer.appendChild(tag);

                    // Clear the input field for the next entry
                    input.value = '';
                }
            }
        });

        function updateSerialNumber(element) {
            // Update the hidden input value to reflect the edited value
            const tag = element.parentElement;
            const hiddenInput = tag.querySelector('input[type="hidden"]');
            hiddenInput.value = element.value.trim(); // Update hidden input
        }

        function removeExistingSerial(button) {
            // Get the parent tag (the div containing the serial number)
            const tag = button.parentElement;

            // Remove the hidden input associated with this serial number
            const hiddenInput = tag.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                hiddenInput.remove(); // Remove the hidden input
            }

            // Remove the entire tag from the tags container
            const tagsContainer = document.getElementById('serial_number_tags');
            tagsContainer.removeChild(tag);
        }
    </script>
@endsection
