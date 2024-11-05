@extends('layouts.app')

@section('title', 'LIST RETURNS - Dashboard')

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
                        <h1 class="text-xl font-bold">Return List</h1>
                        <a href="{{ route('purchase.create') }}"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                            Add Returns
                        </a>
                    </div>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Reference No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Biller</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($returns as $data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ date('F d, Y', strtotime($data->date_added)) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $data->reference_no }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $data->biller }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $data->customer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex flex-grow-1">
                                        <a href="{{ route('returns.edit', $data->id) }}"
                                            class="text-blue-500 flex items-center mr-2">
                                            <x-lucide-edit class="w-4 h-4 mr-1" /> Edit
                                        </a>
                                        <form action="{{ route('returns.destroy', $data->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 flex items-center">
                                                <x-lucide-trash class="w-4 h-4 inline mr-1" /> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No returns found.</td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
