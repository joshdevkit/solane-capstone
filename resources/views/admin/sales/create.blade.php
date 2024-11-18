@extends('layouts.app')

@section('title', 'Create Sale - Sales Info')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Add Sale</h1>
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
                    <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @php
                            $selectedProducts = old('product_id', []);
                        @endphp

                        @csrf
                        @php
                            $selectedProducts = old('product_id', []);
                        @endphp

                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Select
                                Product(s)</label>
                            <select id="product_id" name="product_id[]"
                                class="product-select2 mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                multiple="multiple">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ in_array($product->id, old('product_id', [])) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4" id="serial_numbers_container">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- <div class="mb-4">
                                <label for="date_added" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="text" name="date_added" id="date_added"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ $date }}">
                            </div> --}}

                            <div class="mb-4">
                                <label for="reference_no" class="block text-sm font-medium text-gray-700">Reference
                                    No</label>
                                <input readonly type="text" name="reference_no" id="reference_no"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ $refNo }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="biller" class="block text-sm font-medium text-gray-700">Biller</label>
                                <input type="text" name="biller" id="biller"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('biller') }}">
                            </div>

                            <div class="mb-4">
                                <label for="customer_id" class="block text-sm font-medium text-gray-700">Select
                                    Customer</label>
                                <select name="customer_id" id="customer_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="order_tax" class="block text-sm font-medium text-gray-700">Order Tax</label>
                                <input type="text" name="order_tax" id="order_tax"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('order_tax') }}">
                            </div>

                            <div class="mb-4">
                                <label for="order_discount" class="block text-sm font-medium text-gray-700">Order
                                    Discount</label>
                                <select name="order_discount" id="order_discount"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="none" {{ old('order_discount') == 'none' ? 'selected' : '' }}>None
                                    </option>
                                    <option value="pwd" {{ old('order_discount') == 'pwd' ? 'selected' : '' }}>PWD (5%)
                                    </option>
                                    <option value="senior" {{ old('order_discount') == 'senior' ? 'selected' : '' }}>Senior
                                        Citizen (5%)</option>
                                </select>
                            </div>

                        </div>

                        <div class="mb-4">
                            <label for="shipping" class="block text-sm font-medium text-gray-700">Shipping</label>
                            <input type="text" name="shipping" id="shipping"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                value="{{ old('shipping') }}">
                        </div>

                        <div class="mb-4">
                            <label for="attached_document" class="block text-sm font-medium text-gray-700">Attached
                                Document</label>
                            <input type="file" name="attached_document" id="attached_document"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>



                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="sale_status" class="block text-sm font-medium text-gray-700">Sale
                                    Status</label>
                                <select name="sale_status" id="sale_status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Select Status</option>
                                    <option value="completed" {{ old('sale_status') == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="pending" {{ old('sale_status') == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment
                                    Status</label>
                                <select name="payment_status" id="payment_status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Select Status</option>
                                    <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                    </option>
                                    <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>
                                        Unpaid</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="sales_note" class="block text-sm font-medium text-gray-700">Sales Note</label>
                            <textarea name="sales_note" id="sales_note" rows="4"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('sales_note') }}</textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create Sale
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serialNumbersContainer = document.getElementById('serial_numbers_container');

            $('#product_id').select2({
                placeholder: "Select Products",
                allowClear: true,
                width: '100%'
            }).on('change', function(e) {
                const selectedProductIds = $(this).val();
                updateSerialNumberDropdowns(selectedProductIds);
            });

            function updateSerialNumberDropdowns(selectedProductIds) {
                const existingDropdowns = Array.from(serialNumbersContainer.children);

                existingDropdowns.forEach(dropdownContainer => {
                    const productId = dropdownContainer.dataset.productId;
                    if (!selectedProductIds.includes(productId)) {
                        dropdownContainer.remove();
                    }
                });

                selectedProductIds.forEach(productId => {
                    if (!existingDropdowns.some(dropdown => dropdown.dataset.productId === productId)) {
                        fetchSerialNumbersForProduct(productId);
                    }
                });
            }

            function fetchSerialNumbersForProduct(productId) {
                fetch(`/get-serial-numbers/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            addSerialNumberDropdown(productId, data);
                        } else {
                            addNoSerialMessageDropdown(productId);
                        }
                    })
                    .catch(error => console.error('Error fetching serial numbers:', error));
            }

            function addSerialNumberDropdown(productId, serials) {
                const dropdownContainer = document.createElement('div');
                dropdownContainer.className = 'mb-4';
                dropdownContainer.dataset.productId = productId;

                const productName = serials[0].product_name;

                const productLabel = document.createElement('label');
                productLabel.className = 'block text-sm font-medium text-gray-700';
                productLabel.textContent = `Serial Numbers for ${productName}`;

                const serialDropdown = document.createElement('select');
                serialDropdown.name = `product_serial_id_${productId}[]`;
                serialDropdown.className =
                    'serial-select2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200';
                serialDropdown.multiple = true;

                serials.forEach(serial => {
                    const option = document.createElement('option');
                    option.value = serial.id;
                    option.textContent = serial.barcode;
                    serialDropdown.appendChild(option);
                });

                dropdownContainer.appendChild(productLabel);
                dropdownContainer.appendChild(serialDropdown);
                serialNumbersContainer.appendChild(dropdownContainer);

                $(serialDropdown).select2({
                    placeholder: "Select Serial Numbers",
                    allowClear: true,
                    width: '100%'
                });
            }

            function addNoSerialMessageDropdown(productId) {
                const dropdownContainer = document.createElement('div');
                dropdownContainer.className = 'mb-4';
                dropdownContainer.dataset.productId = productId;

                const productLabel = document.createElement('label');
                productLabel.className = 'block text-sm font-medium text-gray-700';
                productLabel.textContent =
                    `Serial Numbers for Product ID ${productId}`;

                const serialDropdown = document.createElement('select');
                serialDropdown.name = `product_serial_id_${productId}[]`;
                serialDropdown.className =
                    'serial-select2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200';
                serialDropdown.disabled = true;

                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No Available Stock';
                serialDropdown.appendChild(option);

                dropdownContainer.appendChild(productLabel);
                dropdownContainer.appendChild(serialDropdown);
                serialNumbersContainer.appendChild(dropdownContainer);

                $(serialDropdown).select2({
                    placeholder: "No Available Stock",
                    allowClear: true,
                    width: '100%'
                });
            }
        });
    </script>
@endsection
