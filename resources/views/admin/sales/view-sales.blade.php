@extends('layouts.app')

@section('title', 'SHOW SALES - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Sales Invoice</h1>
                    <div class="border-b mb-4 pb-2">
                        <h2 class="text-lg font-semibold">Customer Information</h2>
                        <p class="text-gray-700"><strong>Name:</strong> {{ $sales->customer->name }}</p>
                        <p class="text-gray-700"><strong>Date Added:</strong>
                            {{ date('F d, Y h:i A', strtotime($sales->created_at)) }}</p>
                        <p class="text-gray-700"><strong>Reference No:</strong> {{ $sales->reference_no }}</p>
                        <p class="text-gray-700"><strong>Sale Status:</strong> {{ $sales->sale_status }}</p>
                        <p class="text-gray-700">
                            <strong>Attached Documents:
                                {{ str_replace('documents/', '', $sales->attached_documents) }}
                            </strong>
                        </p>
                        @php
                            $documentPath = $sales->attached_documents;
                        @endphp
                        @if ($documentPath)
                            <a href="{{ asset($documentPath) }}" class="text-blue-500 underline" download>
                                Download Attached Document
                            </a>
                        @else
                            <span>No documents attached.</span>
                        @endif
                    </div>

                    <h3 class="text-lg font-semibold mb-2">Sales Items</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Product Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Serial Number</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($sales->salesItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <a class="text-blue-500 "
                                            href="{{ route('products.show', ['product' => $item->product->id]) }}">{{ $item->product->name }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->productSerial->barcode }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
