<div wire:key="{{ $guest->id }}-transactions">
    {{-- <div class="flex mb-1 space-x-3">
        <h1 class="text-gray-600">
            Transactions
        </h1>
        <span class="text-gray-400">|</span>
        <button wire:click="toogleTransactionOrder"
            class="flex items-center space-x-3 text-gray-700 focus:outline-none hover:text-gray-800">
            <h1 class="text-gray-500">
                {{ $transaction_order == 'ASC' ? 'Oldest' : 'Newest' }}
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
                <div class="overflow-hidden shadow-md ring-1 ring-black ring-opacity-10 md:rounded-lg">
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
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($guest->transactions()->orderBy('created_at', $transaction_order)->with(['check_in_detail.room', 'room_change.toRoom.type', 'transaction_type', 'damage.hotel_item', 'guest_request_item.requestable_item'])->get() as $transaction)
                                <tr>
                                    <td
                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        {{ $transaction->transaction_type->name }}
                                        @if ($transaction->transaction_type_id === 1)
                                            | Room # {{ $transaction->check_in_detail->room->number }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $transaction->payable_amount }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
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
                                        class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                        <div class="flex justify-end text-gray-600">
                                            @if ($transaction->transaction_type_id == 7)
                                                ROOM # {{ $transaction->room_change->fromRoom->number }}
                                                ({{ $transaction->room_change->fromRoom->type->name }})
                                                -
                                                ROOM # {{ $transaction->room_change->toRoom->number }}
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
    <x-card title="Transactions">
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
                                            Transaction Type</th>
                                        <th scope="col"
                                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                            Amount</th>
                                        <th scope="col"
                                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                            Details</th>
                                        <th scope="col"
                                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                            Paid At</th>
                                        <th scope="col"
                                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                            Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($guest->transactions()->orderBy('created_at', $transaction_order)->with(['check_in_detail.room', 'room_change.toRoom.type', 'transaction_type', 'damage.hotel_item', 'guest_request_item.requestable_item', 'deposit'])->get() as $transaction)
                                        <tr>
                                            <td
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                {{ $transaction->transaction_type->name }}

                                            </td>
                                            <td
                                                class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                ₱ {{ $transaction->payable_amount }}
                                            </td>
                                            <td
                                                class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                @if ($transaction->transaction_type_id == 1)
                                                    Checked In ROOM # {{ $transaction->check_in_detail->room->number }}
                                                @endif
                                                @if ($transaction->transaction_type_id == 2)
                                                    {{ $transaction->deposit->remarks }}
                                                @endif
                                                @if ($transaction->transaction_type_id == 7)
                                                    From ROOM # {{ $transaction->room_change->fromRoom->number }}
                                                    ({{ $transaction->room_change->fromRoom->type->name }})
                                                    -
                                                    To ROOM # {{ $transaction->room_change->toRoom->number }}
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
                                            </td>
                                            <td
                                                class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
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
                                                class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                {{ $transaction->created_at->format('Y/m/d h:i:s A') }}
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

    </x-card>
</div>
