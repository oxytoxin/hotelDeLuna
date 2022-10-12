<div class="space-y-5">
    <div>
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
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Expected Check Out
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $guest?->transactions->where('transaction_type_id', 1)->first()->check_in_detail->expected_check_out_at }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Initial Check In
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $guest?->transactions->where('transaction_type_id', 1)->first()->check_in_detail->static_hours_stayed }}
                            hrs
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    <div>
        <div wire:key="{{ $guest->id }}-transactions">
            <div class="flex mb-1 space-x-3">
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
                                    @foreach ($guest->transactions()->orderBy('created_at', $transaction_order)->with(['check_in_detail.room', 'room_change.toRoom.type', 'transaction_type', 'damage.hotel_item'])->get() as $transaction)
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
                                                        {{ $transaction->check_in_detail_extensions->hours }} hrs
                                                    @endif
                                                    @if ($transaction->transaction_type_id == 4)
                                                        {{ $transaction->damage->hotel_item->name }}
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
            </div>
        </div>
    </div>
</div>
