@extends('layouts.app')

@section('title', 'LIST SALES - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full overflow-x-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-10" role="alert">
                            <p class="font-bold">{{ session('success') }}</p>
                        </div>
                    @endif
                    <h1 class="text-xl font-bold mb-4">Sales List</h1>
                    <table class="min-w-full divide-y table-auto">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Customer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Paid</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Biller</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Tax</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($sales as $sale)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ date('F d, Y', strtotime($sale->date_added)) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $sale->customer->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap relative">
                                        @php
                                            $totalPrice = $sale->items->sum(function ($item) {
                                                return $item->product->price ?? 0;
                                            });
                                        @endphp

                                        @if ($sale->order_discount === 'pwd' || $sale->order_discount === 'senior')
                                            <span
                                                class="absolute top-0 right-0 bg-red-500 text-white text-xs font-semibold py-1 px-2 rounded">{{ ucfirst($sale->order_discount) }}</span>
                                            <span class="line-through text-gray-400">
                                                {{ number_format($totalPrice, 2) }}
                                            </span>
                                            <span class="font-semibold">
                                                {{ number_format($totalPrice * 0.95, 2) }}
                                            </span>
                                        @else
                                            <span class="font-semibold">
                                                {{ number_format($totalPrice, 2) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($sale->sale_status == 'completed' && $sale->payment_status == 'paid')
                                            {{ number_format(
                                                $sale->items->sum(function ($item) use ($sale) {
                                                    $price = $item->product->price ?? 0;
                                                    return $sale->order_discount === 'pwd' || $sale->order_discount === 'senior' ? $price * 0.95 : $price;
                                                }),
                                                2,
                                            ) }}
                                        @else
                                            0.00
                                        @endif
                                    </td>


                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($sale->sale_status == 'completed')
                                            <span
                                                class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Paid</span>
                                        @elseif ($sale->sale_status == 'pending')
                                            <span
                                                class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">Unpaid</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $sale->biller }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $sale->order_tax }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('sales.show', ['sale' => $sale->id]) }}"
                                            class="text-yellow-500 mr-2 hover:text-yellow-700" title="View">
                                            <x-lucide-eye class="w-5 h-5 inline" />
                                        </a>
                                        <a href="{{ route('sales.edit', ['sale' => $sale->id]) }}"
                                            class="text-blue-500 hover:text-blue-700" title="Edit">
                                            <x-lucide-edit class="w-5 h-5 inline" />
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 ml-2" title="Delete"
                                            onclick="showDeleteModal({{ $sale->id }})">
                                            <x-lucide-trash class="w-5 h-5 inline" />
                                        </button>

                                        <div id="delete-modal"
                                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                            <div class="bg-white rounded-lg p-6 shadow-lg">
                                                <h2 class="text-lg font-semibold text-gray-700 mb-4">Confirm Delete</h2>
                                                <p class="mb-4">Are you sure you want to delete this Sale?</p>
                                                <div class="flex justify-end space-x-4">
                                                    <button
                                                        class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600"
                                                        onclick="hideDeleteModal()">
                                                        Cancel
                                                    </button>
                                                    <form id="delete-form-{{ $sale->id }}"
                                                        action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600"
                                                            onclick="confirmDelete()">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-2 text-center bg-gray-600 text-white" colspan="8">No Sales Found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        let salesToDelete = null;

        function showDeleteModal(salesID) {
            salesToDelete = salesID;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            salesToDelete = null;
            document.getElementById('delete-modal').classList.add('hidden');
        }

        function confirmDelete() {
            const form = document.querySelector(`#delete-form-${salesToDelete}`);
            if (form) {
                form.submit();
            }
        }
    </script>
    </script>
@endsection
