<div class="flex">
    <aside id="default-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidenav">
        <div class="flex items-center justify-center h-20 px-3">
            <img src="{{ asset('assets/Solane Logo.png') }}" alt="Logo" class="h-12">
        </div>
        <div class="overflow-y-auto py-5 px-3 h-full bg-gray-200 border-r border-gray-200">
            <ul class="space-y-2">
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
                                'icon' => 'assets/total sales.png',
                                'label' => 'Sales',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'List Sales', 'route' => 'sales.index'],
                                    ['label' => 'Add Sale', 'route' => 'sales.create'],
                                ],
                            ],
                            [
                                'icon' => 'assets/NEW PURCHASED.png',
                                'label' => 'Purchase',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'List Purchase', 'route' => 'purchase.index'],
                                    ['label' => 'Add Purchase', 'route' => 'purchase.create'],
                                ],
                            ],
                            [
                                'icon' => 'assets/NEW RETURNS.png',
                                'label' => 'Returns',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'List Returns', 'route' => 'returns.index'],
                                    ['label' => 'Pull Out Records', 'route' => 'pullout'],
                                ],
                            ],

                            [
                                'icon' => 'assets/NEW CUSTOMERS.png',
                                'label' => 'Customers',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'Customers', 'route' => 'customers.index'],
                                    ['label' => 'Add Customer', 'route' => 'customers.create'],
                                ],
                            ],
                            [
                                'icon' => 'assets/NEW supplier.png',
                                'label' => 'Suppliers',
                                'route' => '',
                                'dropdownItems' => [
                                    ['label' => 'Suppliers', 'route' => 'suppliers.index'],
                                    ['label' => 'Add Suppliers', 'route' => 'suppliers.create'],
                                ],
                            ],
                            [
                                'icon' => 'assets/NEW accounts.png',
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
                                'dropdownItems' => [['label' => 'List of Forms', 'route' => 'uploaded-forms.index']],
                            ],
                            [
                                'icon' => 'assets/forecasting.png',
                                'label' => 'Forecasting',
                                'route' => '',
                                'dropdownItems' => [['label' => 'Forecast', 'route' => 'forecast']],
                            ],
                        ];
                    @endphp
                @endrole

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

                @foreach ($sidebarItems as $item)
                    <x-sidebar-item :icon="$item['icon']" :label="$item['label']" :route="$item['route']" :dropdownItems="$item['dropdownItems'] ?? []" />
                @endforeach
            </ul>
        </div>
    </aside>
</div>
