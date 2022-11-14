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
    class="bg-trasparent inline-flex items-center space-x-3 rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2">
    {{ $icon ?? '' }}
    <span>
        {{ $label }}
    </span>
</button>
