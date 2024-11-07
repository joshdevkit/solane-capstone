@extends('layouts.app')

@section('title', 'LIST RETURNS - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-search-with-icon title="Purchase Records" placeholder="Search for items..." onkeyup="filterTable()" />
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-10" role="alert">
                            <p class="font-bold">{{ session('success') }}</p>
                        </div>
                    @endif
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-xl font-bold">Return List</h1>
                        <a href="{{ route('purchase.create') }}"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                            Add Returns
                        </a>
                    </div>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Reference No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Biller</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($returns as $return)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ date('F d, Y', strtotime($return->date_added)) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $return->reference_no }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $return->biller }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $return->customer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex flex-grow-1">
                                        <a href="{{ route('returns.edit', $return->id) }}"
                                            class="text-blue-500 flex items-center mr-2">
                                            <x-lucide-edit class="w-4 h-4 mr-1" /> Edit
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 ml-2" title="Delete"
                                            onclick="showDeleteModal({{ $return->id }})">
                                            <x-lucide-trash class="w-5 h-5 inline" /> Delete
                                        </button>
                                    </td>
                                    <div id="delete-modal"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                        <div class="bg-white rounded-lg p-6 shadow-lg">
                                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Confirm Delete</h2>
                                            <p class="mb-4">Are you sure you want to delete this returns ?</p>
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
                                    <td colspan="5" class="text-center py-4">No returns found.</td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        let returnsToDelete = null;

        function showDeleteModal(customerId) {
            returnsToDelete = customerId;
            document.getElementById('delete-form').action = `/returns/${customerId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            returnsToDelete = null;
            document.getElementById('delete-modal').classList.add('hidden');
        }
    </script>
@endsection
