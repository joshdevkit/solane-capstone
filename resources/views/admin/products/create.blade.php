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
                                        <label for="barcode_symbology"
                                            class="block text-sm font-medium text-gray-700">Product Code</label>
                                        <input type="text" id="barcode_symbology" name="barcode_symbology"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('barcode_symbology')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
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

                            <table class="table w-full table-auto">
                                <thead>
                                    <tr>
                                        <th class="border-b p-2 text-center">Product ID</th>
                                        <th class="border-b p-2 text-center">Serial No</th>
                                        <th class="border-b p-2 text-center">Net Weight</th>
                                        <th class="border-b p-2 text-center">Length</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamic_product">
                                </tbody>
                            </table>
                            <button type="button" id="add-row"
                                class="mt-2 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Add Serial
                            </button>

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
    </script>


    <script>
        $(document).ready(function() {
            let productCounter = 1;

            $('#category_id').change(function() {
                const categoryId = $(this).val();

                if (categoryId) {
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{ route('get-product-data', '') }}/' + categoryId,
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.exists) {
                                console.log(`Total Quantity: ${data.total_quantity}`);
                                productCounter = data.total_quantity + 1;
                            } else {
                                console.log('No products found for this category.');
                                productCounter = 1;
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching product data:', error);
                        },
                    });
                } else {
                    console.log('Please select a category.');
                }
            });

            $('#add-row').click(function() {
                const productId = String(productCounter).padStart(3, '0');

                const newRow = `
                    <tr>
                        <td class="p-2">
                            <input type="text" name="product_id[]" class="p-2 w-full" value="${productId}" readonly />
                        </td>
                        <td class="p-2">
                            <input type="text" name="serial_no[]" class="p-2 w-full serial-no-input" />
                            <span class="error-text text-red-500 text-xs hidden">This serial number already exists.</span>
                        </td>
                        <td class="p-2">
                            <input type="text" name="net_weight[]" class="p-2 w-full" placeholder="Enter Net Weight" />
                        </td>
                        <td class="p-2">
                            <input type="text" name="length[]" class="p-2 w-full" placeholder="Enter Length" />
                        </td>
                        <td class="p-2">
                            <button class="remove-btn bg-red-500 text-white p-1 rounded-md hover:bg-red-600">
                                <x-lucide-trash class="w-6 h-6" />
                            </button>
                        </td>
                    </tr>
                `;

                $('#dynamic_product').append(newRow);
                productCounter++;

                $('.remove-btn').last().click(function() {
                    $(this).closest('tr').remove();
                });

                $('.serial-no-input').last().on('input', function() {
                    const serialNo = $(this).val().trim();
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');

                    const inputField = $(this);

                    if (serialNo) {
                        $.ajax({
                            url: '{{ route('check-serial-existence') }}',
                            method: 'GET',
                            data: {
                                serial_no: serialNo
                            },
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(data) {
                                if (data.exists) {
                                    inputField.css('border', '1px solid red');
                                    inputField.next('.error-text').removeClass(
                                        'hidden');
                                    inputField.addClass('mt-5')
                                } else {
                                    inputField.css('border', '');
                                    inputField.next('.error-text').addClass('hidden');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error checking serial number:', error);
                            }
                        });
                    } else {
                        inputField.css('border', '');
                        inputField.next('.error-text').addClass('hidden');
                    }
                });

            });
        });
    </script>
@endsection
