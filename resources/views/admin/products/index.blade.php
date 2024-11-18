@extends('layouts.app')

@section('title', 'LIST PRODUCTS - Dashboard')

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
                        <h1 class="text-xl font-bold">Product List</h1>
                        <a href="{{ route('products.create') }}"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                            Add Product
                        </a>
                    </div>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-center">Image</th>
                                <th class="py-2 px-4 border-b text-center">Product</th>
                                <th class="py-2 px-4 border-b text-center">Code</th>
                                <th class="py-2 px-4 border-b text-center">Category</th>
                                <th class="py-2 px-4 border-b text-center">Price</th>
                                <th class="py-2 px-4 border-b text-center">Cost</th>
                                <th class="py-2 px-4 border-b text-center">Quantity</th>
                                <th class="py-2 px-4 border-b text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($products as $product)
                                <tr>
                                    <td class="py-2 px-4 border-b flex justify-center items-center">
                                        <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_image }}"
                                            class="w-16 h-16 object-cover">
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">{{ $product->name }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $product->barcode_symbology }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $product->category->name }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $product->price }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $product->cost }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $product->quantity }}</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <a href="{{ route('products.show', ['product' => $product->id]) }}"
                                            class="text-blue-500 hover:text-blue-700" title="View">
                                            <x-lucide-eye class="w-5 h-5 inline-block" />
                                        </a>

                                        <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                            class="text-yellow-500 hover:text-yellow-700 mx-4" title="Edit">
                                            <x-lucide-edit class="w-5 h-5 inline-block" />
                                        </a>

                                        <!-- Delete Button (Trigger) -->
                                        <button type="button" class="text-red-500 hover:text-red-700 ml-2" title="Delete"
                                            onclick="showDeleteModal({{ $product->id }})">
                                            <x-lucide-trash class="w-5 h-5 inline" />
                                        </button>

                                        <div id="delete-modal"
                                            class="z-10 fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                            <div class="bg-white rounded-lg p-6 shadow-lg">
                                                <h2 class="text-lg font-semibold text-gray-700 mb-4">Confirm Delete</h2>
                                                <p class="mb-4">Are you sure you want to delete this Product?</p>
                                                <div class="flex justify-end space-x-4">
                                                    <button
                                                        class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600"
                                                        onclick="hideDeleteModal()">
                                                        Cancel
                                                    </button>
                                                    <form id="delete-form-{{ $product->id }}"
                                                        action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST">
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
                                    <td colspan="7" class="text-center p-3 text-gray-500">No Products Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        let productToDelete = null;

        function showDeleteModal(salesID) {
            productToDelete = salesID;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            productToDelete = null;
            document.getElementById('delete-modal').classList.add('hidden');
        }

        function confirmDelete() {
            const form = document.querySelector(`#delete-form-${productToDelete}`);
            if (form) {
                form.submit();
            }
        }
    </script>
@endsection
