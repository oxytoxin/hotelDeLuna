@props([
    'loadingOn' => null,
    'label' => 'Submit',
    'type' => 'button',
    'icon' => null,
])

<button type="{{ $type }}"
    {{ $attributes->whereStartsWith('wire:click') }}
    {{ $attributes->whereStartsWith('x-on:click') }}
    @if ($attributes->has('wire:click')) wire:loading.attr="disabled"
        wire:loading.class="cursor-progress" @endif
    class="inline-flex items-center px-4 py-2 space-x-3 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
    {{ $icon ?? '' }}
    <span>
        {{ $label }}
    </span>
    @if ($loadingOn)
        <svg wire:loading
            wire:target="{{ $loadingOn }}"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="w-5 h-5 animate-spin fill-white">
            <path fill="none"
                d="M0 0h24v24H0z" />
            <path d="M18.364 5.636L16.95 7.05A7 7 0 1 0 19 12h2a9 9 0 1 1-2.636-6.364z" />
        </svg>
    @endif
</button>
