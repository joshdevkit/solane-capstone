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
                        <h1 class="text-xl font-bold">Supplier List</h1>
                        <a href="{{ route('suppliers.create') }}"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                            Add Suppliers
                        </a>
                    </div>
                    <table class="min-w-full text-center bg-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Company Name</th>
                                <th class="px-4 py-2 border-b">Contact Person</th>
                                <th class="px-4 py-2 border-b">Email</th>
                                <th class="px-4 py-2 border-b">Phone Number</th>
                                <th class="px-4 py-2 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>

                                    <td class="border-b px-4 py-2">{{ $supplier->name }}</td>
                                    <td class="border-b px-4 py-2">{{ $supplier->contact_person }}</td>
                                    <td class="border-b px-4 py-2">{{ $supplier->email }}</td>
                                    <td class="border-b px-4 py-2">{{ $supplier->phone_number }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('suppliers.show', ['supplier' => $supplier]) }}"
                                            class="text-yellow-500 mr-2 hover:text-yellow-700" title="View">
                                            <x-lucide-eye class="w-5 h-5 inline" />
                                        </a>
                                        <a href="{{ route('suppliers.edit', ['supplier' => $supplier]) }}"
                                            class="text-blue-500 hover:text-blue-700" title="Edit">
                                            <x-lucide-edit class="w-5 h-5 inline" />
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 ml-2" title="Delete"
                                            onclick="showDeleteModal({{ $supplier->id }})">
                                            <x-lucide-trash class="w-5 h-5 inline" />
                                        </button>

                                    </td>
                                    <div id="delete-modal"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                        <div class="bg-white rounded-lg p-6 shadow-lg">
                                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Confirm Delete</h2>
                                            <p class="mb-4">Are you sure you want to delete this Supplier?</p>
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
        let supplierToDelete = null;

        function showDeleteModal(customerId) {
            supplierToDelete = customerId;
            document.getElementById('delete-form').action = `/suppliers/${customerId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            supplierToDelete = null;
            document.getElementById('delete-modal').classList.add('hidden');
        }
    </script>
@endsection
