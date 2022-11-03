<div x-data="{ currentTab: 0 }"
    x-init="$refs.searchBar.focus()"
    class="grid space-y-3">
    <div class="flex p-2 space-x-3 bg-white border-gray-300 rounded-lg shadow">
        <div class="w-1/2">
            <x-input placeholder="Search ...."
                x-ref="searchBar"
                wire:model.defer="search"
                wire:keydown.enter.prevent="searchByQrCode"
                type="search" />
        </div>
        <div wire:key="buttons"
            class="flex items-center space-x-3">
            {{-- <x-button wire:click="clear"
                negative
                spinner="clear">Clear</x-button> --}}
            <x-button label="Qr Code"
                icon="search"
                wire:click="search('qr_code')"
                spinner="searchByQrCode"
                primary />
            <x-button label="Room Number"
                icon="search"
                wire:click="search('phone_number')"
                primary />
        </div>
    </div>
    <div>
        <nav class="flex divide-x divide-gray-200 rounded-lg shadow isolate"
            aria-label="Tabs">
            @foreach ($tabs as $key => $tab)
                <button type="button"
                    x-on:click="currentTab = {{ $key }}"
                    @class([
                        'group relative min-w-0 flex-1 overflow-hidden bg-white px-4 py-4 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 focus:z-10',
                        'rounded-l-lg' => $loop->first,
                        'rounded-r-lg' => $loop->last,
                    ])
                    aria-current="page">
                    <span>
                        {{ $tab }}
                    </span>
                    <span
                        x-bind:class="currentTab === {{ $key }} ? 'absolute inset-x-0 bottom-0 h-0.5 bg-primary-500' :
                            'absolute inset-x-0 bottom-0 h-0.5 bg-transparent'"
                        aria-hidden="true"></span>
                </button>
            @endforeach
        </nav>
    </div>
    <div>
        @if ($this->guest)
            @include('front-desk.sub-views.guest-information')
            @include('front-desk.sub-views.transactions')
            <div x-cloak
                x-show="currentTab==2">
                @livewire('front-desk.transactions.change-room', [
                    'check_in_detail_id' => $this->guest->transactions->first()->check_in_detail->id,
                ])
            </div>
        @endif
    </div>
</div>
