@extends('layouts.app')

@section('title', 'VIEW SUPPLIERS DETAILS - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-bold text-gray-700">Supplier Details</h2>
                    <hr class="mb-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $suppliers->name }}</p>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $suppliers->email }}</p>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $suppliers->phone_number }}</p>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Country</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $suppliers->country }}</p>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $suppliers->address }}</p>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $suppliers->city }}</p>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">State</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $suppliers->state }}</p>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Country</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $suppliers->country }}</p>
                        </div>
                    </div>

                    <div class="mt-8">

                    </div>
                </div>
            </div>
        @endsection
