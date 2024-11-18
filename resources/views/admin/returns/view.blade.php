@extends('layouts.app')

@section('title', 'LIST RETURNS - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-10" role="alert">
                            <p class="font-bold">{{ session('success') }}</p>
                        </div>
                    @endif
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-xl font-bold">Return Record</h1>
                    </div>
                    <div class="flex justify-between items-center border-b pb-4 mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Return Receipt</h1>
                            <p class="text-sm text-gray-600">Return ID: #{{ $data->id }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Date: {{ date('F d, Y', strtotime($data->date_return)) }}</p>
                            <p class="text-sm text-gray-600">Reference No: {{ $data->sales->reference_no }}</p>
                            <p class="text-sm text-gray-600">Return No: {{ $data->return_no }}</p>
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Product Details</h2>
                        <div class="flex justify-between border-b py-2">
                            <span class="text-sm text-gray-600">Product Serial:</span>
                            <span class="font-medium text-gray-900">{{ $data->serial->barcode }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-600">Product Name:</span>
                            <span class="font-medium text-gray-900">{{ $data->serial->product->name }}</span>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Customer Information</h2>
                        <div class="flex justify-between border-b py-2">
                            <span class="text-sm text-gray-600">Customer Name:</span>
                            <span class="font-medium text-gray-900">{{ $data->customer->name }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-600">Customer Email:</span>
                            <span class="font-medium text-gray-900">{{ $data->customer->email }}</span>
                        </div>
                    </div>

                    <!-- Return Details -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Return Details</h2>
                        <div class="flex justify-between border-b py-2">
                            <span class="text-sm text-gray-600">Date Added:</span>
                            <span
                                class="font-medium text-gray-900">{{ date('F d, Y', strtotime($data->created_at)) }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-600">Return Notes:</span>
                            <span class="font-medium text-gray-900">{{ $data->remarks }}</span>
                        </div>
                    </div>

                    <!-- Footer -->
                    {{-- <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">Thank you for your business!</p>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>


@endsection
