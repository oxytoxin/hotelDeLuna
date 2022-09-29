<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center rounded-lg border border-red-500  bg-red-500  px-4 py-2 text-sm font-medium text-white  hover:bg-red-600 focus:outline-none ']) }}
    wire:loading.attr="disabled"
    wire:loading.class="cursor-progress">
    {{ $slot }}
</button>
