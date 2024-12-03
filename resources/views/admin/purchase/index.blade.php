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
                    <x-search-with-icon title="Purchase Records" placeholder="Search for items..." onkeyup="filterTable()" />
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-xl font-bold">Purchase List</h1>
                        <div class="flex justify-end items-center mb-4">
                            <a href="{{ route('generate-purchase-reports') }}"
                                class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 mr-4">
                                Generate Report
                            </a>
                            <a href="{{ route('purchase.create') }}"
                                class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                                Add Purchase
                            </a>
                        </div>

                    </div>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Reference No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Supplier</th>

                                {{-- <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total</th> --}}

                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($purchases as $purchase)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ date('F d, Y', strtotime($purchase->created_at)) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $purchase->purchase_no }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $purchase->supplier->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex flex-grow-1">
                                        <a href="{{ route('purchase.edit', $purchase) }}"
                                            class="text-blue-500 flex items-center mr-2">
                                            <x-lucide-edit class="w-4 h-4 mr-1" /> Edit
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 ml-2" title="Delete"
                                            onclick="showDeleteModal({{ $purchase->id }})">
                                            <x-lucide-trash class="w-5 h-5 inline" /> Delete
                                        </button>
                                    </td>
                                    <div id="delete-modal"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                        <div class="bg-white rounded-lg p-6 shadow-lg">
                                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Confirm Delete</h2>
                                            <p class="mb-4">Are you sure you want to delete this purchase record ?</p>
                                            <div class="flex justify-end space-x-4">
                                                <button class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600"
                                                    onclick="hideDeleteModal()">
                                                    Cancel
                                                </button>
                                                <form id="delete-form" action="" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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

    <script>
        let purchaseToDelete = null;

        function showDeleteModal(customerId) {
            purchaseToDelete = customerId;
            document.getElementById('delete-form').action = `/purchase/${customerId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            purchaseToDelete = null;
            document.getElementById('delete-modal').classList.add('hidden');
        }
    </script>
@endsection
