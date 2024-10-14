<div class="flex">
    <aside id="default-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidenav">
        <div class="flex items-center justify-between h-20 px-3">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-20">

        </div>
        <div class="overflow-y-auto py-5 px-3 h-full bg-gray-200 border-r border-gray-200">
            <ul class="space-y-2">
                @php
                    $sidebarItems = [
                        ['icon' => 'assets/dashboard.png', 'label' => 'Dashboard', 'route' => 'dashboard'],
                        [
                            'icon' => 'assets/products.png',
                            'label' => 'Products',
                            'route' => '',
                            'dropdownItems' => [
                                ['label' => 'List Products', 'route' => 'products.index'],
                                ['label' => 'Add Product', 'route' => 'products.create'],
                                // ['label' => 'Product Categories', 'route' => ''],
                            ],
                        ],
                        [
                            'icon' => 'assets/category.png',
                            'label' => 'Categories',
                            'route' => '',
                            'dropdownItems' => [
                                ['label' => 'List Categories', 'route' => 'category.index'],
                                ['label' => 'Add Category', 'route' => 'category.create'],
                            ],
                        ],
                        // [
                        //     'icon' => 'assets/sales.png',
                        //     'label' => 'Sales',
                        //     'route' => '',
                        //     'dropdownItems' => [
                        //         ['label' => 'List Sales', 'route' => ''],
                        //         ['label' => 'Add Sale', 'route' => ''],
                        //         ['label' => 'Sales Reports', 'route' => ''],
                        //     ],
                        // ],
                        // [
                        //     'icon' => 'assets/people.png',
                        //     'label' => 'Customers',
                        //     'route' => '',
                        //     'dropdownItems' => [
                        //         ['label' => 'List Customers', 'route' => ''],
                        //         ['label' => 'Add Customer', 'route' => ''],
                        //     ],
                        // ],
                        // [
                        //     'icon' => 'assets/people.png',
                        //     'label' => 'Users',
                        //     'route' => '',
                        //     'dropdownItems' => [
                        //         ['label' => 'List Users', 'route' => ''],
                        //         ['label' => 'Add User', 'route' => ''],
                        //         ['label' => 'User Roles', 'route' => ''],
                        //     ],
                        // ],
                        // [
                        //     'icon' => 'assets/reports.png',
                        //     'label' => 'Reports',
                        //     'route' => '',
                        //     'dropdownItems' => [
                        //         ['label' => 'Sales Reports', 'route' => ''],
                        //         ['label' => 'Customer Reports', 'route' => ''],
                        //         ['label' => 'Product Reports', 'route' => ''],
                        //     ],
                        // ],
                    ];
                @endphp
                @foreach ($sidebarItems as $item)
                    <x-sidebar-item :icon="$item['icon']" :label="$item['label']" :route="$item['route']" :dropdownItems="$item['dropdownItems'] ?? []" />
                @endforeach
            </ul>
        </div>
    </aside>
</div>
