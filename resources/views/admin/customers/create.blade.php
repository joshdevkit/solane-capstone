@extends('layouts.app')

@section('title', 'Add CUSTOMERS - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Add Customer</h1>

                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                <p class="font-bold">Please fill the following errors:</p>
                                <ul class="list-disc ml-10">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>

                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone
                                    Number</label>
                                <input type="text" name="phone_number" id="phone_number"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>

                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <input type="text" name="country" id="country"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" id="address" rows="4"
                                class="mt-1 mb-6 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"></textarea>
                        </div>


                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" id="city"
                                class="mt-1 mb-10 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                            <input type="text" name="state" id="state"
                                class="mt-1 mb-10 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>

                        <div class="mb-4">
                            <label for="customer_group" class="block text-sm font-medium text-gray-700">Customer
                                Group</label>
                            <select name="customer_group" id="customer_group"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Select Customer Group</option>
                                <option value="KUSINA CO.">KUSINA CO.</option>
                                <option value="BITES TOGO INC.">BITES TOGO INC.</option>
                                <option value="LOURDES BIBINGKA">LOURDES BIBINGKA</option>
                                <option value="XENTROMALL SANTIAGO">XENTROMALL SANTIAGO</option>
                                <option value="NORTHSTAR ISABELA">NORTHSTAR ISABELA</option>
                                <option value="RS CANTEEN">RS CANTEEN</option>
                                <option value="EASTGATE BUSINESS CENTER">EASTGATE BUSINESS CENTER</option>
                                <option value="LZV FOOD SERVICES">LZV FOOD SERVICES</option>
                                <option value="SAMGYUPSALBBQBARN">SAMGYUPSALBBQBARN</option>
                                <option value="AMRC HOLDINGS CO. INC.">AMRC HOLDINGS CO. INC.</option>
                                <option value="COCINA DE ALICIA">COCINA DE ALICIA</option>
                                <option value="KUMPARES">KUMPARES</option>
                                <option value="HIPPERS">HIPPERS</option>
                                <option value="QUEEN SISIG">QUEEN SISIG</option>
                                <option value="KA MELY'S BIBINGKA">KA MELY'S BIBINGKA</option>
                                <option value="BALAGTAS TOWN CENTER">BALAGTAS TOWN CENTER</option>
                                <option value="MALOLOS CITY TERMINAL HUB">MALOLOS CITY TERMINAL HUB</option>
                                <option value="CRVE BY CARA">CRVE BY CARA</option>
                                <option value="ONE MIGHTY FOOD CORPORATION">ONE MIGHTY FOOD CORPORATION</option>
                                <option value="Q-AGRI FARM">Q-AGRI FARM</option>
                                <option value="CONTIS BAKESHOP">CONTIS BAKESHOP</option>
                                <option value="JOLLIBEE MAMBUGAN">JOLLIBEE MAMBUGAN</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Save Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
