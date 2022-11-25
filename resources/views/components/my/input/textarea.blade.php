@props([
    'label' => null,
    'required' => false,
    'type' => 'text',
    'placeholder' => null,
    'numberOnly' => false,
    'rows' => 4,
])

<div x-id="['textarea-input']">
    <label :for="$id('textarea-input')"
        class="block text-sm font-medium text-gray-700">
        {{ $label }} @if ($required)
            <span class="text-red-600">*</span>
        @endif
    </label>
    <div class="mt-1">
        <textarea rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->whereStartsWith('wire:model') }}
            {{ $attributes->whereStartsWith('x') }}
            :name="$id('textarea-input')"
            :id="$id('textarea-input')"
            class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-gray-400 focus:outline-none focus:ring-0 sm:text-sm"></textarea>
        @error($attributes->whereStartsWith('wire:model')->first())
            <span class="ml-1 text-red-600 text-start">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>
