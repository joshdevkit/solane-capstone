@extends('layouts.app')

@section('title', 'LIST CUSTOMERS - Dashboard')

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
                        <h1 class="text-xl font-bold">User List</h1>
                        <a href="{{ route('users.create') }}"
                            class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                            Add User
                        </a>
                    </div>
                    <table class="min-w-full text-center bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Employee Number</th>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Position</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $user->employee_number }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="inline-block bg-gray-200 text-gray-700 text-sm px-2 py-1 rounded">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="text-blue-500 hover:text-blue-700 mr-2">
                                            <x-lucide-edit class="w-5 h-5 inline-block" />
                                            Edit
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 ml-2" title="Delete"
                                            onclick="showDeleteModal({{ $user->id }})">
                                            <x-lucide-trash class="w-5 h-5 inline" />
                                            Remove
                                        </button>

                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('users.destroy', $user->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>

                                    <div id="delete-modal"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                        <div class="bg-white rounded-lg p-6 shadow-lg">
                                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Confirm Delete</h2>
                                            <p class="mb-4">Are you sure you want to remove the user ? </p>
                                            <div class="flex justify-end space-x-4">
                                                <button class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600"
                                                    onclick="hideDeleteModal()">
                                                    Cancel
                                                </button>
                                                <button class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600"
                                                    id="confirm-delete-btn">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        let userToDelete = null;

        function showDeleteModal(categoryId) {
            userToDelete = categoryId;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            userToDelete = null;
            document.getElementById('delete-modal').classList.add('hidden');
        }

        document.getElementById('confirm-delete-btn').addEventListener('click', function() {
            if (userToDelete) {
                document.getElementById('delete-form-' + userToDelete).submit();
            }
        });
    </script>
@endsection
