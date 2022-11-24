@props([
    'label' => null,
    'required' => false,
    'type' => 'text',
    'placeholder' => null,
    'numberOnly' => false,
])
<div x-id="['{{ $attributes->whereStartsWith('wire:model')->first() }}-input']"
    wire:ignore>
    <label :for="$id('{{ $attributes->whereStartsWith('wire:model')->first() }}-input')"
        class="block text-sm font-medium text-gray-700">
        {{ $label }} @if ($required)
            <span class="text-red-600">*</span>
        @endif
    </label>
    <div class="mt-1">
        <input type="{{ $type }}"
            {{ $attributes->whereStartsWith('wire:model') }}
            {{ $attributes->whereStartsWith('x') }}
            {{ $attributes->whereStartsWith('disabled') }}
            @if ($numberOnly) x-on:keyup="$el.value = $el.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1')" @endif
            :name="$id('{{ $attributes->whereStartsWith('wire:model')->first() }}-input')"\
            :id="$id('{{ $attributes->whereStartsWith('wire:model')->first() }}-input')"
            class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
            placeholder="{{ $placeholder }}">

        @error($attributes->whereStartsWith('wire:model')->first())
            <span class="ml-1 text-red-600 text-start">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
