@props([
    'loadingOn' => null,
    'label' => 'Submit',
    'type' => 'button',
    'icon' => null,
    'py' => 'py-2',
    'px' => 'px-4',
    'textSize' => 'text-sm',
])

<button type="{{ $type }}"
    {{ $attributes->whereStartsWith('wire:click') }}
    {{ $attributes->whereStartsWith('x-on:click') }}
    @if ($attributes->has('wire:click')) wire:loading.attr="disabled"
        wire:loading.class="cursor-progress" @endif
    class="{{ $py }} {{ $px }} {{ $textSize }} inline-flex items-center space-x-3 rounded-md border border-transparent bg-green-600 font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
    {{ $icon ?? '' }}
    <span>
        {{ $label }}
    </span>
    @if ($loadingOn)
        <svg wire:loading
            wire:target="{{ $loadingOn }}"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5 animate-spin fill-white">
            <path fill="none"
                d="M0 0h24v24H0z" />
            <path d="M18.364 5.636L16.95 7.05A7 7 0 1 0 19 12h2a9 9 0 1 1-2.636-6.364z" />
        </svg>
    @endif
</button>
