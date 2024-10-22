<li>
    @if (!empty($dropdownItems))
        @php
            // Check if the current route matches any of the dropdown item routes
            $isOpen = false;
            foreach ($dropdownItems as $item) {
                if (Route::is($item['route']) || Route::is($item['route'] . '.*')) {
                    $isOpen = true;
                    break;
                }
            }
        @endphp

        <button type="button"
            class="flex items-center p-2 w-full text-base font-normal text-black rounded-lg transition duration-75 hover:bg-gray-300"
            aria-controls="{{ $label }}" data-collapse-toggle="{{ $label }}">
            <img src="{{ asset($icon) }}" alt="{{ $label }} icon" class="w-6 h-6 flex-shrink-0">
            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $label }}</span>
            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        <ul id="{{ $label }}" class="{{ $isOpen ? '' : 'hidden' }} py-2 space-y-2">
            @foreach ($dropdownItems as $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center p-2 pl-11 w-full text-base font-normal text-black rounded-lg transition duration-75 hover:bg-gray-300 {{ Route::is($item['route']) || Route::is($item['route'] . '.*') ? 'bg-gray-300' : '' }}">
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <a href="{{ route($route) }}"
            class="flex items-center p-2 text-base font-normal text-black rounded-lg hover:bg-gray-300 {{ Route::is($route) || Route::is($route . '.*') ? 'bg-gray-300' : '' }}">
            <img src="{{ asset($icon) }}" alt="{{ $label }} logo" class="w-6 h-6">
            <span class="ml-3">{{ $label }}</span>
        </a>
    @endif
</li>
