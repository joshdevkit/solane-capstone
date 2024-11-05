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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="date_added" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="date_added" id="date_added"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('date_added') }}">
                            </div>
                            <div class="mb-4">
                                <label for="reference_no" class="block text-sm font-medium text-gray-700">Reference
                                    No</label>
                                <input type="text" name="reference_no" id="reference_no"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('reference_no') }}">
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
                                <label for="order_tax" class="block text-sm font-medium text-gray-700">Order Tax</label>
                                <input type="text" name="order_tax" id="order_tax"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('order_tax') }}">
                            </div>

                            <div class="mb-4">
                                <label for="discount" class="block text-sm font-medium text-gray-700">Discount</label>
                                <input type="text" name="discount" id="discount"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ old('discount') }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="shipping" class="block text-sm font-medium text-gray-700">Shipping</label>
                            <input type="text" name="shipping" id="shipping"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                value="{{ old('shipping') }}">
                        </div>
                        <div class="mb-4">
                            <label for="attach_document" class="block text-sm font-medium text-gray-700">Attach
                                Document</label>
                            <input class="w-full bg-gray-300 border-gray-200" type="file" name="attach_document"
                                id="attach_document">
                        </div>

                        <div class="mb-4">
                            <label for="return_notes" class="block text-sm font-medium text-gray-700">Return Notes</label>
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
@endsection
