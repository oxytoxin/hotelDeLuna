@props([
    'required' => false,
])
<div x-data
    x-init="FilePond.create($refs.input);"
    x-id="['{{ $attributes->whereStartsWith('wire:model')->first() }}-input']">
    <div class="mt-1">
        <input type="file"
            x-ref="input"
            {{ $attributes->whereStartsWith('wire:model') }}
            {{ $attributes->whereStartsWith('x') }}
            {{ $attributes->whereStartsWith('disabled') }}
            :name="$id('{{ $attributes->whereStartsWith('wire:model')->first() }}-input')"
            :id="$id('{{ $attributes->whereStartsWith('wire:model')->first() }}-input')">

        @error($attributes->whereStartsWith('wire:model')->first())
            <span class="ml-1 text-start text-red-600">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
