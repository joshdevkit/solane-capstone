@extends('layouts.app')

@section('title', 'Create Delivery Receipt - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-2xl font-bold">Delivery Form</h1>
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
                                <label for="input2" class="block text-lg font-semibold text-gray-700">Invoice #:</label>
                                <input id="input2" type="text" name="input2"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                                @error('input2')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="input3" class="block text-lg font-semibold text-gray-700">Invoice To:</label>
                                <input id="input3" type="text" name="input3"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value"
                                    value="{{ old('input3') }}" />
                                @error('input3')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="input3" class="block text-lg font-semibold text-gray-700">Attention:</label>
                                <input id="input3" type="text" name="input3"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value"
                                    value="{{ old('input3') }}" />
                                @error('input3')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-4 p-6">
                            <div>
                                <label for="input1" class="block text-lg font-semibold text-gray-700">PO No.:</label>
                                <input id="input1" type="text" name="input1"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                            </div>
                            <div>
                                <label for="input1" class="block text-lg font-semibold text-gray-700">Terms:</label>
                                <input id="input1" type="text" name="input1"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                            </div>
                            <div>
                                <label for="input1" class="block text-lg font-semibold text-gray-700">Rep:</label>
                                <input id="input1" type="text" name="input1"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                            </div>
                            <div>
                                <label for="input1" class="block text-lg font-semibold text-gray-700">Ship Date:</label>
                                <input id="input1" type="date" name="input1"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                            </div>
                        </div>

                        <hr>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 p-6">
                            <div>
                                <label for="input1" class="block text-lg font-semibold text-gray-700">FOB:</label>
                                <input id="input1" type="text" name="input1"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                            </div>
                            <div>
                                <label for="input1" class="block text-lg font-semibold text-gray-700">PROJECT:</label>
                                <input id="input1" type="text" name="input1"
                                    class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                            </div>

                        </div>

                        <table class="table mt-3 w-full table-auto ">
                            <thead>
                                <tr>
                                    <th class="border-b p-2 text-center">Qty</th>
                                    <th class="border-b p-2 text-center">ITEM</th>
                                    <th class="border-b p-2 text-center">DESCRIPTION</th>
                                    <th class="border-b p-2 text-center">Price Each</th>
                                    <th class="border-b p-2 text-center">Amount</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            type="text" name="" id=""></td>
                                    <td><input
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            type="text" name="" id=""></td>
                                    <td><input
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            type="text" name="" id=""></td>
                                    <td><input
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            type="text" name="" id=""></td>
                                    <td><input
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            type="text" name="" id=""></td>
                                </tr>
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
