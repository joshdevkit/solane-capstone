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
        $(document).ready(function() {
            let barcodeOptions = [];

            function fetchProductsForDelivery() {
                $.ajax({
                    url: '{{ route('get-delivery-products') }}',
                    method: 'GET',
                    success: function(data) {
                        console.log(data);
                        data.forEach(item => {
                            item.barcodes.forEach(barcode => {
                                barcodeOptions.push({
                                    barcode: barcode.barcode,
                                    netWeight: barcode.net_weight,
                                    tareWeight: item.tare_weight || ''
                                });
                            });
                        });

                        populateSealNumbersDropdown();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching pullout products:', error);
                    }
                });
            }

            function addRow() {
                const newRow = `
            <tr>
                <td class="p-2">
                    <select name="seal_number[]" class="p-2 w-full seal-number-dropdown">
                        <option value="">Select Seal Number</option>
                    </select>
                </td>
                <td class="p-2">
                    <input type="text" name="total_weight[]" class="p-2 w-full" placeholder="Enter Total Weight" readonly />
                </td>
                <td class="p-2">
                    <input type="text" name="tare_weight[]" class="p-2 w-full" placeholder="Enter Tare Weight" readonly />
                </td>
                <td class="p-2">
                    <button type="button" class="remove-btn bg-red-500 text-white p-1 rounded-md hover:bg-red-600">
                        Remove
                    </button>
                </td>
            </tr>
        `;

                const $row = $(newRow);
                $('#generated_data').append($row);

                populateSealNumbersDropdown($row.find('.seal-number-dropdown'));

                $row.find('.seal-number-dropdown').on('change', function() {
                    const selectedOption = $(this).find(':selected').data();
                    $row.find('input[name="total_weight[]"]').val(selectedOption.netWeight || '');
                    $row.find('input[name="tare_weight[]"]').val(selectedOption.tareWeight || '');
                });

                $row.find('.remove-btn').on('click', function() {
                    $row.remove();
                });
            }

            function populateSealNumbersDropdown($dropdown) {
                if (!$dropdown) {
                    $dropdown = $('.seal-number-dropdown');
                }

                barcodeOptions.forEach(option => {
                    const optionMarkup = `
                <option value="${option.barcode}"
                        data-net-weight="${option.netWeight}"
                        data-tare-weight="${option.tareWeight}">
                    ${option.barcode}
                </option>
            `;
                    $dropdown.append(optionMarkup);
                });
            }

            $('#add-row').on('click', function() {
                addRow();
            });

            fetchProductsForDelivery();
        });
    </script>

@endsection
