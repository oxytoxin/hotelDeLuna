<div x-cloak
    x-show="currentTab == 1"
    wire:key="{{ $this->guest->id }}-transactions">
    @php
        $transactions_grouped_by_type = $this->guest->transactions->groupBy('transaction_type_id');
        $transaction_types = \App\Models\TransactionType::get();
    @endphp
    <div class="grid gap-5">
        @foreach ($transactions_grouped_by_type as $transaction_type_id => $transactions)
            <x-card title="{{ $transaction_types->find($transaction_type_id)->name }}">
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
                                                    Transaction Type</th>
                                                <th scope="col"
                                                    class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                    Amount</th>
                                                <th scope="col"
                                                    class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                    Details</th>
                                                <th scope="col"
                                                    class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                    Paid At</th>
                                                <th scope="col"
                                                    class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                    Date
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($transactions as $transaction)
                                                <tr>
                                                    <td
                                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                        {{ $transaction->transaction_type->name }}
                                                    </td>
                                                    <td
                                                        class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        ₱ {{ $transaction->payable_amount }}
                                                    </td>
                                                    <td
                                                        class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        @if ($transaction->transaction_type_id == 1)
                                                            Checked In ROOM #
                                                            {{ $transaction->check_in_detail->room->number }}
                                                        @endif
                                                        @if ($transaction->transaction_type_id == 2)
                                                            {{ $transaction->deposit->remarks }}
                                                        @endif
                                                        @if ($transaction->transaction_type_id == 7)
                                                            From ROOM #
                                                            {{ $transaction->room_change->fromRoom->number }}
                                                            ({{ $transaction->room_change->fromRoom->type->name }})
                                                            -
                                                            To ROOM #
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
                                                    <td colspan="5"
                                                        class="py-4 pl-4 pr-3 text-sm font-medium text-center text-gray-900 whitespace-nowrap sm:pl-6">
                                                        No {{ $transaction_type->name }} Transactions
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
        @endforeach
    </div>
</div>
