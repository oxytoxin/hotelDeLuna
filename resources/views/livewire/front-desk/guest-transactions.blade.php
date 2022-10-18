<div x-data="{ tab: 1 }"
    x-init="$refs.searchBar.focus()"
    class="grid space-y-3">
    <div class="flex p-2 space-x-3 bg-white border border-gray-300 rounded-lg">
        <div class="w-1/2">
            <x-input placeholder="Search ...."
                x-ref="searchBar"
                wire:model.defer="search"
                wire:keydown.enter.prevent="searchByQrCode"
                type="search" />
        </div>
        <div wire:key="buttons"
            class="flex items-center space-x-3">

            @if ($guest)
                <x-button wire:click="clear"
                    negative
                    spinner="clear">Clear</x-button>
            @else
                <x-button label="Qr Code"
                    icon="search"
                    wire:click="searchByQrCode"
                    spinner="searchByQrCode"
                    primary />
                <x-button label="Room Number"
                    icon="search"
                    wire:click="searchByRoomNumber"
                    primary />
                {{-- <x-button label="Name"
                    icon="search"
                    wire:click="searchByName"
                    primary /> --}}
            @endif
        </div>
    </div>
    <div x-animate>
        @if ($guest)
            <div wire:key="{{ $guest->id }}-actions">
                <div>
                    <div>
                        <nav class="flex divide-x divide-gray-200 rounded-lg shadow isolate"
                            aria-label="Tabs">
                            <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->
                            <button type="button"
                                wire:click="$set('action',null)"
                                class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-500 bg-white rounded-l-lg hover:text-gray-700 group hover:bg-gray-50 focus:z-10"
                                aria-current="page">
                                <span>Information</span>
                                <span aria-hidden="true"
                                    @class([
                                        'absolute inset-x-0 bottom-0 h-0.5',
                                        'bg-primary-500' => $action == null,
                                    ])></span>
                            </button>
                            <button type="button"
                                wire:click="$set('action','transactions')"
                                class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-500 bg-white hover:text-gray-700 group hover:bg-gray-50 focus:z-10">
                                <span>Transactions</span>
                                <span aria-hidden="true"
                                    @class([
                                        'absolute inset-x-0 bottom-0 h-0.5',
                                        'bg-primary-500' => $action == 'transactions',
                                    ])></span>
                            </button>
                            <button type="button"
                                wire:click="$set('action','change-room')"
                                class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-500 bg-white hover:text-gray-700 group hover:bg-gray-50 focus:z-10">
                                <span>Transfer</span>
                                <span aria-hidden="true"
                                    @class([
                                        'absolute inset-x-0 bottom-0 h-0.5',
                                        'bg-primary-500' => $action == 'change-room',
                                    ])></span>
                            </button>

                            <button type="button"
                                wire:click="$set('action','extend-hours')"
                                class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-500 bg-white hover:text-gray-700 group hover:bg-gray-50 focus:z-10">
                                <span>Extend</span>
                                <span aria-hidden="true"
                                    @class([
                                        'absolute inset-x-0 bottom-0 h-0.5',
                                        'bg-primary-500' => $action == 'extend-hours',
                                    ])></span>
                            </button>
                            <button type="button"
                                wire:click="$set('action','add-damages')"
                                class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-500 bg-white hover:text-gray-700 group hover:bg-gray-50 focus:z-10">
                                <span> Damage Charges</span>
                                <span aria-hidden="true"
                                    @class([
                                        'absolute inset-x-0 bottom-0 h-0.5',
                                        'bg-primary-500' => $action == 'add-damages',
                                    ])></span>
                            </button>
                            <button type="button"
                                wire:click="$set('action','item-request')"
                                class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-500 bg-white hover:text-gray-700 group hover:bg-gray-50 focus:z-10">
                                <span>Amenities</span>
                                <span aria-hidden="true"
                                    @class([
                                        'absolute inset-x-0 bottom-0 h-0.5',
                                        'bg-primary-500' => $action == 'item-request',
                                    ])
                                    class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
                            </button>
                            <button type="button"
                                class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-500 bg-white rounded-r-lg hover:text-gray-700 group hover:bg-gray-50 focus:z-10">
                                <span>Deposit </span>
                                <span aria-hidden="true"
                                    class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
                            </button>
                        </nav>
                    </div>
                </div>

                {{-- <x-button white
                    wire:click="$set('action',null)">
                    Guest Information/Transactions
                </x-button>
                <x-button white
                    wire:click="$set('action','change-room')">
                    Transfer
                </x-button>
                <x-button white
                    wire:click="$set('action','extend-hours')">
                    Extend
                </x-button>
                <x-button white
                    wire:click="$set('action','add-damages')">
                    Damage Charges
                </x-button>
                <x-button white
                    wire:click="$set('action','item-request')">
                    Amenities
                </x-button> --}}
            </div>
        @endif
    </div>
    <div>
        @if ($guest)
            @php
                $check_in_detail_id = $guest
                    ->transactions()
                    ->where('transaction_type_id', 1)
                    ->first()->check_in_detail->id;
            @endphp
            @switch($action)
                @case(null)
                    <div>
                        @include('front-desk.sub-views.guest-informations-and-transactions')
                    </div>
                @break

                @case('transactions')
                    @include('front-desk.sub-views.transactions')
                @break

                @case('change-room')
                    @livewire('front-desk.transactions.change-room', [
                        'check_in_detail_id' => $check_in_detail_id,
                    ])
                @break

                @case('extend-hours')
                    @livewire('front-desk.transactions.extend-hours', [
                        'check_in_detail_id' => $check_in_detail_id,
                        'guest_id' => $guest->id,
                    ])
                @break

                @case('add-damages')
                    @livewire('front-desk.transactions.add-damages', [
                        'guest_id' => $guest->id,
                    ])
                @break

                @case('item-request')
                    @livewire('front-desk.transactions.item-request', [
                        'guest_id' => $guest->id,
                    ])
                @break

                @default
            @endswitch
        @endif
    </div>
</div>
