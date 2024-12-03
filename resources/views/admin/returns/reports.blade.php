@extends('layouts.app')

@section('title', 'PRODUCTS - INVENTORY REPORT - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-700 text-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-center text-2xl font-bold">RETURNS REPORT</h1>
                </div>
            </div>
            @if ($errors->any())
                <div class="mb-4 mt-10">
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
            <form action="{{ route('generate.reports.returns') }}" method="GET"
                class="mt-6 bg-white p-6 rounded-lg shadow-md">
                <h2>Report Period</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="start_date" class="block text-gray-700 font-bold mb-2">Start Date:</label>
                        <input type="date" id="start_date" name="start_date"
                            class="border-gray-300 rounded-lg shadow-sm w-full focus:ring focus:ring-blue-500"
                            value="{{ old('start_date', request()->query('start_date')) }}">
                    </div>
                    <div>
                        <label for="end_date" class="block text-gray-700 font-bold mb-2">End Date:</label>
                        <input type="date" id="end_date" name="end_date"
                            class="border-gray-300 rounded-lg shadow-sm w-full focus:ring focus:ring-blue-500"
                            value="{{ old('end_date', request()->query('end_date')) }}">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 w-full">
                            Generate Report
                        </button>
                    </div>
                </div>
            </form>








        </div>
    </div>
@endsection
