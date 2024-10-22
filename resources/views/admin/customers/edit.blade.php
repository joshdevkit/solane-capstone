@extends('layouts.app')

@section('title', 'UPDATE CUSTOMER DETAILS - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-bold text-gray-700">Update Customer Details</h2>
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                <p class="font-bold">Please fill the following criteria:</p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <hr class="mb-10">

                    <form action="{{ route('customers.update', $customers->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" value="{{ old('name', $customers->name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ old('email', $customers->email) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" name="phone_number"
                                    value="{{ old('phone_number', $customers->phone_number) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Country</label>
                                <input type="text" name="country" value="{{ old('country', $customers->country) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" name="address" value="{{ old('address', $customers->address) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" value="{{ old('city', $customers->city) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">State</label>
                                <input type="text" name="state" value="{{ old('state', $customers->state) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                        </div>
                        <div class="mb-4 mt-5">
                            <label for="customer_group" class="block text-sm font-medium text-gray-700">Customer
                                Group</label>
                            <select name="customer_group" id="customer_group"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Select Customer Group</option>
                                <option value="KUSINA CO."
                                    {{ old('customer_group', $customers->customer_group) == 'KUSINA CO.' ? 'selected' : '' }}>
                                    KUSINA CO.</option>
                                <option value="BITES TOGO INC."
                                    {{ old('customer_group', $customers->customer_group) == 'BITES TOGO INC.' ? 'selected' : '' }}>
                                    BITES TOGO INC.</option>
                                <option value="LOURDES BIBINGKA"
                                    {{ old('customer_group', $customers->customer_group) == 'LOURDES BIBINGKA' ? 'selected' : '' }}>
                                    LOURDES BIBINGKA</option>
                                <option value="XENTROMALL SANTIAGO"
                                    {{ old('customer_group', $customers->customer_group) == 'XENTROMALL SANTIAGO' ? 'selected' : '' }}>
                                    XENTROMALL SANTIAGO</option>
                                <option value="NORTHSTAR ISABELA"
                                    {{ old('customer_group', $customers->customer_group) == 'NORTHSTAR ISABELA' ? 'selected' : '' }}>
                                    NORTHSTAR ISABELA</option>
                                <option value="RS CANTEEN"
                                    {{ old('customer_group', $customers->customer_group) == 'RS CANTEEN' ? 'selected' : '' }}>
                                    RS CANTEEN</option>
                                <option value="EASTGATE BUSINESS CENTER"
                                    {{ old('customer_group', $customers->customer_group) == 'EASTGATE BUSINESS CENTER' ? 'selected' : '' }}>
                                    EASTGATE BUSINESS CENTER</option>
                                <option value="LZV FOOD SERVICES"
                                    {{ old('customer_group', $customers->customer_group) == 'LZV FOOD SERVICES' ? 'selected' : '' }}>
                                    LZV FOOD SERVICES</option>
                                <option value="SAMGYUPSALBBQBARN"
                                    {{ old('customer_group', $customers->customer_group) == 'SAMGYUPSALBBQBARN' ? 'selected' : '' }}>
                                    SAMGYUPSALBBQBARN</option>
                                <option value="AMRC HOLDINGS CO. INC."
                                    {{ old('customer_group', $customers->customer_group) == 'AMRC HOLDINGS CO. INC.' ? 'selected' : '' }}>
                                    AMRC HOLDINGS CO. INC.</option>
                                <option value="COCINA DE ALICIA"
                                    {{ old('customer_group', $customers->customer_group) == 'COCINA DE ALICIA' ? 'selected' : '' }}>
                                    COCINA DE ALICIA</option>
                                <option value="KUMPARES"
                                    {{ old('customer_group', $customers->customer_group) == 'KUMPARES' ? 'selected' : '' }}>
                                    KUMPARES</option>
                                <option value="HIPPERS"
                                    {{ old('customer_group', $customers->customer_group) == 'HIPPERS' ? 'selected' : '' }}>
                                    HIPPERS</option>
                                <option value="QUEEN SISIG"
                                    {{ old('customer_group', $customers->customer_group) == 'QUEEN SISIG' ? 'selected' : '' }}>
                                    QUEEN SISIG</option>
                                <option value="KA MELY'S BIBINGKA"
                                    {{ old('customer_group', $customers->customer_group) == "KA MELY'S BIBINGKA" ? 'selected' : '' }}>
                                    KA MELY'S BIBINGKA</option>
                                <option value="BALAGTAS TOWN CENTER"
                                    {{ old('customer_group', $customers->customer_group) == 'BALAGTAS TOWN CENTER' ? 'selected' : '' }}>
                                    BALAGTAS TOWN CENTER</option>
                                <option value="MALOLOS CITY TERMINAL HUB"
                                    {{ old('customer_group', $customers->customer_group) == 'MALOLOS CITY TERMINAL HUB' ? 'selected' : '' }}>
                                    MALOLOS CITY TERMINAL HUB</option>
                                <option value="CRVE BY CARA"
                                    {{ old('customer_group', $customers->customer_group) == 'CRVE BY CARA' ? 'selected' : '' }}>
                                    CRVE BY CARA</option>
                                <option value="ONE MIGHTY FOOD CORPORATION"
                                    {{ old('customer_group', $customers->customer_group) == 'ONE MIGHTY FOOD CORPORATION' ? 'selected' : '' }}>
                                    ONE MIGHTY FOOD CORPORATION</option>
                                <option value="Q-AGRI FARM"
                                    {{ old('customer_group', $customers->customer_group) == 'Q-AGRI FARM' ? 'selected' : '' }}>
                                    Q-AGRI FARM</option>
                                <option value="CONTIS BAKESHOP"
                                    {{ old('customer_group', $customers->customer_group) == 'CONTIS BAKESHOP' ? 'selected' : '' }}>
                                    CONTIS BAKESHOP</option>
                                <option value="JOLLIBEE MAMBUGAN"
                                    {{ old('customer_group', $customers->customer_group) == 'JOLLIBEE MAMBUGAN' ? 'selected' : '' }}>
                                    JOLLIBEE MAMBUGAN</option>
                            </select>
                        </div>
                        <div class="mt-8">
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none">
                                Update Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
