@extends('layouts.app')

@section('title', 'Create Delivery Form - Dashboard')

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

                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p class="font-bold">{{ session('error') }}</p>
                    </div>
                @endif

                <form action="{{ route('delivery-form.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                        <div>
                            <label for="date" class="block text-lg font-semibold text-gray-700">Date:</label>
                            <input id="date" type="date" name="date" class="mt-1 p-2 border rounded-md w-full"
                                required />
                        </div>

                        <div>
                            <label for="plate" class="block text-lg font-semibold text-gray-700">Plate #:</label>
                            <input id="plate" type="text" name="plate" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter plate number" required />
                        </div>

                        <div>
                            <label for="customer" class="block text-lg font-semibold text-gray-700">Customer:</label>
                            <input id="customer" type="text" name="customer" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter customer name" required />
                        </div>

                        <div>
                            <label for="dr" class="block text-lg font-semibold text-gray-700">DR #:</label>
                            <input id="dr" type="text" name="dr" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter DR number" required />
                        </div>

                        <div>
                            <label for="driver" class="block text-lg font-semibold text-gray-700">Driver:</label>
                            <input id="driver" type="text" name="driver" class="mt-1 p-2 border rounded-md w-full"
                                placeholder="Enter driver name" required />
                        </div>
                    </div>

                    <button type="button" id="add-row"
                        class="mt-4 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Add Row</button>

                        <table class="table mt-3 w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border-b p-2 text-left">SEAL NUMBER</th>
                                <th class="border-b p-2 text-left">TOTAL CYLINDER WEIGHT</th>
                                <th class="border-b p-2 text-left">TARE WEIGHT</th>
                                <th class="border-b p-2 text-left">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="generated_data">
                        </tbody>
                    </table>

                    <!-- Submit Buttons -->
                    <div class="mt-4 flex space-x-4">
                        <button type="submit" name="action" value="save_and_download" class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                            Save and Download PDF
                        </button>
                        <button type="submit" name="action" value="save_only" class="p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Save Only
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    const addRowButton = document.getElementById('add-row');
    const tbody = document.getElementById('generated_data');

    // Add initial row when page loads
    window.addEventListener('load', function() {
        addNewRow();
    });

    // Add a new row to the table
    addRowButton.addEventListener('click', addNewRow);

    function addNewRow() {
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td class="p-2">
                <input type="text" name="seal_number[]" class="p-2 w-full border rounded" placeholder="Enter Seal Number" required />
            </td>
            <td class="p-2">
                <input type="number" name="total_cylinder_weight[]" class="p-2 w-full border rounded" placeholder="Enter Total Weight" required />
            </td>
            <td class="p-2">
                <input type="number" name="tare_weight[]" class="p-2 w-full border rounded" placeholder="Enter Tare Weight" required />
            </td>
            <td class="p-2">
                <button type="button" class="remove-btn bg-red-500 text-white p-1 rounded-md hover:bg-red-600">Remove</button>
            </td>
        `;

        tbody.appendChild(newRow);

        const removeButton = newRow.querySelector('.remove-btn');
        removeButton.addEventListener('click', function () {
            if (tbody.children.length > 1) {
                tbody.removeChild(newRow);
            } else {
                alert('At least one row is required.');
            }
        });
    }
</script>

@endsection
