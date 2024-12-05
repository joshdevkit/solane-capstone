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
                <form action="{{ route('pullout-form.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                        <div>
                            <label for="date" class="block text-lg font-semibold text-gray-700">Date:</label>
                            <input id="date" type="date" name="date"
                                class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                        </div>

                        <div>
                            <label for="plate" class="block text-lg font-semibold text-gray-700">Plate #:</label>
                            <input id="plate" type="text" name="plate"
                                class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value" />
                            @error('plate')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="customer" class="block text-lg font-semibold text-gray-700">Customer:</label>
                            <input id="customer" type="text" name="customer"
                                class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value"
                                value="{{ old('customer') }}" />
                            @error('customer')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="dr" class="block text-lg font-semibold text-gray-700">DR #:</label>
                            <input id="dr" type="text" name="dr"
                                class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value"
                                value="{{ old('dr') }}" />
                            @error('dr')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="driver" class="block text-lg font-semibold text-gray-700">Driver:</label>
                            <input id="driver" type="text" name="driver"
                                class="mt-1 p-2 border rounded-md w-full" placeholder="Enter value"
                                value="{{ old('driver') }}" />
                            @error('driver')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="button" id="add-row"
                        class="mt-4 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Add Row
                    </button>
                    <table class="table mt-3 w-full table-auto">
                        <thead>
                            <tr>
                                <th class="border-b p-2 text-left">SEAL NUMBER</th>
                                <th class="border-b p-2 text-left">TOTAL CYLINDER WEIGHT</th>
                                <th class="border-b p-2 text-left">TARE WEIGHT</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="generated_data"></tbody>
                    </table>

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
    $(document).ready(function() {
        function fetchPulloutProducts() {
            $.ajax({
                url: "{{ route('get-pullout-products') }}",
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    if ($('#generated_data').children().length === 0) {
                        addRow();
                    }
                    data.forEach((item) => {
                        addRow(item.product_barcode.barcode);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching pullout products:', error);
                },
            });
        }

        function addRow(barcode = '') {
            const newRow = `
        <tr>
            <td class="p-2">
                <select name="seal_number[]" class="p-2 w-full seal-number-dropdown">
                    <option value="">Select Seal Number</option>
                </select>
            </td>
            <td class="p-2">
                <input type="text" name="total_cylinder_weight[]" class="p-2 w-full"  placeholder="Total Weight" readonly />
            </td>
            <td class="p-2">
                <input type="text" name="tare_weight[]" class="p-2 w-full" placeholder="Tare Weight" readonly />
            </td>
            <td class="p-2">
                <button type="button" class="remove-btn bg-red-500 text-white p-1 rounded-md hover:bg-red-600">
                    <x-lucide-trash class="w-6 h-6" />
                </button>
            </td>
        </tr>
    `;

            const $row = $(newRow);
            $('#generated_data').append($row);

            populateSealNumbersDropdown($row.find('.seal-number-dropdown'));

            $row.find('.seal-number-dropdown').on('change', function() {
                const selectedOption = $(this).find(':selected').data();
                $row.find('input[name="total_cylinder_weight[]"]').val(selectedOption.netWeight || '');
                $row.find('input[name="tare_weight[]"]').val(selectedOption.tareWeight || '');
            });

            $row.find('.remove-btn').on('click', function() {
                if ($('#generated_data tr').length > 1) {
                    $row.remove();
                } else {
                    alert('At least one row is required.');
                }
            });
        }

        function populateSealNumbersDropdown($dropdown) {
            $.ajax({
                url: "{{ route('get-pullout-products') }}",
                method: 'GET',
                success: function(data) {
                    data.forEach((item) => {
                        const option = `
                    <option value="${item.product_barcode.barcode}"
                            data-net-weight="${item.product_barcode.net_weight || ''}"
                            data-tare-weight="${item.tare_weight || ''}">
                        ${item.product_barcode.barcode}
                    </option>`;
                        $dropdown.append(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error populating seal numbers:', error);
                },
            });
        }

        // Add one default row on page load
        addRow();

        $('#add-row').on('click', function() {
            addRow();
        });

        fetchPulloutProducts();
    });
</script>

@endsection
