<div>
    <x-table :headers="['Name', 'Status', 'Cleaning', 'Floor Designation', '']">
        <x-slot:topLeft>
            <x-input placeholder="Search"
                wire:model.debounce.500ms="search"
                icon="search" />
            <x-native-select wire:model="filter.floor_id">
                <option value="">Select Floor (ALL)</option>
                @foreach ($floors_filter as $item)
                    <option value="{{ $item->id }}">
                        {{ ordinal($item->number) }} Floor
                    </option>
                @endforeach
            </x-native-select>
        </x-slot:topLeft>
        <x-slot:topRight>

        </x-slot:topRight>
        @forelse ($roomBoys as $roomBoy)
            <x-table-row>
                <x-table-data>
                    {{ $roomBoy->user->name }}
                </x-table-data>
                <x-table-data>
                    @if ($roomBoy->is_cleaning)
                        <span
                            class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                            Cleaning
                        </span>
                    @else
                        <span
                            class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                            Not Cleaning
                        </span>
                    @endif
                </x-table-data>
                <x-table-data>
                    @if ($roomBoy->is_cleaning)
                        Currently Cleaning in Room # {{ $roomBoy->room->number }}
                    @else
                        <span
                            class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                            Not Cleaning
                        </span>
                    @endif
                </x-table-data>

                <x-table-data>
                    @forelse ($roomBoy->designations as $designation)
                        {{ ordinal($designation->floor->number) }} Floor
                    @empty
                        No Designation
                    @endforelse
                </x-table-data>
                <x-table-data>
                    <div class="flex justify-end">
                        <x-button sm
                            wire:click="manageDesignation({{ $roomBoy->id }})"
                            label="Manage Designation" />
                    </div>
                </x-table-data>
            </x-table-row>
        @empty
            <x-table-empty rows="4" />
        @endforelse
        <x-slot:pagination>
            {{ $roomBoys->links() }}
        </x-slot:pagination>
    </x-table>

    <div id="modals">
        <form>
            @csrf
            <x-modal.card wire:model.defer="manageDesignationModal">
                <x-slot:title>
                    Assign to floor
                </x-slot:title>
                <div>
                    <x-native-select wire:model.defer="designation.floor_id"
                        value=""
                        label="Select Floor">
                        <option value="">Select Floor</option>
                        @foreach ($floors as $floor)
                            <option value="{{ $floor->id }}">
                                {{ ordinal($floor->number) }} Floor
                            </option>
                        @endforeach
                    </x-native-select>
                </div>
                <x-slot:footer>
                    <div class="flex justify-end space-x-3">
                        <x-button x-on:click="close"
                            label="Cancel" />
                        <x-button wire:click="save"
                            positive
                            label="Save" />
                    </div>
                </x-slot:footer>
            </x-modal.card>
        </form>
    </div>
</div>
