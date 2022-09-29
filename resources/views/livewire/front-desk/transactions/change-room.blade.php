<div>
    <x-card shadow="shadow"
        title="Change Room"
        cardClasses="border-gray-300 border">
        <div class="w-full">
            <form class="sm:grid sm:grid-cols-2 gap-4">
                @csrf
                <x-native-select wire:model="form.type_id"
                    label="Select Type">
                    <option value="">All</option>
                    @foreach ($types_within_this_branch as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->name }}
                        </option>
                    @endforeach
                </x-native-select>
                <x-native-select wire:model="form.floor_id"
                    label="Select Floor">
                    <option value="">All</option>
                    @foreach ($floors_within_this_branch as $floor)
                        <option value="{{ $floor->id }}">
                            {{ ordinal($floor->number) }} Floor
                        </option>
                    @endforeach
                </x-native-select>
                <div class="sm:col-span-2">
                    <x-native-select wire:model="form.room_id"
                        label="Select Room">
                        <option value="">Select</option>
                        @foreach ($rooms_within_this_branch as $room)
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
            </form>
        </div>
        <x-slot:footer>
            <div class="flex space-x-3 items-center">
                <x-button>Cancel</x-button>
                <x-button wire:click="saveChanges"
                    spinner="saveChanges"
                    primary>Save</x-button>
            </div>
        </x-slot:footer>
    </x-card>
</div>
