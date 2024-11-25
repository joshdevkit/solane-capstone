@extends('layouts.app')

@section('title', 'Create Purchase - Sales Info')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Add Purchase</h1>
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
                    <form action="{{ route('purchase.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="purchase_no" class="block text-sm font-medium text-gray-700">Purchase
                                    No</label>
                                <input type="text" name="purchase_no" id="purchase_no"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('purchase_no') }}">
                            </div>
                            <div class="mb-4">
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                                <select name="supplier_id" id="supplier_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Select Supplier</option>
                                    @foreach ($supplier as $supp)
                                        <option value="{{ $supp->id }}"
                                            {{ old('supplier_id') == $supp->id ? 'selected' : '' }}>
                                            {{ $supp->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="shipping" class="block text-sm font-medium text-gray-700">Shipping</label>
                                <input type="text" name="shipping" id="shipping"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('shipping') }}">
                            </div>

                            <div class="mb-4">
                                <label for="payment" class="block text-sm font-medium text-gray-700">Payment</label>
                                <select name="payment" id="payment"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Select</option>
                                    <option value="Paid">
                                        Paid
                                    </option>
                                    <option value="Pending">
                                        Pending
                                    </option>
                                </select>
                            </div>


                            <div class="mb-4">
                                <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                                <select name="product_id" id="product_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Select</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="text" name="quantity" id="quantity"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('quantity') }}">
                            </div>
                        </div>


                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Add Purchase
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
