@extends('layouts.app')

@section('title', 'Upload Forms - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Upload Form</h1>
                    <form action="{{ route('uploaded-forms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="form_name" class="block text-sm font-medium text-gray-700">Form Name</label>
                            <input type="text" name="form_name" id="form_name" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div id="dropzone"
                            class="border-2 border-dashed border-gray-300 rounded-md p-4 text-center py-24 cursor-pointer"
                            onclick="document.getElementById('fileUpload').click();">
                            <h2 class="text-gray-500">Drag & drop a file here or click to upload</h2>
                            <div id="fileList" class="mt-2 text-gray-700 flex justify-center"></div>
                            <input name="file_path" type="file" id="fileUpload" class="hidden" accept=".csv, .xlsx" />
                        </div>
                        <button type="submit"
                            class="mt-4 w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Upload Form
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('fileUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileList = document.getElementById('fileList');

            fileList.innerHTML = '';

            if (file) {
                const fileItem = document.createElement('div');
                fileItem.classList.add('flex', 'items-center', 'justify-center', 'mt-2');

                const fileName = document.createElement('span');
                fileName.classList.add('font-semibold');
                fileName.textContent = file.name;

                const removeButton = document.createElement('button');
                removeButton.classList.add('ml-2', 'text-red-600', 'hover:text-red-800', 'flex', 'items-center');
                removeButton.innerHTML = `<x-lucide-trash class="h-5 w-5" />`;

                removeButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    fileList.innerHTML = '';
                    document.getElementById('fileUpload').value = '';
                });

                fileItem.appendChild(fileName);
                fileItem.appendChild(removeButton);
                fileList.appendChild(fileItem);
            }
        });
    </script>
@endsection
