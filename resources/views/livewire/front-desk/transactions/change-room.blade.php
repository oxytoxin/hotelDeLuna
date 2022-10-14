<div class="gap-4 sm:grid sm:grid-cols-2">
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
                                <x-input wire:model="new_amount_to_pay"
                                    prefix="₱"
                                    disabled
                                    label="Amount" />
                            </div>
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
                            <div class="py-2 mt-2 border-t sm:col-span-2 ">
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
                    <x-button wire:click="clear_form">Clear Form</x-button>
                    <x-button wire:click="saveChanges"
                        spinner="saveChanges"
                        primary>Save</x-button>
                </div>
            </x-slot:footer>
        </x-card>
    </div>
    <div class="sm:col-span-2">
        <x-card title="Transfer History">
            <div>
                <div class="flex flex-col ">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">
                                                From
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                                To</th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                                Amount
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                                Date Time
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($changes_history as $room_change)
                                            <tr>
                                                <td
                                                    class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                    ROOM # {{ $room_change->fromRoom->number }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    ROOM # {{ $room_change->toRoom->number }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    ₱ {{ $room_change->amount }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ $room_change->created_at->format('Y/m/d h:i:s A') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                    No record found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </x-card>
        {{-- <div class="grid gap-1">
            <div class="flex items-center justify-between">
                <h1 class="text-center text-gray-600">
                    Room transfer history
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
                        <div class="flex justify-between w-full text-sm">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <h1>
                                    Transfered from ROOM # {{ $room_change->fromRoom->number }} to ROOM #
                                    {{ $room_change->toRoom->number }}
                                </h1>
                            </div>
                            <div>
                                <h1 class="text-gray-600 ">
                                    ₱ {{ $room_change->amount }}
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

        </div> --}}
    </div>
</div>
