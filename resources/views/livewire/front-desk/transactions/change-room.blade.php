<div class="gap-4 sm:grid sm:grid-cols-2"
    x-data
    x-intersect.once="$wire.visible">
    @if ($tabIsVisible)
        @if (count($changes_history) < 2)
            <div id="form"
                class="sm:col-span-2">
                <x-card title="Transfer">
                    <div class="w-full">
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
                                        <x-native-select wire:model.defer="form.room_id"
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
                                        <x-textarea wire:model.defer="form.reason"
                                            label="Reason"
                                            placeholder="Reason for changing room" />
                                    </div>
                                    <x-checkbox id="right-label"
                                        label="Paid"
                                        wire:model.defer="form.paid" />
                                    <div class="py-2 mt-2 border-t sm:col-span-2">
                                        <x-native-select wire:model.defer="form.room_status_id"
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
        @endif
        <div class="sm:col-span-2">
            <x-card title="Transfer History">
                <div>
                    <div class="flex flex-col">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-primary-600">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-white uppercase sm:pl-6">
                                                    Details
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                    Amount
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                    Pait At
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                    Date Time
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($changes_history as $transaction)
                                                <tr>
                                                    <td
                                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                        {{ $transaction->remarks }}
                                                    </td>
                                                    <td
                                                        class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        ₱ {{ $transaction->payable_amount }}
                                                    </td>
                                                    <td
                                                        class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        @if ($transaction->paid_at)
                                                            {{ Carbon\Carbon::parse($transaction->paid_at)->format('Y/m/d h:i:s A') }}
                                                        @else
                                                            <button type="button"
                                                                wire:click="payTransaction({{ $transaction->id }})"
                                                                class="text-green-600 hover:text-green-900">
                                                                <span> Pay </span>
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td
                                                        class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        {{ $transaction->created_at->format('Y/m/d h:i:s A') }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3"
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
        </div>
    @endif
</div>
