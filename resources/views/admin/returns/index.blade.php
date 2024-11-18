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
                    </div>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date Return
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Reference No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Product Serial
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Customer</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($returns as $return)
                                <tr class="hover:bg-gray-100 cursor-pointer"
                                    onclick="window.location='{{ url('/returns/' . $return->id) }}'">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ date('F d, Y', strtotime($return->date_return)) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $return->sales->reference_no }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $return->serial->product->name }} {{ $return->serial->barcode }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $return->customer->name }}
                                    </td>
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
