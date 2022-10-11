<div class="gap-4 sm:grid sm:grid-cols-2">
    <div class="sm:col-span-1">
        <x-card shadow="shadow"
            title="Transfer"
            cardClasses="border-gray-300 border">
            <div class="w-full">
                <form class="gap-4 sm:grid sm:grid-cols-2">
                    @csrf
                    <x-native-select wire:model="form.type_id"
                        label="Select Type">
                        <option value="">Select</option>
                        @foreach ($available_types as $type)
                            <option value="{{ $type->id }}">
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </x-native-select>
                    <x-native-select wire:model="form.floor_id"
                        label="Select Floor">
                        <option value="">Select</option>
                        @foreach ($floors as $floor)
                            <option value="{{ $floor->id }}">
                                {{ ordinal($floor->number) }} Floor
                            </option>
                        @endforeach
                    </x-native-select>
                    <div id="expandable"
                        class="grid col-span-2 gap-3"
                        x-animate>
                        @if (count($available_rooms) > 0)
                            <div class="sm:col-span-2">
                                <x-native-select wire:model="form.room_id"
                                    label="Select Room">
                                    <option value="">Select</option>
                                    @foreach ($available_rooms as $room)
                                        <option value="{{ $room->id }}">
                                            Room # {{ $room->number }}
                                        </option>
                                    @endforeach
                                </x-native-select>
                            </div>
                            <div wire:key="reason_input"
                                class="sm:col-span-2">
                                <x-textarea wire:model="form.reason"
                                    label="Reason"
                                    placeholder="Reason for changing room" />
                            </div>
                            <x-checkbox id="right-label"
                                label="Paid"
                                wire:model.defer="form.paid" />
                            <div class="mt-2 border-t sm:col-span-2">
                                <x-input label="AUTHORIZATION CODE"
                                    class="border-red-400"
                                    wire:model.defer="authorization_code" />
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            <x-slot:footer>
                <div class="flex items-center space-x-3">
                    <x-button wire:click="clear_form">Clear Form</x-button>
                    <x-button wire:click="saveChanges"
                        spinner="saveChanges"
                        primary>Save</x-button>
                </div>
            </x-slot:footer>
        </x-card>
    </div>
    <div class="sm:col-span-1">
        <div class="grid gap-1">
            <div class="flex items-center justify-between">
                <h1 class="text-center text-gray-600">
                    Room Change History
                </h1>
                <div wire:key="{{ $historyOrder }}">
                    <button wire:click="historyOrderToggle"
                        type="button"
                        class="flex items-center space-x-2 text-gray-600">
                        <span>{{ $historyOrder == 'ASC' ? 'Oldest' : 'Newest' }}</span>
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
                @forelse ($changes_history as $room_change)
                    <div wire:key="{{ $room_change->id }}"
                        class="p-2 mb-2 bg-white border rounded-lg">
                        <div class="flex justify-between w-full">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <h1>
                                    From Room #{{ $room_change->fromRoom->number }}
                                </h1>
                                <h1>
                                    -
                                </h1>
                                <h1>
                                    To Room # {{ $room_change->toRoom->number }}
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
