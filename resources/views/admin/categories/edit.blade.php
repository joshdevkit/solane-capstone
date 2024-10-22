@extends('layouts.app')

@section('title', 'Edit Category')

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
                    <h1 class="text-xl font-bold mb-4">Edit Category</h1>

                    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Category Name:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="code" class="block text-gray-700">Category Code:</label>
                            <input type="text" name="code" id="code" value="{{ old('code', $category->code) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700">Category Image:</label>
                            @if ($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                    class="w-16 h-16 object-cover mb-2">
                            @endif
                            <input type="file" name="image" id="image" class="block w-full text-gray-500">
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
