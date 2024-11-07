@extends('layouts.app')

@section('title', 'LIST PULL OUT RECORD - Dashboard')

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
                        <h1 class="text-xl font-bold">Pullout Records</h1>
                        <div
                            class="mb-4 flex items-center border border-gray-300 rounded focus-within:border-blue-500 focus-within:bg-blue-50">
                            <x-lucide-search class="w-5 h-5 text-gray-500 ml-2 focus:text-blue-500" />
                            <input type="text" id="searchInput" placeholder="Search..."
                                class="p-2 border-0 w-full rounded pl-2 focus:outline-none focus:ring-0 focus:border-transparent focus:bg-blue-50"
                                onkeyup="filterTable()">
                        </div>
                    </div>
                    <table class="min-w-full bg-white border-2 border-gray-100">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-6 text-xs bg-gray-100 font-medium uppercase tracking-wider border-2 border-gray-200 text-center">
                                    Serial Number</th>
                                <th
                                    class="px-6 py-6 text-xs bg-gray-100 font-medium uppercase tracking-wider border-2 border-gray-200 text-center">
                                    Client Name</th>
                                <th
                                    class="px-6 py-6 text-xs bg-gray-100 font-medium uppercase tracking-wider border-2 border-gray-200 text-center">
                                    Net Weight</th>
                                <th
                                    class="px-6 py-6 text-xs bg-gray-100 font-medium uppercase tracking-wider border-2 border-gray-200 text-center">
                                    Tare Weight</th>
                                <th
                                    class="px-6 py-6 text-xs bg-gray-100 font-medium uppercase tracking-wider border-2 border-gray-200 text-center">
                                    Total Residual</th>
                                <th
                                    class="px-6 py-6 text-xs bg-gray-100 font-medium uppercase tracking-wider border-2 border-gray-200 text-center">
                                    Purchase Number</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($pullout as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        #{{ $record->productBarcode ? $record->productBarcode->barcode : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        {{ $record->sales && $record->sales->customer ? $record->sales->customer->name : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        {{ $record->product ? $record->product->net_weight : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        {{ $record->product ? $record->product->tare_weight : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        {{ $record->sales->reference_no }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No pullout record found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>
        function filterTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const rows = document.getElementById("tableBody").getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                let row = rows[i];
                let textContent = row.textContent.toLowerCase();
                row.style.display = textContent.includes(filter) ? "" : "none";
            }
        }
    </script>
@endsection
