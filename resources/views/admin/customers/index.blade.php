@extends('layouts.app')

@section('title', 'LIST CUSTOMERS - Dashboard')

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
                        <h1 class="text-xl font-bold">Customer List</h1>
                        <a href="{{ route('customers.create') }}"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                            Add Customers
                        </a>
                    </div>
                    <table class="min-w-full text-center bg-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Name</th>
                                <th class="px-4 py-2 border-b">Email</th>
                                <th class="px-4 py-2 border-b">Phone Number</th>
                                <th class="px-4 py-2 border-b">Order Count</th>
                                <th class="px-4 py-2 border-b">Status</th>
                                <th class="px-4 py-2 border-b">Last Order</th>
                                <th class="px-4 py-2 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>

                                    <td class="border-b px-4 py-2">{{ $customer->name }}</td>
                                    <td class="border-b px-4 py-2">{{ $customer->email }}</td>
                                    <td class="border-b px-4 py-2">{{ $customer->phone_number }}</td>
                                    <td class="border-b px-4 py-2">{{ $customer->orders->count() }}</td>
                                    <td class="border-b px-4 py-2">
                                        @php
                                            $lastOrder = $customer->orders->last();
                                            $paymentStatus = $lastOrder ? $lastOrder->payment_status : 'No Order yet';
                                        @endphp

                                        <span
                                            class="{{ $paymentStatus === 'paid'
                                                ? 'bg-green-100 text-green-600'
                                                : ($paymentStatus === 'unpaid'
                                                    ? 'bg-red-100 text-red-600'
                                                    : 'bg-gray-100 text-gray-600') }}
                                            px-2 py-1 rounded">
                                            {{ ucfirst($paymentStatus) }}
                                        </span>
                                    </td>

                                    <td class="border-b px-4 py-2">
                                        {{ $customer->recent_paid_orders_count }}
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('customers.show', ['customer' => $customer]) }}"
                                            class="text-yellow-500 mr-2 hover:text-yellow-700" title="View">
                                            <x-lucide-eye class="w-5 h-5 inline" />
                                        </a>
                                        <a href="{{ route('customers.edit', ['customer' => $customer]) }}"
                                            class="text-blue-500 hover:text-blue-700" title="Edit">
                                            <x-lucide-edit class="w-5 h-5 inline" />
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 ml-2" title="Delete"
                                            onclick="showDeleteModal({{ $customer->id }})">
                                            <x-lucide-trash class="w-5 h-5 inline" />
                                        </button>

                                    </td>
                                    <div id="delete-modal"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                        <div class="bg-white rounded-lg p-6 shadow-lg">
                                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Confirm Delete</h2>
                                            <p class="mb-4">Are you sure you want to delete this customer?</p>
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
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

    <script>
        let customerToDelete = null;

        function showDeleteModal(customerId) {
            customerToDelete = customerId;
            document.getElementById('delete-form').action = `/customers/${customerId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            customerToDelete = null;
            document.getElementById('delete-modal').classList.add('hidden');
        }
    </script>
@endsection
