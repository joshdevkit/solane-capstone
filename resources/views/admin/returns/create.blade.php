@extends('layouts.app')

@section('title', 'Create Returns - Sales Info')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Add Returns</h1>
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                <p class="font-bold">Please fill the following criteria:</p>
                                <ul class="list-disc ml-10">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('returns.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="sales_id" value="{{ $id }}">
                        <div class="mb-4">
                            <label for="date_added" class="block text-sm font-medium text-gray-700">Sales Item</label>
                            <select name="sales_item_id" id="sales_item_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Select item to return</option>
                                @foreach ($salesItems as $item)
                                    <option value="{{ $item->productSerial->id }}">
                                        {{ $item->product->name }} ( {{ $item->productSerial->barcode }} )
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="date_added" class="block text-sm font-medium text-gray-700">Sales Product
                                Serial</label>
                            <select name="product_serial" id="product_serial"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Select</option>

                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- sales items to retuns -->



                            <div class="mb-4">
                                <label for="date_added" class="block text-sm font-medium text-gray-700">Date Return</label>
                                <input type="date" name="date_added" id="date_added"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('date_added') }}">
                            </div>
                            <div class="mb-4">
                                <label for="reference_no" class="block text-sm font-medium text-gray-700">Return
                                    No</label>
                                <input type="text" name="reference_no" id="reference_no"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ $returnNo }}">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="mb-4">
                                <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                                <select name="customer_id" id="customer_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Select Supplier</option>
                                    @foreach ($customer as $cust)
                                        <option value="{{ $cust->id }}"
                                            {{ old('customer_id') == $cust->id ? 'selected' : '' }}>
                                            {{ $cust->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="attach_document" class="block text-sm font-medium text-gray-700">Attach
                                    Document</label>
                                <input class="mt-1  w-full bg-gray-300 border-gray-200" type="file"
                                    name="attach_document" id="attach_document">
                            </div>
                        </div>



                        <div class="mb-4">
                            <label for="return_notes" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                name="return_notes" rows="3">{{ old('return_notes') }}</textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Add Returns
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('sales_item_id').addEventListener('change', function() {
            const selectedValue = this.value;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/product-data', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        sales_item_id: selectedValue,
                    }),
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then((result) => {
                    const productSerialDropdown = document.getElementById('product_serial');

                    productSerialDropdown.innerHTML = '<option value="">Select</option>';

                    result.forEach((item) => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.barcode;
                        productSerialDropdown.appendChild(option);
                    });
                })
                .catch((error) => {
                    console.error('Fetch Error:', error);
                });
        });
    </script>
@endsection
