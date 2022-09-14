<div class="space-y-4">
    <div class="border border-gray-200 rounded-lg ">
        <x-card shadow="shadow-none"
            padding="p-2 md:p-2">
            <div class="flex space-x-2">
                <div>
                    <div class="relative">
                        <x-input placeholder="Scan or Type QR Code"
                            wire:model.defer="search"
                            icon="search" />
                        <div>
                            @if ($search != '')
                                <button type="button"
                                    wire:click="clear"
                                    class="absolute inset-y-0 right-0 flex items-center px-2 rounded-r-md focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-5 h-5 text-gray-400">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <x-button icon="search"
                    wire:click="search"
                    label="Search"
                    primary />
            </div>
        </x-card>
    </div>
    <div wire:key="guestinfo">
        @include('front-desk.sub.guest-information')
    </div>
    <div wire:key="transactions">
        @include('front-desk.sub.guest-transactions-list')
    </div>
    <div wire:key="damagecharges">
        @include('front-desk.sub.damage-charges-list')
    </div>
    <div wire:key="adddamagesmodal">
        @include('front-desk.sub.add-damages-form')
    </div>
    <div wire:key="extendmodal">
        @include('front-desk.sub.extend-form')
    </div>
    <div wire:key="changemodal">
        @include('front-desk.sub.change-room-form')
    </div>
</div>
