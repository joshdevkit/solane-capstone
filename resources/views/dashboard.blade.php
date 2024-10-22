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
                        <div class="text-3xl font-bold">120,000,000.00</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
                    <x-lucide-shopping-cart class="w-8 h-8 text-blue-500 mr-4" />
                    <div>
                        <div class="text-gray-900 text-lg font-semibold">Total Cost</div>
                        <div class="text-3xl font-bold">110,000,000.00</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
                    <x-lucide-box class="w-8 h-8 text-purple-500 mr-4" />
                    <div>
                        <div class="text-gray-900 text-lg font-semibold">Products Sold</div>
                        <div class="text-3xl font-bold">899</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
