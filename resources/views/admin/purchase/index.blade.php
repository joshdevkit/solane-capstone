@extends('layouts.app')

@section('title', 'LIST PURCHASE - Dashboard')

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
                        <h1 class="text-xl font-bold">Purchase List</h1>
                        <a href="{{ route('purchase.create') }}"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                            Add Purchase
                        </a>
                    </div>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Reference No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Supplier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Purchase Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Payment Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($purchases as $purchase)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ date('F d, Y', strtotime($purchase->date_added)) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $purchase->purchase_no }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $purchase->supplier->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($purchase->is_purchase == 1)
                                            <span class="bg-green-500 text-white py-1 px-2 rounded">Received</span>
                                        @else
                                            <span class="bg-yellow-500 text-white py-1 px-2 rounded">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($purchase->total, 2) }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($purchase->payment == 'Pending')
                                            <span class="bg-orange-500 text-white py-1 px-2 rounded">Pending</span>
                                        @else
                                            <span class="bg-green-500 text-white py-1 px-2 rounded">Paid</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap flex flex-grow-1">
                                        <a href="{{ route('purchase.edit', $purchase->id) }}"
                                            class="text-blue-500 flex items-center mr-2">
                                            <x-lucide-edit class="w-4 h-4 mr-1" /> Edit
                                        </a>
                                        <form action="{{ route('purchase.destroy', $purchase->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 flex items-center">
                                                <x-lucide-trash class="w-4 h-4 inline mr-1" /> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No purchases found.</td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
