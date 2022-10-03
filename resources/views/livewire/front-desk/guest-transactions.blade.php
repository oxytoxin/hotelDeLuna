<div x-data="{ tab: 1 }"
    x-init="$refs.searchBar.focus()"
    class="grid space-y-3">
    <div class="flex space-x-3 p-2 bg-white rounded-lg border-gray-300 border">
        <div class="w-1/2">
            <x-input placeholder="Search ...."
                x-ref="searchBar"
                wire:model.defer="search"
                wire:keydown.enter.prevent="search"
                type="search" />
        </div>
        <div wire:key="buttons"
            class="flex space-x-3 items-center">
            <x-button wire:click="search('qr')"
                primary
                icon="search"
                spinner="search('qr')">QR CODE</x-button>
            @if ($guest)
                <x-button wire:click="clear"
                    negative
                    spinner="clear">Clear</x-button>
            @endif
        </div>
    </div>
    <div x-animate>
        @if ($guest)
            <div wire:key="{{ $guest->id }}-actions"
                class="flex space-x-3">
                <x-button white
                    wire:click="$set('action',null)">
                    Guest Information/Transactions
                </x-button>
                <x-button white
                    wire:click="$set('action','change-room')">
                    Change Room
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
                    Item Request
                </x-button>
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
                    @include('front-desk.sub-views.guest-informations-and-transactions')
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
