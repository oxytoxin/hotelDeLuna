<div x-data="{ tab: 1 }"
    x-init="$refs.searchBar.focus()">
    <x-card shadow="shadow-md"
        padding="p-2 md:p-2">
        <x-slot:header>
            <div class="flex items-center p-2 space-x-3 border-b">
                <div class="w-1/2">
                    <x-input wire:model.defer="searchQuery"
                        x-ref="searchBar"
                        wire:keydown.enter.prevent="search"
                        placeholder="Search QR code" />
                </div>
                <div wire:key="buttom-actions">
                    @if (!$guest)
                        <x-button wire:click="search">Search <span class="text-xs">( or press enter
                                key)</span>
                        </x-button>
                    @else
                        <x-base.btn-danger wire:click="clear">Clear</x-base.btn-danger>
                    @endif
                </div>
            </div>
        </x-slot:header>
        <div>
            <x-base.suspense method="search"
                wire:target="search">
                <x-slot:default>
                    @if ($guest)
                        <div wire:key="main-content">
                            <div class="mb-2">
                                <div>
                                    <nav x-on:keydown.arrow-left.stop.window="tab > 1 ? tab-- : tab = 4"
                                        x-on:keydown.arrow-right.stop.window="tab < 4 ? tab++ : tab = 1"
                                        class="flex border divide-x divide-gray-200 rounded-lg isolate"
                                        aria-label="Tabs">
                                        <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->
                                        <button x-on:click="tab = 1"
                                            x-bind:class="{
                                                'text-gray-900': tab === 1,
                                                'text-gray-500 hover:text-gray-700': tab !==
                                                    1
                                            }"
                                            class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center bg-white rounded-l-lg group hover:bg-gray-50 focus:z-10"
                                            aria-current="page">
                                            <span>
                                                Guest Informations | Check In Details
                                            </span>
                                            <span x-show="tab === 1"
                                                class="bg-primary-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                                        </button>

                                        <button x-on:click="tab = 2"
                                            x-bind:class="{
                                                'text-gray-900': tab === 2,
                                                'text-gray-500 hover:text-gray-700': tab !==
                                                    2
                                            }"
                                            class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center bg-white group hover:bg-gray-50 focus:z-10">
                                            <span>
                                                Transactions
                                            </span>
                                            <span x-show="tab === 2"
                                                class="bg-primary-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                                        </button>

                                        <button x-on:click="tab = 3"
                                            x-bind:class="{
                                                'text-gray-900': tab === 3,
                                                'text-gray-500 hover:text-gray-700': tab !==
                                                    3
                                            }"
                                            class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center bg-white group hover:bg-gray-50 focus:z-10">
                                            <span>
                                                Additional Charges
                                            </span>
                                            <span x-show="tab === 3"
                                                class="bg-primary-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                                        </button>

                                        <button x-on:click="tab = 4"
                                            x-bind:class="{
                                                'text-gray-900': tab === 4,
                                                'text-gray-500 hover:text-gray-700': tab !==
                                                    4
                                            }"
                                            class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center bg-white rounded-r-lg group hover:bg-gray-50 focus:z-10">
                                            <span>
                                                Bill
                                            </span>
                                            <span x-show="tab === 4"
                                                class="bg-primary-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                                        </button>
                                    </nav>
                                </div>
                            </div>
                            <div x-cloak
                                x-show="tab==1"
                                x-collapse>
                                @include('front-desk.sub-views.guest-information')
                            </div>
                            <div x-cloak
                                x-show="tab==2"
                                x-collapse>
                                @include('front-desk.sub-views.transactions')
                            </div>
                            <div x-cloak
                                x-show="tab==3"
                                x-collapse>
                                @include('front-desk.sub-views.damages')
                            </div>
                        </div>
                    @endif
                </x-slot:default>
                <x-slot:fallback>
                    <div>
                        <div class="flex">
                            <div class="flex items-center justify-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h1>
                                    Searching for guest...
                                </h1>
                            </div>
                        </div>
                    </div>
                </x-slot:fallback>
            </x-base.suspense>
        </div>
    </x-card>
</div>
