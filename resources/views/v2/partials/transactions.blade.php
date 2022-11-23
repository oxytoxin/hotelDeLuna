<div class="bg-white border rounded-md shadow">
    <div class="p-2">
        <h1 class="text-xl text-gray-700">
            Transactions
        </h1>
    </div>
    <div class="flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full">
                        <tbody class="bg-white">
                            @foreach ($transactionsGroup as $transaction_type_id => $transactions)
                                <tr wire:key="head{{ $transaction_type_id }}"
                                    class="border-t border-gray-200">
                                    <th colspan="5"
                                        scope="colgroup"
                                        class="px-4 py-2 text-sm font-semibold text-left text-white bg-primary-600 sm:px-6">
                                        {{ $transactionTypes->find($transaction_type_id)->name }}
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="col"
                                        class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-600 uppercase sm:pl-6">
                                        Transaction Type</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-600 uppercase">
                                        Details</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-600 uppercase">
                                        Amount</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-600 uppercase">
                                        Paid At</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-600 uppercase">
                                        Date</th>
                                </tr>
                                @forelse ($transactions as $key=>$transaction)
                                    <tr wire:key="rows{{ $transaction_type_id . $key }}"
                                        class="border-t border-gray-300">
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            {{ $transaction->transaction_type->name }}
                                        </td>
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            {{ $transaction->remarks }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            ₱ {{ $transaction->payable_amount }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                @if ($transaction->paid_at)
                                                    {{ $transaction->paid_at }}
                                                @else
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
                                                @endif

                                                @if ($transaction->paid_at == null)
                                                    <x-my.button-danger label="Override"
                                                        wire:click="showOverrideModal({{ $transaction->id }})"
                                                        py="py-1" />
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $transaction->created_at }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr wire:key="empty{{ $transaction_type_id }}"
                                        class="border-t border-gray-300">
                                        <td colspan="5"
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            No transactions yet.
                                        </td>
                                    </tr>
                                @endforelse
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="p-3 bg-gray-100">
        <dl class="mt-10 space-y-6 text-sm font-medium text-gray-500">
            <div wire:key="totalAmount"
                class="flex justify-between">
                <dt class="flex text-gray-900">Total Payable Amount</dt>
                <dd class="text-xl font-bold text-gray-900">
                    ₱ {{ $totalAmountToPay + $defaultDeposit }}
                </dd>
            </div>
            <div wire:key="balance"
                class="flex justify-between">
                <dt class="flex text-gray-900">
                    Balance
                </dt>
                <dd class="text-xl font-bold text-gray-900">
                    ₱ {{ $balance }}
                </dd>
            </div>
        </dl>
    </div>
</div>
