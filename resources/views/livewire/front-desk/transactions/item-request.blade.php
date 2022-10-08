<div class="gap-4 sm:grid sm:grid-cols-2">
    <div class="sm:col-span-1">
        <x-card shadow="shadow"
            title="Amenities"
            cardClasses="border-gray-300 border">
            <div class="w-full">
                <form class="gap-4 sm:grid sm:grid-cols-1">
                    @csrf
                    <x-native-select wire:model="form.requestable_item_id"
                        label="Select Type">
                        <option value="">Select</option>
                        @foreach ($requestable_items as $requestable_item)
                            <option value="{{ $requestable_item->id }}">
                                {{ $requestable_item->name }} -- ₱{{ $requestable_item->price }}
                            </option>
                        @endforeach
                    </x-native-select>
                    <x-input type="numeric"
                        wire:model.defer="form.quantity"
                        label="Quantity" />
                    <x-input type="numeric"
                        wire:model.defer="form.additional_amount"
                        label="Additional Amount" />
                    <x-checkbox id="right-label"
                        label="Paid"
                        wire:model.defer="form.paid" />
                </form>
            </div>
            <x-slot:footer>
                <div class="flex items-center space-x-3">
                    <x-button wire:click="clearForm"
                        spinner="clearForm">Clear Form</x-button>
                    <x-button primary
                        wire:click="saveRecord"
                        spinner="saveRecord">Save Record</x-button>
                </div>
            </x-slot:footer>
        </x-card>
    </div>
    <div class="sm:col-span-1">
        <div class="grid gap-1">
            <div class="flex items-center justify-between">
                <h1 class="text-center text-gray-600">
                    Requested Items
                </h1>
                <div>
                    <button type="button"
                        wire:click="toggleToggleRequestOrder"
                        class="flex items-center space-x-2 text-gray-600">
                        <span>{{ $requestOrder == 'ASC' ? 'Oldest' : 'Newest' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25" />
                        </svg>
                    </button>
                </div>
            </div>
            <div wire:key="history-list"
                x-animate>
                @forelse ($guest_request_items as $guest_request_item)
                    <div wire:key="{{ $guest_request_item->id }}"
                        class="p-2 mb-2 bg-white border rounded-lg">
                        <div class="flex justify-between w-full">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <h1>
                                    {{ $guest_request_item->requestable_item->name }}
                                </h1>
                                <h1>
                                    | Total : ₱ {{ $guest_request_item->amount }}
                                    {{ $guest_request_item->additional_amount ? ' + ₱ ' . $guest_request_item->additional_amount : '' }}
                                </h1>
                                <h1>
                                    | QTY: {{ $guest_request_item->quantity }}
                                </h1>
                            </div>
                        </div>
                    </div>
                @empty
                    <div wire:key="empty"
                        class="p-2 mb-2 bg-white border rounded-lg">
                        <div class="flex justify-between w-full">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <h1>
                                    No changes yet
                                </h1>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
