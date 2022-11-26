<aside class="hidden w-96 overflow-y-auto rounded-lg border border-gray-200 bg-white p-4 lg:block">
    <div class="grid gap-2">
        <div class="rounded-lg p-4">
            <h3 class="font-medium text-gray-900">
                Bill Summary Report
            </h3>
            <dl class="mt-2 divide-y divide-gray-200 border-t border-b border-gray-200">
                @php
                    $total = 0;
                @endphp
                @foreach ($transactionsGroup as $transaction_type_id => $transactions)
                    @if ($transaction_type_id != 2)
                        @php
                            $total += $transactions->sum('payable_amount');
                        @endphp
                        <div class="flex justify-between py-3 text-sm font-medium">
                            <dt class="text-gray-500"> {{ $transactionTypes->find($transaction_type_id)->name }}</dt>
                            <dd class="whitespace-nowrap text-gray-900">
                                PHP {{ number_format($transactions->sum('payable_amount'), 2) }}
                            </dd>
                        </div>
                    @endif
                @endforeach
                <div class="flex justify-between py-3 text-sm font-medium">
                    <dt class="text-gray-700">
                        Total
                    </dt>
                    <dd class="whitespace-nowrap font-bold text-gray-900">
                        PHP {{ number_format($total, 2) }}
                    </dd>
                </div>
            </dl>
        </div>
        <div class="rounded-lg p-4">
            <h3 class="font-medium text-gray-900">
                Deposits
            </h3>
            <dl class="mt-2 divide-y divide-gray-200 border-t border-b border-gray-200">
                @php
                    $totalDeposit = 0;
                @endphp
                @foreach ($deposits as $deposit)
                    @php
                        $totalDeposit += $deposit->amount - $deposit->deducted;
                    @endphp
                    <div class="flex justify-between py-3 text-sm font-medium">
                        <dt class="text-gray-500"> {{ $deposit->remarks }}</dt>
                        <dd class="whitespace-nowrap text-gray-900">
                            PHP {{ number_format($deposit->amount - $deposit->deducted, 2) }}
                        </dd>
                    </div>
                @endforeach
                <div class="flex justify-between py-3 text-sm font-medium">
                    <dt class="text-gray-500">Total</dt>
                    <dd class="whitespace-nowrap font-bold text-gray-900">
                        PHP {{ number_format($totalDeposit, 2) }}
                    </dd>
                </div>
            </dl>
        </div>
        <div class="rounded-lg p-4">
            <h3 class="font-medium text-gray-900">
                Payment
            </h3>
            <dl class="mt-2 divide-y divide-gray-200 border-t border-b border-gray-200">
                <div class="flex justify-between py-3 text-sm font-medium">
                    <dt class="text-gray-500">Balance</dt>
                    <dd class="whitespace-nowrap font-bold text-gray-900">
                        PHP {{ number_format($balance, 2) }}
                    </dd>
                </div>
            </dl>
        </div>
        <div class="flex">
            <button type="button"
                wire:click="validateCheckOut"
                class="flex-1 rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Check Out
            </button>
        </div>
    </div>
</aside>
