<div>
    <div class="">
        <div class="border-b border-gray-200 bg-white ">
            <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                <div class="ml-4 mt-4">
                    <h3 class="text-xl font-bold leading-6 text-gray-700">BRANCH ROOMS</h3>
                    <p class="mt-1 text-sm text-gray-500">A list of all rooms in
                        </p>
                </div>
                <div class="ml-4 mt-4 flex-shrink-0">
                    <div class="flex justify-between space-x-1 items-center">
                        <div class="flex border items-center px-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                class="fill-gray-500" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z" />
                            </svg>
                            <input type="text" wire:model="search_user"
                                placeholder="Search room..."
                                class="border-0 focus:outline focus:ring-0">
                        </div>
                        <x-button class="" wire:click="$set('floor_modal',true)" default md
                            label="Manage Floor" />
                        <x-button wire:click="$set('create_modal', true)" class="font-semibold"
                            positive md label="+" />
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300 border-b">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-700 sm:pl-6 md:pl-0">
                                    ROOM NUMBER</th>
                                <th scope="col"
                                    class="py-3.5 px-3 text-left text-sm font-semibold text-gray-700">
                                    FLOOR</th>
                                <th scope="col"
                                    class="py-3.5 px-3 text-left text-sm font-semibold text-gray-700">
                                    STATUS</th>
                                <th scope="col"
                                    class="py-3.5 px-3 text-left text-sm font-semibold text-gray-700">
                                    TYPES</th>
                                <th scope="col"
                                    class="relative py-3.5 pl-3 pr-4 sm:pr-6 md:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 border-b-2 ">
                            @forelse ($rooms as $room)
                                <tr>
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-700 sm:pl-6 md:pl-0">
                                        ROOM #{{ $room->number }}</td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-700">
                                        {{ ordinal($room->floor->number) }} FLOOR</td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-700">
                                        {{ $room->room_status->name }}</td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-700">
                                        {{ $room->type->name }}</td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                                        <x-button wire:click="editRoom({{$room->id}})" class="font-semibold"
                                            positive sm label="Edit" />
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-2">
                       {{ $rooms->links() }}
                    </div>
                </div>

            </div>

        </div>

    </div>
     <div wire:key="floor_modal" class="z-0">
            <x-modal.card max-width="md" title="Floor Management" blur wire:model.defer="floor_modal">
                <x-input wire:model="floor_number" label="Floor Number" />
                <div>
                    <div class="mt-6 flow-root">
                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                            @forelse ($floors as $floor)
                                <li class="py-2">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                class="h-5 w-6 fill-gray-700">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M21 20h2v2H1v-2h2V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v17zM8 11v2h3v-2H8zm0-4v2h3V7H8zm0 8v2h3v-2H8zm5 0v2h3v-2h-3zm0-4v2h3v-2h-3zm0-4v2h3V7h-3z" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-semibold text-gray-700">
                                                {{ ordinal($floor->number) }} FLOOR</p>

                                        </div>

                                    </div>
                                </li>
                            @empty
                            @endforelse

                        </ul>
                    </div>
                    <div class="mt-2">
                        {{-- {{ $floors->links() }} --}}
                    </div>
                </div>
                <x-slot:footer>
                    <x-button positive wire:click="saveFloor">Save</x-button>
                </x-slot:footer>
            </x-modal.card>
        </div>
     <div wire:key="create_modal" class="z-0">
            <x-modal.card  title="Add New Room " blur wire:model.defer="create_modal">
               <div class="grid grid-cols-3 gap-4">
                <x-input wire:model="floor_number" label="Number" placeholder="Number"/>
                <x-native-select label="Select Floor"  wire:model="floor_id">
                    <option value="" selected
                    disabled>Select Floor</option>
                    @foreach ($floors as $floor)
                        <option value="{{ $floor->id }}">{{ ordinal($floor->number) }} FLOOR </option>
                    @endforeach
                </x-native-select>
                <x-native-select label="Select Room Status"
                wire:model.defer="room_status">
                <option value=""
                    disabled>Select Room Status</option>
                @foreach ($room_statuses as $key => $roomStatus)
                    <option value="{{ $roomStatus->id }}">{{ $roomStatus->name }}</option>
                @endforeach
            </x-native-select>
               </div>
               <div class="mt-2">
                <x-textarea label="Description" wire:model.defer="description"  placeholder="Leave it blank if none" />
               </div>
               <div class="mt-2">
                <x-native-select label="Select Room Type" wire:model.defer="type_id"  >
                    <option value="" selected
                    disabled>Select Room Type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name}}</option>
                    @endforeach
                </x-native-select>
               </div>
                <x-slot:footer>
                    <div class="flex w-full justify-end items-center space-x-2">
                        <x-button positive wire:click="saveRoom">Save</x-button>
                        <x-button wire:click="$set('create_modal', false)" default>Cancel</x-button>
                    </div>
                </x-slot:footer>
            </x-modal.card>
        </div>
     <div wire:key="edit_modal" class="z-0">
            <x-modal.card  title="Update Room " blur wire:model.defer="edit_modal">
               <div class="grid grid-cols-3 gap-4">
                <x-input wire:model="floor_number" label="Number" placeholder="Number"/>
                <x-native-select label="Select Floor"  wire:model="floor_id">
                    <option value="" selected
                    disabled>Select Floor</option>
                    @foreach ($floors as $floor)
                        <option value="{{ $floor->id }}">{{ ordinal($floor->number) }} FLOOR </option>
                    @endforeach
                </x-native-select>
                <x-native-select label="Select Room Status"
                wire:model.defer="room_status">
                <option value=""
                    disabled>Select Room Status</option>
                @foreach ($room_statuses as $key => $roomStatus)
                    <option value="{{ $roomStatus->id }}">{{ $roomStatus->name }}</option>
                @endforeach
            </x-native-select>
               </div>
               <div class="mt-2">
                <x-textarea label="Description" wire:model.defer="description"  placeholder="Leave it blank if none" />
               </div>
               <div class="mt-2">
                <x-native-select label="Select Room Type" wire:model.defer="type_id"  >
                    <option value="" selected
                    disabled>Select Room Type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name}}</option>
                    @endforeach
                </x-native-select>
               </div>
                <x-slot:footer>
                    <div class="flex w-full justify-end items-center space-x-2">
                        <x-button positive wire:click="updateRoom">Update</x-button>
                        <x-button wire:click="$set('create_modal', false)" default>Cancel</x-button>
                    </div>
                </x-slot:footer>
            </x-modal.card>
        </div>
</div>
