@extends('layouts.app')

@section('title', 'Add Category - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Add New Category</h1>
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                <p class="font-bold">Please fill the following errors:</p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="code" class="block text-gray-700">Code</label>
                            <input type="text" name="code" id="code"
                                class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700">Image</label>
                            <input type="file" name="image" id="image" class="filepond mt-1" accept="image/*">
                        </div>

                        <button type="submit"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                            Save Category
                        </button>
                        <a href="{{ route('category.index') }}" class="ml-4 text-gray-700 hover:underline">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        const inputElement = document.querySelector('input[name="image"]');
        const pond = FilePond.create(inputElement);

        FilePond.setOptions({
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/gif'],
            server: {
                process: {
                    url: '{{ route('category.upload') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        return response;
                    },
                    onerror: (response) => {
                        return response;
                    }
                }
            }
        });
    </script>
@endsection
