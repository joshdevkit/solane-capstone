@extends('layouts.app')

@section('title', 'Update Purchase - Sales Info')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Update Purchase</h1>
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
                    <form action="{{ route('purchase.update', $purchase->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="date_added" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date_added" id="date_added"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                value="{{ old('date_added', $purchase->date_added) }}">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="purchase_no" class="block text-sm font-medium text-gray-700">Purchase No</label>
                                <input type="text" name="purchase_no" id="purchase_no"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('purchase_no', $purchase->purchase_no) }}">
                            </div>
                            <div class="mb-4">
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                                <select name="supplier_id" id="supplier_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Select Supplier</option>
                                    @foreach ($supplier as $supp)
                                        <option value="{{ $supp->id }}"
                                            {{ old('supplier_id', $purchase->supplier_id) == $supp->id ? 'selected' : '' }}>
                                            {{ $supp->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="is_received" class="block text-sm font-medium text-gray-700">Received</label>
                                <select name="is_received" id="is_received"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Select</option>
                                    <option value="1"
                                        {{ old('is_received', $purchase->is_received) == '1' ? 'selected' : '' }}>Received
                                    </option>
                                    <option value="0"
                                        {{ old('is_received', $purchase->is_received) == '0' ? 'selected' : '' }}>Not
                                        Received</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="order_tax" class="block text-sm font-medium text-gray-700">Order Tax</label>
                                <input type="text" name="order_tax" id="order_tax"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('order_tax', $purchase->order_tax) }}">
                            </div>

                            <div class="mb-4">
                                <label for="discount" class="block text-sm font-medium text-gray-700">Discount</label>
                                <input type="text" name="discount" id="discount"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('discount', $purchase->discount) }}">
                            </div>

                            <div class="mb-4">
                                <label for="shipping" class="block text-sm font-medium text-gray-700">Shipping</label>
                                <input type="text" name="shipping" id="shipping"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('shipping', $purchase->shipping) }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="payment" class="block text-sm font-medium text-gray-700">Payment</label>
                            <select name="payment" id="payment"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Select</option>
                                <option value="Paid"
                                    {{ old('payment', $purchase->payment) == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Pending"
                                    {{ old('payment', $purchase->payment) == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                name="notes" rows="3">{{ old('notes', $purchase->notes) }}</textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Purchase
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
