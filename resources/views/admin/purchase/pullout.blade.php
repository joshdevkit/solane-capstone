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

                        <div class="flex space-x-4 items-center ml-auto">
                            <div class="relative">
                                <button class="p-2 bg-blue-500 text-white rounded flex justify-between"
                                    onclick="toggleDropdown()">
                                    Filter by Products
                                    <span class="ml-2">&#9662;</span>
                                </button>
                                <div id="productDropdown"
                                    class="absolute bg-white border border-gray-300 mt-2 w-48 rounded hidden">
                                    <ul>
                                        @foreach ($products as $product)
                                            <li onclick="filterByProductName('{{ $product->name }}')"
                                                class="px-4 py-2 cursor-pointer hover:bg-gray-200">
                                                {{ $product->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <button class="p-2 bg-gray-500 text-white rounded" onclick="resetFilter()">Show All</button>

                            <div
                                class="flex items-center border border-gray-300 rounded focus-within:border-blue-500 focus-within:bg-blue-50">
                                <x-lucide-search class="w-5 h-5 text-gray-500 ml-2 focus:text-blue-500" />
                                <input type="text" id="searchInput" placeholder="Search..."
                                    class="p-2 border-0 w-full rounded pl-2 focus:outline-none focus:ring-0 focus:border-transparent focus:bg-blue-50"
                                    onkeyup="filterTable()">
                            </div>
                        </div>
                    </div>




                    <table class="min-w-full bg-white border-2 border-gray-100">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-6 text-xs bg-gray-100 font-medium uppercase tracking-wider border-2 border-gray-200 text-center">
                                    Product</th>
                                <th
                                    class="px-6 py-6 text-xs bg-gray-100 font-medium uppercase tracking-wider border-2 border-gray-200 text-center">
                                    Serial Number</th>
                                <th
                                    class="px-6 py-6 text-xs bg-gray-100 font-medium uppercase tracking-wider border-2 border-gray-200 text-center">
                                    Client Name</th>
                                <th
                                    class="px-6 py-6 text-xs bg-gray-100 font-medium uppercase tracking-wider border-2 border-gray-200 text-center">
                                    Net Weight / Length</th>
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
                                <tr class="record-row" data-product-name="{{ $record->product->name }}"
                                    data-net-weight="{{ $record->productBarcode->net_weight ?? $record->productBarcode->length }}">
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        {{ $record->product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        #{{ $record->productBarcode ? $record->productBarcode->barcode : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        {{ $record->sales && $record->sales->customer ? $record->sales->customer->name : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        {{ $record->productBarcode->net_weight ?? $record->productBarcode->length }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            @if ($record->tare_weight)
                                                {{ $record->tare_weight }}
                                            @elseif ($record->productBarcode->net_weight)
                                                <input type="number" step="0.01" min="0"
                                                    id="tare_weight_{{ $record->id }}"
                                                    value="{{ $record->product->tare_weight }}"
                                                    class="w-34 text-center border-none bg-transparent focus:ring-2 border-2 border-gray-200" />
                                                <button class="bg-blue-500 text-white px-4 py-2 rounded"
                                                    onclick="saveTareWeight({{ $record->id }})">
                                                    <x-lucide-save class="w-5 h-5" />
                                                </button>
                                            @else
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        @if ($record->tare_weight)
                                            @php
                                                $netWeight = $record->product ? $record->productBarcode->net_weight : 0;
                                                $tareWeight = $record->tare_weight ?? 0;
                                                $totalResidual = $netWeight - $tareWeight;
                                            @endphp
                                            {{ number_format($totalResidual, 2) }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-2 border-gray-200 text-center">
                                        {{ $record->sales->reference_no }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No pullout record found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function saveTareWeight(id) {
            var tareWeight = document.getElementById('tare_weight_' + id).value;

            if (isNaN(tareWeight) || tareWeight === "") {
                alert("Please enter a valid tare weight.");
                return;
            }

            fetch("{{ route('update-tareweight', ':id') }}".replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tare_weight: tareWeight
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    location.reload()
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("There was an error updating tare weight.");
                });
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('productDropdown');
            dropdown.classList.toggle('hidden');
        }

        function filterByProductName(productName) {
            const rows = document.querySelectorAll('#tableBody .record-row');

            rows.forEach(row => {
                const product = row.dataset.productName;

                if (product.includes(productName)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            toggleDropdown();
        }
    </script>


@endsection
