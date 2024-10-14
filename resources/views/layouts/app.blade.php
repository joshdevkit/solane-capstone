<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('CSS/Dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/Dashboard/dashboardDropdown.css') }}">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #main-content {
            transition: margin-left 0.3s;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <x-sidebar />
        <header class="bg-blue-800 shadow fixed w-full z-10">
            <div class="max-w-auto mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center">
                <button id="toggle-sidebar" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12H9m6 6H9m6-12H9" />
                    </svg>
                </button>

                <div class="relative ml-auto">
                    <button type="button" class="flex items-center text-white focus:outline-none" id="user-menu-button"
                        aria-expanded="false" aria-haspopup="true">
                        <img src="{{ asset('assets/admin.png') }}" alt="User Avatar" class="w-8 h-8 rounded-full">
                        <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div class="absolute right-0 z-10 hidden mt-2 w-48 bg-white rounded-md shadow-lg"
                        id="user-menu-dropdown">
                        <div class="py-1" role="menu" aria-orientation="vertical"
                            aria-labelledby="user-menu-button">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="menuitem">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="menuitem">Account Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="menuitem">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main id="main-content">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="{{ asset('Functions/Dashboard/DashboardDropdown.js') }}"></script>
    <script src="{{ asset('Functions/Dashboard/ApexCharts.js') }}"></script>
    <script>
        document.getElementById('user-menu-button').addEventListener('click', function() {
            const dropdown = document.getElementById('user-menu-dropdown');
            dropdown.classList.toggle('hidden');
        });
    </script>
    <script>
        const toggleButton = document.getElementById('toggle-sidebar');
        const sidebar = document.getElementById('default-sidebar');
        const mainContent = document.getElementById('main-content');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0');

            mainContent.classList.toggle('ml-64');
            mainContent.classList.toggle('ml-0');
        });
    </script>

</body>

</html>
