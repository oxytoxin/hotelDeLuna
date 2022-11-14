<div>
    <div class="relative mt-1 rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-5 h-5 text-gray-400">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <input {{ $attributes->whereStartsWith('wire:model') }}
            name=" {{ $attributes->whereStartsWith('wire:model')->first() }}"
            id=" {{ $attributes->whereStartsWith('wire:model')->first() }}"
            type="search"
            name="search"
            id="search"
            class="block w-full pl-10 border border-gray-300 rounded-md shadow-sm focus:border-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
            placeholder="Search">
    </div>
</div>
