@extends('layouts.app')

@section('title', 'LIST CATEGORIES - Dashboard')

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
                        <h1 class="text-xl font-bold">Category List</h1>
                        <a href="{{ route('category.create') }}"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                            Add Category
                        </a>
                    </div>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Image</th>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Code</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="py-2 px-4 border-b">
                                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                            class="w-16 h-16 object-cover">
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ $category->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $category->code }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="#" class="text-blue-500 hover:text-blue-700" title="Edit">
                                            <x-lucide-edit class="w-5 h-5 inline" />
                                        </a>
                                        <a href="#" class="text-red-500 hover:text-red-700 ml-2" title="Delete">
                                            <x-lucide-trash class="w-5 h-5 inline" />
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-3 text-gray-500">No Categories Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
