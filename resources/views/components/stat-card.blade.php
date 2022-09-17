@props([
    'icon' => null,
    'title' => null,
    'value' => null,
    'actions' => null,
])

<div class="relative px-4 pt-5 pb-12 overflow-hidden bg-white rounded-lg shadow sm:px-6 sm:pt-6">
    <dt>
        <div class="absolute p-3 bg-indigo-500 rounded-md">
            {{ $icon }}
        </div>
        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
            {{ $title ?? 'Title' }}
        </p>
    </dt>
    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
        <p class="text-2xl font-semibold text-gray-900">
            {{ $value ?? '0' }}
        </p>
        <div class="absolute inset-x-0 bottom-0 px-4 py-4 bg-gray-50 sm:px-6">
            <div class="text-sm">
                {{ $actions ?? '' }}
            </div>
        </div>
    </dd>
</div>
