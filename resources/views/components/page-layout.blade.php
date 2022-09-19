@props([
    'title' => '',
])

<div>
    <div class="my-5 space-y-3">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
            <x-page-title>
                {{ $title }}
            </x-page-title>
        </div>
        <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
            {{ $slot }}
        </div>
    </div>
</div>
