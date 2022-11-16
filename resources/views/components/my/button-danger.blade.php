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
    class="{{ $py }} {{ $px }} {{ $textSize }} inline-flex items-center space-x-3 rounded-md border border-transparent bg-red-600 font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
    {{ $icon ?? '' }}
    <span>
        {{ $label }}
    </span>
</button>
