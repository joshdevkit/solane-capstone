<div class="flex">
    <aside id="default-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidenav">
        <div class="flex items-center justify-between h-20 px-3">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-20">
        </div>
        <div class="overflow-y-auto py-5 px-3 h-full bg-gray-200 border-r border-gray-200">
            <ul class="space-y-2">
                {{-- Initialize sidebarItems with a default empty array --}}
                @php
                    $sidebarItems = [];
                @endphp

                {{-- Admin Sidebar Items --}}
                @role('Admin')
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
                            [
                                'icon' => 'assets/sales.png',
                                'label' => 'Sales',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'List Sales', 'route' => 'sales.index'],
                                    ['label' => 'Add Sale', 'route' => 'sales.create'],
                                ],
                            ],
                            [
                                'icon' => 'assets/sales.png',
                                'label' => 'Purchase',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'List Purchase', 'route' => 'purchase.index'],
                                    ['label' => 'Add Purchase', 'route' => 'purchase.create'],
                                ],
                            ],
                            [
                                'icon' => 'assets/sales.png',
                                'label' => 'Returns',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'List Returns', 'route' => 'returns.index'],
                                    ['label' => 'Pull Out Records', 'route' => 'pullout'],
                                ],
                            ],
                            [
                                'icon' => 'assets/people.png',
                                'label' => 'People',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'Customers', 'route' => 'customers.index'],
                                    ['label' => 'Add Customer', 'route' => 'customers.create'],
                                    ['label' => 'Suppliers', 'route' => 'suppliers.index'],
                                    ['label' => 'Add Suppliers', 'route' => 'suppliers.create'],
                                ],
                            ],
                            [
                                'icon' => 'assets/people.png',
                                'label' => 'Accounts',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'Users', 'route' => 'users.index'],
                                    ['label' => 'Add Users', 'route' => 'users.create'],
                                ],
                            ],
                            [
                                'icon' => 'assets/category.png',
                                'label' => 'Forms',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'List of Forms', 'route' => 'uploaded-forms.index'],
                                ],
                            ],
                        ];
                    @endphp
                @endrole

                {{-- Inventory Sidebar Items --}}
                @role('Inventory')
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
                            [
                                'icon' => 'assets/sales.png',
                                'label' => 'Purchase',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'List Purchase', 'route' => 'purchase.index'],
                                    ['label' => 'Add Purchase', 'route' => 'purchase.create'],
                                ],
                            ],
                            [
                                'icon' => 'assets/sales.png',
                                'label' => 'Returns',
                                'route' => 'returns.index',
                            ],
                            [
                                'icon' => 'assets/people.png',
                                'label' => 'Suppliers',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'List Suppliers', 'route' => 'suppliers.index'],
                                    ['label' => 'Add Suppliers', 'route' => 'suppliers.create'],
                                ],
                            ],
                        ];
                    @endphp
                @endrole

                {{-- Sales Sidebar Items --}}
                @role('Sales')
                    @php
                        $sidebarItems = [
                            ['icon' => 'assets/dashboard.png', 'label' => 'Dashboard', 'route' => 'dashboard'],
                            [
                                'icon' => 'assets/sales.png',
                                'label' => 'Sales',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'List Sales', 'route' => 'sales.index'],
                                    ['label' => 'Add Sale', 'route' => 'sales.create'],
                                ],
                            ],
                            [
                                'icon' => 'assets/people.png',
                                'label' => 'People',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'Customers', 'route' => 'customers.index'],
                                    ['label' => 'Add Customer', 'route' => 'customers.create'],
                                ],
                            ],
                        ];
                    @endphp
                @endrole

                {{-- Render Sidebar Items --}}
                @foreach ($sidebarItems as $item)
                    <x-sidebar-item :icon="$item['icon']" :label="$item['label']" :route="$item['route']" :dropdownItems="$item['dropdownItems'] ?? []" />
                @endforeach
            </ul>
        </div>
    </aside>
</div>
