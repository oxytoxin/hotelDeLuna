<div x-cloak
    x-show="currentTab == 2">
    <x-card>
        <x-slot:title>
            Transfer Room
        </x-slot:title>
        <form class="gap-4 sm:grid sm:grid-cols-2">
            @csrf
            <x-native-select label="Select Type">
                <option value=""
                    disabled>Select</option>
            </x-native-select>
            <x-native-select label="Select Floor">
                <option value="">Select</option>
            </x-native-select>
            <div id="expandable"
                class="grid col-span-2 gap-3"
                x-animate>
                <div class="col-span-1">
                    <x-input wire:model="changeRoom.amount"
                        prefix="₱"
                        disabled
                        label="Amount" />
                </div>
                <div class="col-span-1">
                    <x-native-select wire:model="changeRoom.to_room_id"
                        label="Select Room">
                        <option value="">Select</option>
                        {{-- @foreach ($available_rooms as $room)
                                <option value="{{ $room->id }}">
                                    Room # {{ $room->number }}
                                </option>
                            @endforeach --}}
                    </x-native-select>
                </div>
                <div wire:key="reason_input"
                    class="sm:col-span-2">
                    <x-textarea wire:model="changeRoom.reason"
                        label="Reason"
                        placeholder="Reason for changing room" />
                </div>
                <x-checkbox id="right-label"
                    label="Paid" />
                <div class="py-2 mt-2 border-t sm:col-span-2">
                    <x-native-select label="Mark the previous room as :">
                        <option value="">Select</option>
                    </x-native-select>
                </div>
                <div class="py-2 mt-2 border-t sm:col-span-2">
                    <x-input label="AUTHORIZATION CODE"
                        type="password"
                        class="border-red-400" />
                </div>
            </div>
        </form>
        <x-slot:footer>
            <div class="flex justify-end space-x-3">
                <x-button negative>
                    Cancel
                </x-button>
                <x-button positive>
                    Save
                </x-button>
            </div>
        </x-slot:footer>
    </x-card>
</div>
