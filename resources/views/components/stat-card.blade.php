@props([
    'icon' => null,
    'title' => null,
    'value' => null,
])

<div class="relative p-5 px-4 overflow-hidden bg-white rounded-lg shadow ">
    <dt>
        {{ $icon }}
        <p class="ml-16 text-sm font-bold text-gray-700 truncate">
            {{ $title }}
        </p>
    </dt>
    <dd class="flex items-baseline ml-16 ">
        <p class="text-2xl font-semibold text-gray-900">
            {{ $value }}
        </p>
    </dd>
    <div class="flex justify-end">
        {{ $slot }}
    </div>
</div>
