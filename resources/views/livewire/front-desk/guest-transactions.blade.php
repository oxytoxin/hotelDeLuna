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
                            @foreach ($tabs as $key => $tab)
                                <button type="button"
                                    wire:click="switchTab({{ $key }})"
                                    @class([
                                        'group relative min-w-0 flex-1 overflow-hidden bg-white px-4 py-4 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 focus:z-10',
                                        'rounded-l-lg' => $loop->first,
                                        'rounded-r-lg' => $loop->last,
                                    ])
                                    aria-current="page">
                                    <span>
                                        {{ $tab }}
                                    </span>
                                    <span aria-hidden="true"
                                        @class([
                                            'absolute inset-x-0 bottom-0 h-0.5',
                                            'bg-primary-500' => $current_tab == $key,
                                        ])></span>
                                </button>
                            @endforeach
                        </nav>
                    </div>
                </div>
            </div>
        @endif
        @if ($search && $searchBy && is_null($guest))
            <div class="p-4 border border-red-400 rounded-md bg-red-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1 ml-3 md:flex md:justify-start">
                        <p class="text-sm text-red-700">
                            @if ($searchBy == 'room_number')
                                No guest found with room number <strong>{{ $search }}</strong>
                            @else
                                No guest found with QR CODE : <strong>{{ $search }}</strong>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div id="tab-content">
        @if ($guest)
            @includeWhen($current_tab == 0, 'front-desk.guest-transactions.information-tab.guest-information')
            @includeWhen($current_tab == 1, 'front-desk.guest-transactions.transactions-tab.transaction-list')
            @if ($current_tab == 2)
                <div class="gap-4 sm:grid sm:grid-cols-2">
                    @include('front-desk.guest-transactions.transfer-tab.transfer-form')
                </div>
            @endif
        @endif
    </div>
</div>
