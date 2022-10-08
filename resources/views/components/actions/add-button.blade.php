<button wire:loading.attr="disabled"
    wire:loading.class="cursor-progress"
    {{ $attributes->merge([
        'class' =>
            'bg-primary-500 text-white py-2 text-sm px-4 rounded-lg hover:bg-primary-400 duration-150 ease-in-out flex space-x-2 items-center',
    ]) }}>
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-4 h-4 text-white">
        <path stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 4.5v15m7.5-7.5h-15" />
    </svg>
    <span>{{ $slot }}</span>
</button>
