@props([
    'label' => null,
    'required' => false,
    'type' => 'text',
    'placeholder' => null,
    'errorOn' => null,
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
        class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:border-gray-400 focus:outline-none focus:ring-0 sm:text-sm">
        <option value=""
            selected
            hidden>
            {{ $placeholder }}
        </option>
        {{ $slot }}
    </select>
    @error($attributes->whereStartsWith('wire:model')->first())
        <span class="ml-1 text-red-600 text-start">
            {{ $message }}
        </span>
    @enderror
</div>
