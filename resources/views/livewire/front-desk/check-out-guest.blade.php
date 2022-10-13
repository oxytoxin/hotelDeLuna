<div x-data
    x-init="$refs.search.focus()">
    <div class="flex p-2 space-x-3 bg-white border border-gray-300 rounded-lg">
        <div class="w-1/2">
            <x-input placeholder="Search Guest"
                wire:model.defer="search"
                x-ref="search" />
        </div>
        <x-button label="Qr Code"
            icon="search"
            wire:click="searchByQrCode"
            spinner="searchByQrCode"
            primary />
        <x-button label="Room Number"
            icon="search"
            wire:click="searchByRoomNumber"
            primary />
        <x-button label="Name"
            icon="search"
            wire:click="searchByName"
            primary />
        @if ($guest)
            <x-button negative
                label="Clear"
                wire:click="clear"
                spinner="clear" />
        @endif
    </div>
    <div wire:key="main"
        class="mt-5"
        x-animate>
        @if ($guest)
            <div class="grid grid-cols-8 gap-3 ">
                <div wire:key="information-and-transactions"
                    class="col-span-3">
                    @if ($guest->totaly_checked_out)
                        <div class="p-4 mb-3 border border-red-500 rounded-md bg-red-50">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: mini/information-circle -->
                                    <svg class="w-5 h-5 text-red-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1 ml-3 md:flex md:justify-between">
                                    <p class="text-sm text-red-700">
                                        This guest has already checked out.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="guest-info">
                        <div wire:key="{{ $guest->id }}-guest-information"
                            class="overflow-hidden bg-white border border-gray-300 shadow sm:rounded-lg ">
                            <div class="px-4 py-3 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Guest Information</h3>
                            </div>
                            <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Qr Code</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $guest?->qr_code }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Full name</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $guest?->name }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $guest?->contact_number }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Check in at
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $guest?->check_in_at }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div id="buttons"
                        x-data="{ step: 1 }"
                        class="w-full mt-2">
                        <div x-show="step==1"
                            id="reminder">
                            <x-button label="Check Out"
                                lg
                                x-on:click="
                                    alert('Please make sure the key and remote has been turned over');
                                    alert('Check room by the body');
                                    alert('Call guest to check-out in Kiosk');
                                    step = 2;
                                "
                                class="w-full"
                                ner="checkOut"
                                positive />
                        </div>
                        <div x-cloak
                            x-show="step==2">
                            @if ($guest->totaly_checked_out == false)
                                <x-button label="Check Out"
                                    lg
                                    wire:click="checkOut"
                                    class="w-full"
                                    ner="checkOut"
                                    positive />
                            @endif
                        </div>
                    </div>
                </div>
                <div wire:key="bill"
                    class="col-span-5">
                    <div class="bg-white rounded-lg ring-1 ring-black ring-opacity-10">
                        <div wire:key="{{ $guest->id }}-transactions">
                            <div class="flex p-2 mb-1 space-x-3">
                                <h1 class="text-gray-600">
                                    Transactions
                                </h1>
                                <span class="text-gray-400">|</span>
                                <button wire:click="toogleTransactionOrder"
                                    class="flex items-center space-x-3 text-gray-700 focus:outline-none hover:text-gray-800">
                                    <h1 class="text-gray-500">
                                        {{ $transactionOrder == 'ASC' ? 'Oldest' : 'Newest' }}
                                    </h1>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-5 h-5">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-col">
                                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        <div class="overflow-hidden shadow-md md:rounded-b-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col"
                                                            class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">
                                                            Transaction Type
                                                        </th>
                                                        <th scope="col"
                                                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                                            Amount
                                                        </th>
                                                        <th scope="col"
                                                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                                            Paid At
                                                        </th>

                                                        <th scope="col"
                                                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                                            Details
                                                        </th>
                                                        <th scope="col"
                                                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($transactions as $transaction)
                                                        <tr>
                                                            <td
                                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                                {{ $transaction->transaction_type->name }}
                                                                @if ($transaction->transaction_type_id === 1)
                                                                    | Room #
                                                                    {{ $transaction->check_in_detail->room->number }}
                                                                @endif
                                                            </td>
                                                            <td
                                                                class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                                {{ $transaction->payable_amount }}
                                                            </td>
                                                            <td
                                                                class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                                @if ($transaction->paid_at)
                                                                    {{ $transaction->paid_at }}
                                                                @else
                                                                    <button type="button"
                                                                        wire:click="payTransaction({{ $transaction->id }})"
                                                                        class="text-green-600 hover:text-green-900">
                                                                        <span> Pay </span>
                                                                    </button>
                                                                @endif
                                                            </td>
                                                            <td
                                                                class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                                <div class="flex justify-start text-gray-600">
                                                                    @if ($transaction->transaction_type_id == 7)
                                                                        ROOM #
                                                                        {{ $transaction->room_change->fromRoom->number }}
                                                                        ({{ $transaction->room_change->fromRoom->type->name }})
                                                                        -
                                                                        ROOM #
                                                                        {{ $transaction->room_change->toRoom->number }}
                                                                        ({{ $transaction->room_change->toRoom->type->name }})
                                                                    @endif
                                                                    @if ($transaction->transaction_type_id == 6)
                                                                        Extend for
                                                                        {{ $transaction->check_in_detail_extensions->hours }}
                                                                        hrs
                                                                    @endif
                                                                    @if ($transaction->transaction_type_id == 4)
                                                                        {{ $transaction->damage->hotel_item->name }}
                                                                    @endif
                                                                    @if ($transaction->transaction_type_id == 8)
                                                                        {{ $transaction->guest_request_item->requestable_item->name }}
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td colspan=""
                                                                class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                                <div class="flex justify-end">
                                                                    @if ($transaction->paid_at == null)
                                                                        <button
                                                                            wire:click="showOverrideModal({{ $transaction->id }})"
                                                                            class="flex items-center space-x-1 text-red-600 hover:text-red-900">
                                                                            <span>
                                                                                Override
                                                                            </span>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr class="bg-gray-50">
                                                        <td
                                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                            <span class="font-bold text-gray-700">Total</span>
                                                        </td>

                                                        <td colspan="4"
                                                            class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                            ₱{{ $transactions->sum('payable_amount') }}
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-gray-50">
                                                        <td
                                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                            <span class="font-bold text-gray-700">Balance</span>
                                                        </td>

                                                        <td colspan="4"
                                                            class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                            ₱{{ $transactions->where('paid_at', null)->sum('payable_amount') }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div wire:key="modal">
        <x-modal.card title="Override Action"
            max-width="sm"
            wire:model.defer="override.modal">
            <form class="grid gap-3">
                @csrf
                <x-input label="Amount"
                    wire:model.defer="override.new_amount"
                    type="number" />
                <x-input label="Authorization Code"
                    wire:model.defer="override.authorization_code"
                    type="password" />
            </form>
            <x-slot:footer>
                <x-button primary
                    wire:click="overrideTransaction">
                    Override
                </x-button>
            </x-slot:footer>
        </x-modal.card>
    </div>
</div>
