@extends('layouts.app')

@section('title', 'EDIT SALES - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6 text-gray-900">Update Sales</h1>

                <form action="{{ route('sales.update', ['sale' => $sales->id]) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="date_added" class="block text-sm font-medium text-gray-700">Date Added:</label>
                        <input type="date" name="date_added" value="{{ old('date_added', $sales->date_added) }}" disabled
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label for="reference_no" class="block text-sm font-medium text-gray-700">Reference No:</label>
                        <input type="text" name="reference_no" value="{{ old('reference_no', $sales->reference_no) }}"
                            disabled
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label for="biller" class="block text-sm font-medium text-gray-700">Biller:</label>
                        <input type="text" name="biller" value="{{ old('biller', $sales->biller) }}" disabled
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer:</label>
                        <select name="customer_id" disabled
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ $customer->id == $sales->customer_id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="order_tax" class="block text-sm font-medium text-gray-700">Order Tax:</label>
                        <input type="text" name="order_tax" value="{{ old('order_tax', $sales->order_tax) }}" disabled
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label for="order_discount" class="block text-sm font-medium text-gray-700">Order Discount:</label>
                        <input type="text" name="order_discount"
                            value="{{ old('order_discount', $sales->order_discount) }}" disabled
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label for="shipping" class="block text-sm font-medium text-gray-700">Shipping:</label>
                        <input type="text" name="shipping" value="{{ old('shipping', $sales->shipping) }}" disabled
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="sale_status" class="block text-sm font-medium text-gray-700">Sale Status:</label>
                            <select name="sale_status" id="sale_status"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Select Status</option>
                                <option value="completed"
                                    {{ old('sale_status', $sales->sale_status) == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="pending"
                                    {{ old('sale_status', $sales->sale_status) == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="canceled"
                                    {{ old('sale_status', $sales->sale_status) == 'canceled' ? 'selected' : '' }}>
                                    Canceled
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment
                                Status:</label>
                            <select name="payment_status" id="payment_status"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Select Status</option>
                                <option value="paid"
                                    {{ old('payment_status', $sales->payment_status) == 'paid' ? 'selected' : '' }}>
                                    Paid
                                </option>
                                <option value="unpaid"
                                    {{ old('payment_status', $sales->payment_status) == 'unpaid' ? 'selected' : '' }}>
                                    Unpaid
                                </option>
                                <option value="refunded"
                                    {{ old('payment_status', $sales->payment_status) == 'refunded' ? 'selected' : '' }}>
                                    Refunded
                                </option>
                            </select>
                        </div>
                    </div>



                    <h3 class="text-lg font-semibold mt-6">Sales Items</h3>
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Product</th>
                                    <th class="py-3 px-6 text-left">Serial Number</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($sales->salesItems as $item)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6">
                                            <select disabled name="product_id[]"
                                                class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $product->id == $item->product_id ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="py-3 px-6">
                                            <select name="product_serial_id[]"
                                                class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                @foreach ($item->productSerials as $serial)
                                                    <option value="{{ $serial->id }}"
                                                        {{ $serial->id == $item->product_serial_id ? 'selected' : '' }}>
                                                        {{ $serial->barcode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Update Sale</button>
                </form>
            </div>
        </div>
    </div>
@endsection
