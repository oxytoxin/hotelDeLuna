<div class="sm:grid sm:grid-cols-2 gap-4">
    <div class="sm:col-span-1">
        <x-card shadow="shadow"
            title="Change Room"
            cardClasses="border-gray-300 border">
            <form class="sm:grid-cols-1 sm:grid gap-4">
                @csrf
                <x-native-select label="Item"
                    wire:model="form.item_id">
                    <option value="">Select</option>
                    @foreach ($hotel_items as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </x-native-select>
                <x-input label="Amount"
                    wire:model.defer="form.amount"
                    disabled />
                <x-input label="Additional Amount"
                    wire:model.defer="form.additional_amount"
                    hint="Optional"
                    type="numeric" />
                <x-input label="Occured At"
                    wire:model.defe="form.occured_at"
                    type="datetime-local" />
                <x-checkbox id="right-label"
                    label="Paid"
                    wire:model.defer="form.paid" />
            </form>
            <x-slot:footer>
                <div class="flex space-x-3 items-center">
                    <x-button wire:click="clear_form">Clear Form</x-button>
                    <x-button wire:click="save"
                        spinner="save"
                        primary>Save</x-button>
                </div>
            </x-slot:footer>
        </x-card>
    </div>
    <div class="sm:col-span-1">
        <div class="grid gap-1">
            <div class="flex justify-between items-center">
                <h1 class="text-gray-600 text-center">
                    Record List
                </h1>
                <div class="flex space-x-3">
                    <button wire:click="toogleDamagesOrderBy"
                        type="button"
                        class="text-gray-600 flex items-center space-x-2">
                        <span>{{ $damagesOrderBy == 'ASC' ? 'Oldest' : 'Newest' }}</span>
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
                @forelse ($damages as $damage)
                    <div wire:key="{{ $damage->id }}"
                        class="bg-white rounded-lg border p-2 mb-2">
                        <div class="w-full flex justify-between">
                            <div class="flex space-x-2 items-center text-gray-600">
                                <h1>
                                    {{ $damage->hotel_item->name }}
                                </h1>
                                <span>|</span>
                                <h1>
                                    ₱ {{ $damage->amount }}
                                    {{ $damage->additional_amount ? ' + ₱ ' . $damage->additional_amount : '' }}
                                </h1>
                            </div>
                        </div>
                    </div>
                @empty
                    <div wire:key="empty"
                        class="bg-white rounded-lg border p-2 mb-2">
                        <div class="w-full flex justify-between">
                            <div class="flex space-x-2 items-center text-gray-600">
                                <h1>
                                    No records found
                                </h1>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
