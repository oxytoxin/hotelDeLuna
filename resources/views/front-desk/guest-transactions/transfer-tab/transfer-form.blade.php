<div class="sm:col-span-2">
    <x-card title="Transfer">
        <div class="w-full">
            <div class="p-2 mb-2 text-sm border rounded-lg bg-gray-50">
                <h1>
                    Current Room: <span class="font-bold"> Room #{{ $current_room->number }}</span>
                </h1>
                <h1>
                    Type: <span class="font-bold">{{ $current_room->type->name }}</span>
                </h1>
                <h1>
                    Status: <span class="font-bold">{{ $current_room->room_status->name }}</span>
                </h1>
            </div>
            <form class="gap-4 sm:grid sm:grid-cols-2">
                @csrf
                <x-native-select wire:model="form.type_id"
                    label="Select Type">
                    <option value=""
                        disabled>Select</option>
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
                        <div class="col-span-1">
                            <x-input wire:model="new_amount_to_pay"
                                prefix="₱"
                                disabled
                                label="Amount" />
                        </div>
                        <div class="col-span-1">
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
                        <div class="py-2 mt-2 border-t sm:col-span-2">
                            <x-native-select wire:model="form.room_status_id"
                                label="Mark the previous room as :">
                                <option value="">Select</option>
                                @foreach ($room_statuses as $room_status)
                                    <option value="{{ $room_status->id }}">
                                        {{ $room_status->name }}
                                    </option>
                                @endforeach
                            </x-native-select>
                        </div>
                        <div class="py-2 mt-2 border-t sm:col-span-2">
                            <x-input label="AUTHORIZATION CODE"
                                type="password"
                                class="border-red-400"
                                wire:model.defer="authorization_code" />
                        </div>
                    @endif
                </div>
            </form>
        </div>
        <x-slot:footer>
            <div class="flex items-center space-x-3">
                <x-button negative
                    wire:click="clear_form">Clear Form</x-button>
                <x-button wire:click="saveChanges"
                    spinner="saveChanges"
                    emerald>Save</x-button>
            </div>
        </x-slot:footer>
    </x-card>
</div>
