<div class="flex justify-end items-center mb-4">
    <div
        class="mb-4 flex items-center border border-gray-300 rounded focus-within:border-blue-500 focus-within:bg-blue-50">
        <x-lucide-search class="w-5 h-5 text-gray-500 ml-2 focus:text-blue-500" />
        <input type="text" id="searchInput" placeholder="{{ $placeholder ?? 'Search...' }}"
            class="p-2 border-0 w-full rounded pl-2 focus:outline-none focus:ring-0 focus:border-transparent focus:bg-blue-50"
            onkeyup="{{ $onkeyup ?? 'filterTable()' }}">
    </div>
</div>
