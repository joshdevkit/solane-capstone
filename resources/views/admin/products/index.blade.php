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
                        <tbody>
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
                                        <button class="text-red-500 hover:text-red-700" title="Delete"
                                            onclick="openModal('delete-modal')">
                                            <x-lucide-trash class="w-5 h-5 inline-block" />
                                        </button>

                                        <div id="delete-modal"
                                            class="fixed z-10 inset-0 hidden bg-gray-800 bg-opacity-50 flex items-center justify-center">
                                            <!-- Modal Box -->
                                            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                                <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
                                                <p class="text-gray-600">Are you sure you want to delete this product?</p>

                                                <div class="mt-6 flex justify-end">
                                                    <button type="button" onclick="closeModal('delete-modal')"
                                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded mr-2">
                                                        Cancel
                                                    </button>

                                                    <form action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
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
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
@endsection
