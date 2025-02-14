@extends('layouts.app')

@section('title', 'UPDATE USER ACCOUNT - Dashboard')

@section('content')
    <div class="py-12 lg:ml-64 mx-auto max-w-full mt-16">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Update User Information</h1>
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                <p class="font-bold">Please fill the following criteria:</p>
                                <ul class="list-disc ml-10">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('users.update', $user) }}" method="POST" class="grid grid-cols-2 gap-6">
                        @csrf
                        @method('PUT')

                        <div class="col-span-1">
                            <label for="employee_number" class="block text-sm font-medium text-gray-700">Employee
                                Number</label>
                            <input type="text" name="employee_number" id="employee_number"
                                value="{{ old('employee_number', $user->employee_number) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>



                        <div class="col-span-1">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="col-span-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                placeholder="Leave blank to keep current password">
                        </div>

                        <div class="col-span-1">
                            <label for="role" class="block text-sm font-medium text-gray-700">User Position</label>
                            <select name="role" id="role"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="" disabled>Select Position</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $user->roles->contains($role) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="col-span-2 mt-4 w-52 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Update Account
                        </button>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
