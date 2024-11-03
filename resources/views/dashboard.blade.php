@extends('layouts.app')

@section('title', 'GUFC - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-6 rounded-lg">
                    <div class="text-gray-900 ">
                        <p class="text-xl  font-bold">Hi {{ Auth::user()->name }}, Good Day! </p><br><br>
                        <p class="w-full text-justify text-sm ">Your dashboard gives you views of key performance or
                            business
                            process.</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
                    <x-lucide-dollar-sign class="w-8 h-8 text-green-500 mr-4" />
                    <div>
                        <div class="text-gray-900 text-lg font-semibold">Total Sales</div>
                        <div class="text-3xl font-bold">{{ number_format($totalSales, 2) }}</div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
                    <x-lucide-shopping-cart class="w-8 h-8 text-blue-500 mr-4" />
                    <div>
                        <div class="text-gray-900 text-lg font-semibold">Total Cost</div>
                        <div class="text-3xl font-bold">{{ number_format($totalCost, 2) }}</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
                    <x-lucide-box class="w-8 h-8 text-purple-500 mr-4" />
                    <div>
                        <div class="text-gray-900 text-lg font-semibold">Products Sold</div>
                        <div class="text-3xl font-bold">{{ $totalProductSold }}</div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $months = [
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 => 'August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December',
            ];
            $currentMonth = $selectedMonth ?? date('n');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mt-10">
            <div class="bg-white p-6 rounded-md shadow-sm flex flex-col items-center">
                <div class="flex flex-col md:flex-row items-center justify-between w-full mb-4 rounded-lg border-2 p-3">
                    <h4 class="text-lg font-semibold">Overview</h4>
                    <form method="GET" action="{{ route('dashboard') }}" id="monthFilterForm">
                        <select name="month" onchange="document.getElementById('monthFilterForm').submit()"
                            class="w-full md:w-auto mt-2 md:mt-0 ml-0 md:ml-4 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Select Month</option>
                            @foreach ($months as $num => $name)
                                <option value="{{ $num }}" {{ $num == $selectedMonth ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>

                    </form>
                </div>

                <div class="w-full">
                    {!! $productChart->container() !!}
                </div>
            </div>


            <div class="bg-white p-6 rounded-md shadow-sm flex flex-col items-center">
                <div class="flex flex-col md:flex-row items-center justify-between w-full mb-4 rounded-lg border-2 p-3">
                    <h4 class="text-lg font-semibold">Revenue vs Cost</h4>
                    <form method="GET" action="{{ route('dashboard') }}" id="comparisonMonthFilterForm">
                        <select name="month_revenue_vs_cost"
                            onchange="document.getElementById('comparisonMonthFilterForm').submit()"
                            class="w-full md:w-auto mt-2 md:mt-0 ml-0 md:ml-4 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Select Month</option>
                            @foreach ($months as $num => $name)
                                <option value="{{ $num }}"
                                    {{ $num == $selectedComparisonMonth ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="w-full">
                    {!! $comparisonChart->container() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="{{ $productChart->cdn() }}"></script>
    {{ $productChart->script() }}
    {{ $comparisonChart->script() }}
@endsection
