@props([
    'label' => null,
    'required' => false,
    'type' => 'text',
    'placeholder' => null,
    'numberOnly' => false,
    'options' => [],
    'searchable' => false,
])

<div x-id="['searchable-select-input']"
    x-data="{ isOpen: false, selectedId: @entangle($attributes->whereStartsWith('wire:model')->first()).defer, options: @js($options) }">
    <label :for="$id('searchable-select-input')"
        class="block text-sm font-medium text-gray-700">
        {{ $label }} @if ($required)
            <span class="text-red-600">*</span>
        @endif
    </label>
    <div class="relative mt-1">
        <button type="button"
            x-on:click="isOpen = !isOpen"
            class="block w-full rounded-md border border-gray-300 bg-white py-[8.3px] shadow-sm focus:border-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
            aria-haspopup="listbox"
            aria-expanded="true"
            aria-labelledby="listbox-label">
            <span class="block truncate pl-3 text-left">
                Select
            </span>
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                <svg class="h-5 w-5 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                        clip-rule="evenodd" />
                </svg>
            </span>
        </button>
        <ul x-cloak
            x-show="isOpen"
            x-on:click.away="isOpen = false"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            tabindex="-1"
            role="listbox"
            aria-labelledby="listbox-label"
            aria-activedescendant="listbox-option-3">
            @if ($searchable)
                <li class="px-3 py-2">
                    <input type="search"
                        name="search"
                        id="search"
                        class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-gray-400 focus:outline-none focus:ring-0 sm:text-sm">
                </li>
            @endif
            <template x-for="(option,index) in options"
                :key="index">
                <li class="relative cursor-default select-none py-2 pl-8 pr-4 text-gray-900 hover:bg-primary-100"
                    id="listbox-option-0"
                    role="option">
                    <span class="block truncate font-normal"
                        x-text="option">

                    </span>
                </li>
            </template>
        </ul>
    </div>
</div>
