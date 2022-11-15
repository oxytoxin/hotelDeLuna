@props([
    'label' => null,
    'required' => false,
    'type' => 'text',
    'placeholder' => null,
])
<div x-id="['select-input']">
    <label :for="$id('select-input')"
        class="block text-sm font-medium text-gray-700">
        {{ $label }} @if ($required)
            <span class="text-red-600">*</span>
        @endif
    </label>
    <select :id="$id('select-input')"
        :name="$id('select-input')"
        {{ $attributes->whereStartsWith('wire:model') }}
        {{ $attributes->whereStartsWith('x') }}
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-gray-400 focus:outline-none focus:ring-0 sm:text-sm">
        <option value=""
            selected
            hidden>
            {{ $placeholder }}
        </option>
        {{ $slot }}
    </select>
    @error($attributes->whereStartsWith('wire:model')->first())
        <span class="ml-1 text-start text-red-600">
            {{ $message }}
        </span>
    @enderror
</div>
