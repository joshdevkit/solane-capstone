@extends('layouts.app')

@section('title', 'Create Pullout Form - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-2xl font-bold">Pullout Form</h1>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p class="font-bold">{{ session('success') }}</p>
                        </div>
                    @endif
                    <form action="" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                            <div>
                                <label for="input1" class="block text-lg font-semibold text-gray-700">Date:</label>
                                <input id="input1" type="date" name="input1"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                            </div>

                            <div>
                                <label for="input2" class="block text-lg font-semibold text-gray-700">Plate #:</label>
                                <input id="input2" type="text" name="input2"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                                @error('input2')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="input3" class="block text-lg font-semibold text-gray-700">Customer:</label>
                                <input id="input3" type="text" name="input3"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value"
                                    value="{{ old('input3') }}" />
                                @error('input3')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="input3" class="block text-lg font-semibold text-gray-700">DR #:</label>
                                <input id="input3" type="text" name="input3"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value"
                                    value="{{ old('input3') }}" />
                                @error('input3')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="input4" class="block text-lg font-semibold text-gray-700">Driver:</label>
                                <input id="input4" type="text" name="input4"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value"
                                    value="{{ old('input4') }}" />
                                @error('input4')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="button" id="add-row"
                            class="mt-4 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Add
                            Row</button>
                        <table class="table mt-3 w-full table-auto ">
                            <thead>
                                <tr>
                                    <th class="border-b p-2 text-left">SEAL NUMBER</th>
                                    <th class="border-b p-2 text-left">TOTAL CYLINDER WEIGHT</th>
                                    <th class="border-b p-2 text-left">TARE WEIGHT</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="generated_data">

                            </tbody>
                        </table>
                    </form>



                </div>
            </div>
        </div>
    </div>

    <script>
        const addRowButton = document.getElementById('add-row');
        const tbody = document.getElementById('generated_data');

        addRowButton.addEventListener('click', function() {
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td class=" p-2"><input type="text" class=" p-2 w-full" placeholder="Enter Seal Number" /></td>
                <td class=" p-2"><input type="text" class=" p-2 w-full" placeholder="Enter Total Weight" /></td>
                <td class=" p-2"><input type="text" class=" p-2 w-full" placeholder="Enter Tare Weight" /></td>
                <td class=" p-2">
                    <button class="remove-btn bg-red-500 text-white p-1 rounded-md hover:bg-red-600"><x-lucide-trash class='w-6 h-6' /></button>
                </td>
            `;

            tbody.appendChild(newRow);

            const removeButton = newRow.querySelector('.remove-btn');
            removeButton.addEventListener('click', function() {
                tbody.removeChild(newRow);
            });
        });
    </script>

@endsection
