@extends('layouts.app')

@section('title', 'Create Delivery Receipt - Dashboard')

@section('content')
<div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
    <div class="w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Delivery Form</h1>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('delivery-receipt.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                        <div>
                            <label for="date" class="block text-lg font-semibold text-gray-700">Date:</label>
                            <input id="date" type="date" name="date" class="mt-1 p-2 border rounded-md w-full"
                                required />
                        </div>
                        <div>
                            <label for="invoice_number" class="block text-lg font-semibold text-gray-700">Invoice
                                #:</label>
                            <input id="invoice_number" type="text" name="invoice_number"
                                class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                            @error('invoice_number')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="invoice_to" class="block text-lg font-semibold text-gray-700">Invoice
                                To:</label>
                            <input id="invoice_to" type="text" name="invoice_to"
                                class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value"
                                value="{{ old('invoice_to') }}" />
                            @error('invoice_to')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="attention" class="block text-lg font-semibold text-gray-700">Attention:</label>
                            <input id="attention" type="text" name="attention" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter value" value="{{ old('attention') }}" />
                            @error('attention')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>
                    <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-4 p-6">
                        <div>
                            <label for="po_number" class="block text-lg font-semibold text-gray-700">PO No.:</label>
                            <input id="po_number" type="text" name="po_number" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter value" />
                        </div>
                        <div>
                            <label for="terms" class="block text-lg font-semibold text-gray-700">Terms:</label>
                            <input id="terms" type="text" name="terms" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter value" />
                        </div>
                        <div>
                            <label for="rep" class="block text-lg font-semibold text-gray-700">Rep:</label>
                            <input id="rep" type="text" name="rep" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter value" />
                        </div>
                        <div>
                            <label for="ship_date" class="block text-lg font-semibold text-gray-700">Ship Date:</label>
                            <input id="ship_date" type="date" name="ship_date" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter value" />
                        </div>
                    </div>

                    <hr>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 p-6">
                        <div>
                            <label for="fob" class="block text-lg font-semibold text-gray-700">FOB:</label>
                            <input id="fob" type="text" name="fob" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter value" />
                        </div>
                        <div>
                            <label for="project" class="block text-lg font-semibold text-gray-700">PROJECT:</label>
                            <input id="project" type="text" name="project" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter value" />
                        </div>

                    </div>
                    <hr>
                    <button id="add-row" type="button"
                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add Row</button>
                    <table class="table mt-3 w-full table-auto">
                        <thead>
                            <tr>
                                <th class="border-b p-2 text-center">Qty</th>
                                <th class="border-b p-2 text-center">ITEM</th>
                                <th class="border-b p-2 text-center">DESCRIPTION</th>
                                <th class="border-b p-2 text-center">Price Each</th>
                                <th class="border-b p-2 text-center">Amount</th>
                                <th class="border-b p-2 text-center"></th>
                            </tr>
                        </thead>
                        <tbody id="generated_data">
                            <tr>
                                <td><input
                                        class="qty-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        type="text" name="qty[]" placeholder="Enter Qty"></td>
                                <td><input
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        type="text" name="item[]" placeholder="Enter Item"></td>
                                <td><input
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        type="text" name="description[]" placeholder="Enter Description"></td>
                                <td><input
                                        class="price-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        type="text" name="price_each[]" placeholder="Enter Price"></td>
                                <td><input
                                        class="amount-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        type="text" name="amount[]" placeholder="Amount" disabled></td>
                                <td>
                                    <button type="button"
                                        class="remove-row bg-red-500 text-white p-1 rounded-md hover:bg-red-600"><x-lucide-trash
                                            class='w-6 h-6' /></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Submit Buttons -->
                    <div class="mt-4 flex space-x-4">
                        <button type="submit" name="action" value="save_and_download"
                            class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                            Save and Download PDF
                        </button>
                        <button type="submit" name="action" value="save_only"
                            class="p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Save Only
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addRowButton = document.getElementById('add-row');
        const tbody = document.getElementById('generated_data');

        const createNewRow = () => `
            <tr>
                <td><input class="qty-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                    type="text" name="qty[]" placeholder="Enter Qty"></td>
                <td><input class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                    type="text" name="item[]" placeholder="Enter Item"></td>
                <td><input class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                    type="text" name="description[]" placeholder="Enter Description"></td>
                <td><input class="price-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                    type="text" name="price_each[]" placeholder="Enter Price"></td>
                <td><input class="amount-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                    type="text" name="amount[]" placeholder="Amount" disabled></td>
                <td>
                    <button type="button" class="remove-row bg-red-500 text-white p-1 rounded-md hover:bg-red-600"><x-lucide-trash class='w-6 h-6' /></button>
                </td>
            </tr>
        `;

        addRowButton.addEventListener('click', function () {
            const newRow = document.createElement('tr');
            newRow.innerHTML = createNewRow();
            tbody.appendChild(newRow);
            addRowListeners(newRow);
        });

        const addRowListeners = (row) => {
            const qtyInput = row.querySelector('.qty-input');
            const priceInput = row.querySelector('.price-input');
            const amountInput = row.querySelector('.amount-input');
            const removeButton = row.querySelector('.remove-row');

            const updateAmount = () => {
                const qty = parseFloat(qtyInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                if (!isNaN(qty) && !isNaN(price)) {
                    amountInput.value = (qty * price).toFixed(2);
                } else {
                    amountInput.value = '';
                }
            };

            const validateNumberInput = (e) => {
                if (!/^\d*\.?\d*$/.test(e.target.value)) {
                    e.target.value = e.target.value.slice(0, -1);
                }
            };

            qtyInput.addEventListener('input', () => {
                validateNumberInput(event);
                updateAmount();
            });

            priceInput.addEventListener('input', () => {
                validateNumberInput(event);
                updateAmount();
            });

            removeButton.addEventListener('click', function () {
                row.remove();
            });
        };

        // Add listeners for the initial row
        document.querySelectorAll('#generated_data tr').forEach(addRowListeners);
    });
</script>

@endsection