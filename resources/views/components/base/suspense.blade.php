@props(['method' => '', 'default' => '', 'fallback' => ''])

<div wire:key="{{ $method }}-suspense">
    <div wire:key="default-{{ $method }}"
        wire:loading.remove
        {{ $attributes->whereStartsWith('wire:target') }}>
        {{ $default }}
    </div>
    <div wire:key="fallback-{{ $method }}"
        wire:loading.delay.longer
        {{ $attributes->whereStartsWith('wire:target') }}>
        {{ $fallback }}
    </div>
</div>
