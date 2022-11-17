<div x-data
    class="grid space-y-4">
    {{-- bulk actions --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="mt-1 flex space-x-2 sm:flex-none">
            <x-my.button-primary label="Add New"
                wire:click="create">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </x-slot>
            </x-my.button-primary>
        </div>
        <div class="flex space-x-3">
            <div class="flex items-center space-x-2">
                <span class="mt-2 text-sm text-gray-600">
                    Status :
                </span>
                <x-my.input.select placeholder="Select"
                    wire:model="filters.room_status_id">
                    @foreach ($roomStatuses as $roomStatus)
                        <option value="{{ $roomStatus->id }}">
                            {{ $roomStatus->name }}
                        </option>
                    @endforeach
                </x-my.input.select>
            </div>
            <div class="flex items-center space-x-2">
                <span class="mt-2 text-sm text-gray-600">
                    Floors :
                </span>
                <x-my.input.select placeholder="Select"
                    wire:model="filters.floor_id">
                    @foreach ($floors as $floor)
                        <option value="{{ $floor->id }}">
                            {{ ordinal($floor->number) }} FLOOR
                        </option>
                    @endforeach
                </x-my.input.select>
            </div>
            <div class="mt-1"
                x-animate>
                @if ($this->hasFilters())
                    <x-my.button-secondary label="Clear Filter"
                        py="py-1.5"
                        wire:click="clearFilter">
                        <x-slot name="icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-6 w-6">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </x-slot>
                    </x-my.button-secondary>
                @endif
            </div>
            <div class="border-l pl-2">
                <x-my.input.search wire:model.debounce="search" />
            </div>
        </div>
    </div>
    {{-- table --}}
    <x-my.table>
        <x-slot name="header">
            <x-my.table.head name="Number" />
            <x-my.table.head name="Type" />
            <x-my.table.head name="Status" />
            <x-my.table.head name="Floor" />
            <x-my.table.head name="" />
        </x-slot>
        @forelse ($rooms as $room)
            <tr>
                <x-my.table.cell>
                    ROOM #{{ $room->number }}
                </x-my.table.cell>
                <x-my.table.cell>
                    {{ $room->type->name }}
                </x-my.table.cell>
                <x-my.table.cell>
                    <x-status-badge status="{{ $room->room_status_id }}">
                        {{ $room->room_status->name }}
                    </x-status-badge>
                </x-my.table.cell>
                <x-my.table.cell>
                    {{ ordinal($room->floor->number) }} Floor
                </x-my.table.cell>
                <x-my.table.cell>
                    <div class="flex justify-end px-2">
                        <x-my.edit-button wire:click="edit({{ $room->id }})" />
                    </div>
                </x-my.table.cell>
            </tr>
        @empty
            <x-my.table.empty span="4" />
        @endforelse
        <x-slot name="footer">
            {{ $rooms->links() }}
        </x-slot>
    </x-my.table>

    {{-- modals --}}

    <div>
        <form wire:submit.prevent="save">
            @csrf
            <x-my.modal title="{{ $editMode ? 'Edit Room' : 'Create Room' }}"
                :showOn="['show-modal']"
                :closeOn="['close-modal']">
                <div class="grid space-y-4">
                    <x-my.input label="Room Number"
                        wire:model="form.number"
                        numberOnly
                        type="number"
                        required />
                    <x-my.input.select label="Type"
                        placeholder="Select Type"
                        required
                        wire:model.defer="form.type_id">
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </x-my.input.select>
                    <x-my.input.select label="Floor"
                        placeholder="Select Floor"
                        required
                        wire:model.defer="form.floor_id">
                        @foreach ($floors as $floor)
                            <option value="{{ $floor->id }}">
                                {{ ordinal($floor->number) }} Floor
                            </option>
                        @endforeach
                    </x-my.input.select>
                    <x-my.input.select label="Status"
                        placeholder="Select Room Status"
                        required
                        wire:model.defer="form.room_status_id">
                        @foreach ($roomStatuses as $roomStatus)
                            @if ($roomStatus->id != 6)
                                <option value="{{ $roomStatus->id }}">
                                    {{ $roomStatus->name }}
                                </option>
                            @endif
                        @endforeach
                    </x-my.input.select>
                    <x-my.input.textarea label="Description"
                        placeholder="Leave blank if none"
                        wire:model.defer="form.description">
                    </x-my.input.textarea>
                </div>
                <x-slot name="footer">
                    <div class="flex items-center space-x-3">
                        <x-my.button-secondary x-on:click="close"
                            label="Cancel" />
                        <x-my.button-success type="submit"
                            loadingOn="save"
                            label="Save" />
                    </div>
                </x-slot>
            </x-my.modal>
        </form>
    </div>
</div>
