@extends('layouts.app')

@section('title', 'GUFC - Dashboard')


@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
@endsection
