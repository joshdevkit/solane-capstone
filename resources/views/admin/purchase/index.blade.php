@extends('layouts.app')

@section('title', 'LIST PURCHASE - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-10" role="alert">
                            <p class="font-bold">{{ session('success') }}</p>
                        </div>
                    @endif
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-xl font-bold">Purchase List</h1>
                        <a href="{{ route('purchase.create') }}"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                            Add Purchase
                        </a>
                    </div>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-center">Date</th>
                                <th class="py-2 px-4 border-b text-center">Reference No</th>
                                <th class="py-2 px-4 border-b text-center">Supplier</th>
                                <th class="py-2 px-4 border-b text-center">Purchase Status</th>
                                <th class="py-2 px-4 border-b text-center">Total</th>
                                <th class="py-2 px-4 border-b text-center">Paid</th>
                                <th class="py-2 px-4 border-b text-center">Balance</th>
                                <th class="py-2 px-4 border-b text-center">Payment Status</th>
                                <th class="py-2 px-4 border-b text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
