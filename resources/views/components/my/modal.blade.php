@props([
    'showOn' => [],
    'closeOn' => [],
    'title' => null,
    'allowClose' => true,
    'footer' => null,
    'width' => 'sm:max-w-2xl',
])
<div x-data="{
    show: false,
    close() {
        this.show = false;
    },
    open() {
        this.show = true;
    },
}"
    @foreach ($showOn as $event)
            x-on:{{ $event }}.window="open()" @endforeach
    @foreach ($closeOn as $event)
            x-on:{{ $event }}.window="close()" @endforeach>
    <div x-cloak
        x-show="show"
        class="relative z-50"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true">

        <div x-cloak
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-full items-start justify-center p-4 text-center sm:p-0">
                <div x-cloak
                    x-show="show"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="{{ $width }} relative transform overflow-hidden rounded-lg border border-primary-600 bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-3 sm:w-full sm:p-6">
                    <div>
                        <div class="flex items-center justify-between">
                            <h1 class="text-lg">
                                {{ $title }}
                            </h1>
                            <div>
                                @if ($allowClose)
                                    <button x-on:click="show=false"
                                        type="button"
                                        class="text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="h-6 w-6">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="my-2">
                            {{ $slot }}
                        </div>
                    </div>
                    @if ($footer)
                        <div class="mt-5">
                            <div class="flex">
                                {{ $footer }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
