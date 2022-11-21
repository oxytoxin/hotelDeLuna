<div x-data="{ formOpen: false }"
    x-on:close-form.window="formOpen=false">
    <div class="px-4 pt-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-center">
            <div class="sm:flex-auto">
                <h1 class="text-lg font-semibold text-gray-900">
                    Transfer Room
                </h1>
            </div>
            <div>
                <x-my.button-primary py="py-1"
                    x-on:click="formOpen = !formOpen"
                    label="Transfer Room" />
            </div>
        </div>
        <div x-cloak
            x-show="formOpen"
            x-collapse>
            @if (count($transactions) == 2)
                <div class="p-4 mt-3 border border-yellow-400 rounded-md bg-yellow-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Heroicon name: mini/exclamation-triangle -->
                            <svg class="w-5 h-5 text-yellow-400"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8.485 3.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 3.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Transfering Room is disabled
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>
                                    Guest can only transfer room 2 times.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div x-data="{ hasAvailableRoom: $wire.entangle('hasAvailableRoom') }"
                    class="p-4 mt-5 bg-gray-100 rounded-lg">
                    <div class="grid grid-cols-2 gap-3">
                        <x-my.input.select label="Select Type"
                            required
                            wire:model="newRoomTypeId"
                            placeholder="Select">
                            @foreach ($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}">
                                    {{ $roomType->name }}
                                </option>
                            @endforeach
                        </x-my.input.select>
                        <x-my.input.select required
                            label="Select Floor"
                            wire:model="newRoomFloorId"
                            placeholder="Select">
                            @foreach ($floors as $floor)
                                <option value="{{ $floor->id }}">
                                    {{ ordinal($floor->number) }} Floor
                                </option>
                            @endforeach
                        </x-my.input.select>
                        <div x-cloak
                            x-show="hasAvailableRoom"
                            x-collapse
                            class="grid grid-cols-2 col-span-2 gap-3">
                            <x-my.input.select required
                                label="Select Room"
                                wire:model="newRoomId"
                                placeholder="Select">
                                @foreach ($availableRooms as $room)
                                    <option value="{{ $room->id }}">
                                        Room # {{ $room->number }}
                                    </option>
                                @endforeach
                            </x-my.input.select>
                            <x-my.input.select required
                                wire:model.defer="oldRoomStatus"
                                label="Select Old Room Status"
                                placeholder="Select">
                                @foreach ($roomStatuses as $status)
                                    <option value="{{ $status['id'] }}">
                                        {{ $status['name'] }}
                                    </option>
                                @endforeach
                            </x-my.input.select>
                            <x-my.input.textarea required
                                wire:model.defer="reason"
                                label="Reason"></x-my.input.textarea>
                            <div class="col-span-2">
                                <x-my.input placeholder="Enter authorization code"
                                    wire:model.defer="authorizationCode"
                                    label="Authorization Code"
                                    type="password"
                                    required />
                            </div>
                            <div class="col-span-2 py-3">
                                <dl class="pt-6 space-y-6 text-sm font-medium text-gray-500 border-t border-gray-200">
                                    <div class="flex justify-between">
                                        <dt>Previous Room Amount</dt>
                                        <dd class="text-gray-900">
                                            ₱ {{ $oldRoomAmount }}
                                        </dd>
                                    </div>

                                    <div class="flex justify-between">
                                        <dt>
                                            New Room Amount
                                        </dt>
                                        <dd class="text-gray-900">
                                            ₱ {{ $newRoomAmount ?? 'N/A' }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt>Excess Amount</dt>
                                        <dd class="text-gray-900">
                                            ₱
                                            @if ($newRoomAmount < $oldRoomAmount && $newRoomAmount != null)
                                                {{ $oldRoomAmount - $newRoomAmount }}
                                            @else
                                                0
                                            @endif
                                        </dd>
                                    </div>
                                    <div x-animate>
                                        @if ($newRoomAmount < $oldRoomAmount && $newRoomAmount != null)
                                            <x-my.input.select required
                                                label="Save excess amount as deposit?"
                                                wire:model.defer="saveAsDeposit">
                                                <option value="0">
                                                    No
                                                </option>
                                                <option value="1">
                                                    Yes
                                                </option>
                                            </x-my.input.select>
                                        @endif
                                    </div>
                                    <div
                                        class="flex items-center justify-between pt-6 text-gray-900 border-t border-gray-200">
                                        <dt class="text-base">Total Payable Amount</dt>
                                        <dd class="text-base">
                                            ₱
                                            @if ($newRoomAmount > $oldRoomAmount && $newRoomAmount != null)
                                                {{ $newRoomAmount - $oldRoomAmount }}
                                            @else
                                                0
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        <div x-cloak
                            x-show="hasAvailableRoom==false"
                            x-collapse
                            class="grid grid-cols-1 col-span-2 gap-3">
                            <div class="p-4 border border-red-400 rounded-md bg-red-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <!-- Heroicon name: mini/x-circle -->
                                        <svg class="w-5 h-5 text-red-400"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">
                                            No Available Room
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="flex items-center space-x-3">
                            <x-my.button-secondary label="Return" />
                            <x-my.button-success
                                x-on:click=" hasAvailableRoom ? $dispatch('confirm',{
                        title : 'Are you sure?',
                        message : 'Are you sure you want to proceed?',
                        confirmButtonText : 'Confirm',
                        cancelButtonText : 'Cancel',
                        confirmMethod : 'confirmSaveChanges',
                    }) : $dispatch('notify-alert',{
                       type : 'error',
                       title : 'Failed To Proceed',
                       message : 'Please select a room first.',
                       buttonText : 'Got it',
                   })"
                                label="Save Changes" />
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="flex flex-col mt-3">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6 lg:pl-8">
                                        Details
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                        Amount
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                        Transaction Date
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                        Paid at
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td class="py-3.5 pl-4 pr-3 text-xs text-gray-900 sm:pl-6 lg:pl-8">
                                            {{ $transaction->remarks }}
                                        </td>
                                        <td class="px-3 py-3.5 text-xs text-gray-900">
                                            {{ $transaction->payable_amount }}
                                        </td>

                                        <td class="px-3 py-3.5 text-xs text-gray-900">
                                            {{ $transaction->created_at->format('M d, Y h:i A') }}
                                        </td>
                                        <td class="px-3 py-3.5 text-right text-xs font-medium">
                                            <div class="flex space-x-3">
                                                @if ($transaction->paid_at == null)
                                                    <x-my.button-success label="Pay"
                                                        x-on:click="$dispatch('confirm',{
                                                            title : 'Are you sure?',
                                                            message : 'Are you sure you want to proceed?',
                                                            confirmButtonText : 'Confirm',
                                                            cancelButtonText : 'Cancel',
                                                            confirmMethod : 'payTransaction',
                                                            confirmParams :{{ $transaction->id }},
                                                    })"
                                                        py="py-1" />
                                                    {{-- <x-my.button-warning label="Pay With Deposit"
                                                        wire:click="payWithDeposit({{ $transaction->id }}, {{ $transaction->payable_amount }})"
                                                        py="py-1" /> --}}
                                                @else
                                                    {{ Carbon\Carbon::parse($transaction->paid_at)->format('M d, Y h:i A') }}
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="py-3.5 pl-4 pr-3 text-center text-xs text-gray-900 sm:pl-6 lg:pl-8">
                                            No data available
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
</div>
