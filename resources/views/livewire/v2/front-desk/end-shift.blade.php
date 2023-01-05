<div x-data="{ show: $wire.entangle('show') }">
    <x-button x-on:click="show=true"
        primary>
        End Shift
    </x-button>
    <div>
        <div x-cloak
            x-show="show"
            class="relative z-10"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true">

            <div x-cloak
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex items-start justify-center min-h-full p-4 text-center sm:items-start sm:p-0">

                    <div x-cloak
                        x-show="show"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-[100rem] sm:p-6">
                        <div x-data="{
                            printDiv(divName) {
                                var printContents = document.getElementById(divName).innerHTML;
                                var originalContents = document.body.innerHTML;
                                document.body.innerHTML = printContents;
                                window.print();
                                document.body.innerHTML = originalContents;
                            }
                        }">
                            <div class="grid gap-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-xl font-semibold">
                                        Shift Report
                                    </div>
                                    <div class="flex space-x-3">

                                        <x-my.button-primary label="Print"
                                            x-on:click="printDiv('shiftReport')" />
                                    </div>
                                </div>
                                <div id="shiftReport">
                                    <div class="my-10 overflow-hidden bg-white border-2 border-gray-800">
                                        <div class="px-4 py-5 sm:px-6">
                                            <h3
                                                class="text-lg font-medium leading-6 text-center text-gray-900 uppercase">
                                                Daily Shift Report
                                            </h3>
                                        </div>
                                        @if (count($frontdesks) > 0)
                                            <div class="px-4 py-5 border-t border-gray-200 sm:p-0">
                                                <dl class="sm:divide-y sm:divide-gray-700">
                                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-3 sm:px-6">
                                                        <dt class="text-sm font-medium text-gray-900">
                                                            Date
                                                        </dt>
                                                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                                            {{ date('l F d Y') }}
                                                        </dd>
                                                    </div>
                                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-3 sm:px-6">
                                                        <dt class="text-sm font-medium text-gray-900">
                                                            Front Desk
                                                        </dt>
                                                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                                            {{ $frontdesks->pluck('name')->join(' and ') }}
                                                        </dd>
                                                    </div>
                                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-3 sm:px-6">
                                                        <dt class="text-sm font-medium text-gray-900">
                                                            Time Log In
                                                        </dt>
                                                        <dd
                                                            class="mt-1 text-sm text-gray-900 uppercase sm:col-span-2 sm:mt-0">
                                                            {{ date('h:i a', strtotime(auth()->user()->time_in)) }}
                                                        </dd>
                                                    </div>
                                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-3 sm:px-6">
                                                        <dt class="text-sm font-medium text-gray-900">
                                                            Time Log Out
                                                        </dt>
                                                        <dd
                                                            class="mt-1 text-sm text-gray-900 uppercase sm:col-span-2 sm:mt-0">
                                                            {{ date('h:i a') }}
                                                        </dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        @endif
                                        @if (count($frontdesks) > 0)
                                            <div class="my-6">
                                                <h1 class="font-semibold text-center uppercase texl-xl">
                                                    Summary
                                                </h1>
                                                <div id="table"
                                                    class="mt-3">
                                                    <div class="flex flex-col">
                                                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                            <div
                                                                class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                                                <div class="overflow-hidden shadow ring-1 ring-black">
                                                                    <table class="min-w-full divide-y divide-gray-300">
                                                                        <thead class="bg-gray-50">
                                                                            <tr>
                                                                                <th scope="col"
                                                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                                                    Floor</th>
                                                                                <th scope="col"
                                                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                    Room</th>
                                                                                <th scope="col"
                                                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                    Food</th>
                                                                                <th scope="col"
                                                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                    Drinks</th>
                                                                                <th scope="col"
                                                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                    Load</th>
                                                                                <th scope="col"
                                                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                    Internet</th>
                                                                                <th scope="col"
                                                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                    Excess Charges</th>
                                                                                <th scope="col"
                                                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                    Gross Total</th>
                                                                                <th scope="col"
                                                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                                    Total Deposit</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody
                                                                            class="bg-white divide-y divide-gray-200">
                                                                            @foreach ($floors as $floor)
                                                                                <tr>
                                                                                    <td
                                                                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 uppercase whitespace-nowrap sm:pl-6">
                                                                                        {{ ordinal($floor->number) }}
                                                                                        Floor
                                                                                    </td>
                                                                                    <td
                                                                                        class="px-3 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                                                        @php
                                                                                            $trans = $transactions[$floor->id] ?? 0;
                                                                                        @endphp
                                                                                        @if ($trans)
                                                                                            ₱
                                                                                            {{ $trans->where('transaction_type_id', 1)->sum('payable_amount') + $trans->where('transaction_type_id', 4)->sum('payable_amount') }}
                                                                                        @else
                                                                                            ₱ 00
                                                                                        @endif
                                                                                    </td>
                                                                                    <td
                                                                                        class="px-3 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                                                        ₱ 00</td>
                                                                                    <td
                                                                                        class="px-3 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                                                        ₱ 00</td>
                                                                                    <td
                                                                                        class="px-3 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                                                        ₱ 00
                                                                                    </td>
                                                                                    <td
                                                                                        class="px-3 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                                                        ₱ 00
                                                                                    </td>
                                                                                    <td
                                                                                        class="px-3 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                                                        ₱ 00
                                                                                    </td>
                                                                                    <td
                                                                                        class="px-3 py-4 text-sm text-white bg-black whitespace-nowrap">
                                                                                        @php
                                                                                            $trans = $transactions[$floor->id] ?? 0;
                                                                                        @endphp
                                                                                        @if ($trans)
                                                                                            ₱
                                                                                            {{ $trans->whereIn('transaction_type_id', [1, 3, 4, 6, 8, 9])->sum('payable_amount') }}
                                                                                        @else
                                                                                            ₱ 00
                                                                                        @endif
                                                                                    </td>
                                                                                    <td
                                                                                        class="px-3 py-4 text-sm text-white bg-black whitespace-nowrap">
                                                                                        @php
                                                                                            $trans = $transactions[$floor->id] ?? 0;
                                                                                        @endphp
                                                                                        @if ($trans)
                                                                                            ₱
                                                                                            {{ $trans->where('transaction_type_id', 2)->sum('payable_amount') }}
                                                                                        @else
                                                                                            ₱ 00
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <dl
                                                class="px-3 pb-6 text-sm font-medium text-gray-900 border-t border-gray-200">
                                                <div class="flex justify-between p-2 uppercase bg-orange-600">
                                                    <dt>Total New Guest</dt>
                                                    <dd class="text-gray-900">
                                                        {{ $new_guest_count }}
                                                    </dd>
                                                </div>

                                                <div class="flex justify-between p-2 uppercase bg-yellow-500">
                                                    <dt>Total Extended Guest</dt>
                                                    <dd class="text-gray-900">
                                                        {{ $total_extended_guest_count }}
                                                    </dd>
                                                </div>

                                                <div class="flex justify-between p-2 uppercase bg-green-500">
                                                    <dt>Total # of Slip Used</dt>
                                                    <dd class="text-gray-900">
                                                        0
                                                    </dd>
                                                </div>
                                                <div class="flex justify-between p-2 uppercase bg-pink-400">
                                                    <dt>Total # of Unoccupied Rooms</dt>
                                                    <dd class="text-gray-900"> {{ count($unoccupied_rooms) }}</dd>
                                                </div>
                                                <div
                                                    class="flex items-center justify-between pt-6 text-gray-900 border-t border-gray-200">
                                                    <div>

                                                    </div>
                                                    <dd class="text-base">
                                                        <div class="mb-2 text-right uppercase">
                                                            Unoccupied Rooms
                                                        </div>
                                                        <div class="text-red-600">
                                                            @foreach ($unoccupied_rooms as $room)
                                                                {{ $room->number }}
                                                                @if (!$loop->last)
                                                                    ,
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </dd>
                                                </div>
                                            </dl>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-end mt-3">
                                    <x-my.button-danger wire:click="endShift"
                                        label="Continue End Shift" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
