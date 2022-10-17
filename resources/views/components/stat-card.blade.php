@props([
    'icon' => null,
    'title' => null,
    'value' => null,
    'actions' => null,
])

<div class="relative px-4 pt-5 pb-12 overflow-hidden bg-white border border-gray-300 rounded-lg sm:px-6 sm:pt-6">
    <dt>
        <div class="absolute p-3 bg-indigo-500 rounded-md">
            {{ $icon }}
        </div>
        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
            {{ $title ?? 'Title' }}
        </p>
    </dt>
    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
        <p class="text-lg font-semibold text-gray-900">
            {{ $value ?? '0' }}
        </p>
        <div class="absolute inset-x-0 bottom-0 px-2 py-2 bg-gray-50 sm:px-2">
            <div class="text-xs">
                {{ $actions ?? '' }}
            </div>
        </div>
    </dd>
</div>
