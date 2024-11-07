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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #main-content {
            transition: margin-left 0.3s;
        }

        .select2-container--default .select2-selection--multiple {
            background-color: #fff;
            border-color: #d1d5db;
            padding: 0.5rem;
            border-radius: 0.375rem;
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
                    <button type="button" class="flex items-center text-white focus:outline-none mr-3"
                        id="notification-menu-button" aria-expanded="false" aria-haspopup="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" class="cursor-pointer fill-[#fff]"
                            viewBox="0 0 371.263 371.263">
                            <path
                                d="M305.402 234.794v-70.54c0-52.396-33.533-98.085-79.702-115.151.539-2.695.838-5.449.838-8.204C226.539 18.324 208.215 0 185.64 0s-40.899 18.324-40.899 40.899c0 2.695.299 5.389.778 7.964-15.868 5.629-30.539 14.551-43.054 26.647-23.593 22.755-36.587 53.354-36.587 86.169v73.115c0 2.575-2.096 4.731-4.731 4.731-22.096 0-40.959 16.647-42.995 37.845-1.138 11.797 2.755 23.533 10.719 32.276 7.904 8.683 19.222 13.713 31.018 13.713h72.217c2.994 26.887 25.869 47.905 53.534 47.905s50.54-21.018 53.534-47.905h72.217c11.797 0 23.114-5.03 31.018-13.713 7.904-8.743 11.797-20.479 10.719-32.276-2.036-21.198-20.958-37.845-42.995-37.845a4.704 4.704 0 0 1-4.731-4.731zM185.64 23.952c9.341 0 16.946 7.605 16.946 16.946 0 .778-.12 1.497-.24 2.275-4.072-.599-8.204-1.018-12.336-1.138-7.126-.24-14.132.24-21.078 1.198-.12-.778-.24-1.497-.24-2.275.002-9.401 7.607-17.006 16.948-17.006zm0 323.358c-14.431 0-26.527-10.3-29.342-23.952h58.683c-2.813 13.653-14.909 23.952-29.341 23.952zm143.655-67.665c.479 5.15-1.138 10.12-4.551 13.892-3.533 3.773-8.204 5.868-13.353 5.868H59.89c-5.15 0-9.82-2.096-13.294-5.868-3.473-3.772-5.09-8.743-4.611-13.892.838-9.042 9.282-16.168 19.162-16.168 15.809 0 28.683-12.874 28.683-28.683v-73.115c0-26.228 10.419-50.719 29.282-68.923 18.024-17.425 41.498-26.887 66.528-26.887 1.198 0 2.335 0 3.533.06 50.839 1.796 92.277 45.929 92.277 98.325v70.54c0 15.809 12.874 28.683 28.683 28.683 9.88 0 18.264 7.126 19.162 16.168z"
                                data-original="#000000"></path>
                        </svg>
                        <span class="ml-1 text-sm text-blue-100">{{ Auth::user()->unreadNotifications->count() }}</span>
                    </button>
                    <div class="absolute right-0 z-10 hidden mt-2 w-64 bg-white rounded-md shadow-lg"
                        id="notification-menu-dropdown">
                        <div class="py-1" role="menu" aria-orientation="vertical"
                            aria-labelledby="notification-menu-button">
                            <ul class="divide-y">
                                @forelse (Auth::user()->notifications as $notification)
                                    <li class='p-4 flex items-center hover:bg-gray-50 cursor-pointer'
                                        onclick="markAsRead('{{ $notification->id }}')">
                                        <div class="ml-6">
                                            <p class="text-xs text-gray-500 mt-2">{{ $notification->data['message'] }}
                                            </p>
                                            <p class="text-xs text-blue-600 leading-3 mt-2">
                                                {{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </li>
                                @empty
                                    <li class='p-4 flex items-center hover:bg-gray-50 cursor-pointer'>
                                        <div class="">
                                            <p class="text-md  text-blue-600 leading-3 mt-2">No Notifications
                                            </p>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>

                        </div>
                    </div>
                </div>


                <div class="relative ml-2">
                    <button type="button" class="flex items-center text-white focus:outline-none" id="user-menu-button"
                        aria-expanded="false" aria-haspopup="true">
                        <img src="{{ asset('assets/admin.png') }}" alt="User Avatar" class="w-8 h-8 rounded-full">
                        <svg class="ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
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
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        <main id="main-content">
            @yield('content')
        </main>
    </div>
    <script>
        function filterTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const rows = document.getElementById("tableBody").getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                let row = rows[i];
                let textContent = row.textContent.toLowerCase();
                row.style.display = textContent.includes(filter) ? "" : "none";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="{{ asset('Functions/Dashboard/DashboardDropdown.js') }}"></script>

    <script>
        document.getElementById('user-menu-button').addEventListener('click', function() {
            const dropdown = document.getElementById('user-menu-dropdown');
            dropdown.classList.toggle('hidden');
        });

        document.getElementById('notification-menu-button').addEventListener('click', function() {
            const dropdown = document.getElementById('notification-menu-dropdown');
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

    <script>
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        const unreadCountElement = document.querySelector('#notification-menu-button span');
                        const currentCount = parseInt(unreadCountElement.textContent);
                        unreadCountElement.textContent = currentCount - 1;
                    } else {
                        console.error('Failed to mark notification as read');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>


</body>

</html>
