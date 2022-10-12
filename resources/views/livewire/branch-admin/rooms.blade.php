<div>
    <div>
        <x-table :headers="['Room Number', 'Floor', 'Status', 'Types', 'Priority', '']">
            <x-slot:topLeft>
                <x-input placeholder="Search"
                    wire:model.debounce.500ms="search"
                    icon="search" />
                <x-native-select wire:model.debounce="filter.floor">
                    <option value="all">Floor (All)</option>
                    @foreach ($floors as $key => $floor)
                        <option value="{{ $floor->id }}">{{ ordinal($floor->number) }}</option>
                    @endforeach
                </x-native-select>
                <x-native-select wire:model.debounce="filter.room_status">
                    <option value="all">Status (All)</option>
                    @foreach ($roomStatuses as $key => $roomStatuse)
                        <option value="{{ $roomStatuse->id }}">{{ $roomStatuse->name }}</option>
                    @endforeach
                </x-native-select>
            </x-slot:topLeft>
            <x-slot:topRight>
                <div class="flex items-center space-x-3">
                    <x-button wire:click="$set('manageFloorModal',true)"
                        label="Manage Floor" />
                    <x-button primary
                        wire:click="add"
                        label="Add Room" />
                </div>
            </x-slot:topRight>
            @forelse ($rooms as $room)
                <x-table-row>
                    <x-table-data>
                        ROOM # {{ $room->number }}
                    </x-table-data>
                    <x-table-data>
                        {{ ordinal($room->floor->number) }} Floor
                    </x-table-data>
                    <x-table-data>
                        {{ $room->room_status->name }}
                    </x-table-data>
                    <x-table-data>
                        {{ $room->type->name }}
                    </x-table-data>
                    <x-table-data>
                        @if ($room->priority)
                            <button class="flex items-center space-x-2 text-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="w-6 h-6 ">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h1 class="text-xs">
                                    Set as non-priority
                                </h1>
                            </button>
                        @else
                            <button class="flex items-center space-x-2 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h1 class="text-xs">
                                    Set as priority
                                </h1>
                            </button>
                        @endif
                    </x-table-data>
                    <x-table-data>
                        <div class="flex justify-end px-2">
                            <x-actions.edit wire:key="{{ $room->id }}"
                                wire:click="edit({{ $room->id }})"
                                wire:loading.class="cursor-progress"
                                wire:loading.attr="disabled"
                                wire:target="edit({{ $room->id }})" />
                        </div>
                    </x-table-data>
                </x-table-row>
            @empty
                <x-table-empty rows="5" />
            @endforelse
            <x-slot:pagination>
                {{ $rooms->links() }}
            </x-slot:pagination>
        </x-table>
    </div>
    <div wire:key="modal-panel">
        <x-modal.card title="{{ $this->getModeTitle() }}"
            wire:model.defer="showModal">
            <form>
                @csrf
                <div class="gap-3 sm:grid sm:grid-cols-3">
                    <x-input label="Number"
                        wire:model.defer="number"
                        type="number"
                        placeholder="Number" />
                    <x-native-select label="Select Floor"
                        wire:model.defer="floor_id">
                        <option value=""
                            disabled>Select Floor</option>
                        @foreach ($floors as $key => $floor)
                            <option value="{{ $floor->id }}">{{ $floor->number }}</option>
                        @endforeach
                    </x-native-select>
                    <x-native-select label="Select Room Status"
                        wire:model.defer="room_status_id">
                        <option value=""
                            disabled>Select Room Status</option>
                        @foreach ($roomStatuses as $key => $roomStatus)
                            <option value="{{ $roomStatus->id }}">{{ $roomStatus->name }}</option>
                        @endforeach
                    </x-native-select>
                    <div class="sm:col-span-3">
                        <x-textarea wire:model.defer="description"
                            label="Description"
                            placeholder="Leave it blank if none">
                        </x-textarea>
                    </div>
                    <div class="sm:col-span-3">
                        <x-native-select label="Select Room Type"
                            wire:model.defer="type_id">
                            <option value=""
                                disabled>Select Room Type</option>
                            @foreach ($roomTypes as $key => $roomType)
                                <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                            @endforeach
                        </x-native-select>
                    </div>
                </div>
            </form>
            <x-slot:footer>
                <div wire:key="action-buttons">
                    @switch($mode)
                        @case('create')
                            <x-button wire:click="create"
                                spinner="create"
                                positive
                                label="Save" />
                        @break

                        @case('edit')
                            <x-button wire:click="update"
                                spinner="update"
                                info
                                label="Update" />
                        @break

                        @default
                    @endswitch
                </div>
            </x-slot:footer>
        </x-modal.card>
        <x-modal.card title="Manage Floor"
            wire:model.defer="manageFloorModal">
            <form>
                @csrf
                <div>
                    <x-input label="Number"
                        wire:model.defer="floor_number"
                        type="number"
                        placeholder="Number" />
                </div>
            </form>
            <div class="grid mt-5 space-y-2">
                @foreach ($floors as $floors)
                    <div class="flex justify-between p-2 duration-150 ease-in-out border rounded-lg hover:bg-gray-100">
                        <div>
                            {{ ordinal($floors->number) }} Floor
                        </div>
                        <div>

                        </div>
                    </div>
                @endforeach
            </div>
            <x-slot:footer>
                <x-button primary
                    wire:click="saveFloor"
                    spinner="saveFloor"
                    label="Save" />
            </x-slot:footer>
        </x-modal.card>
    </div>
</div>
