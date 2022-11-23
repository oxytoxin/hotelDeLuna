<aside class="hidden p-4 overflow-y-auto bg-white border border-gray-200 rounded-lg w-96 lg:block">
    <div class="grid gap-2">
        <div class="p-4 rounded-lg">
            <h3 class="font-medium text-gray-900">
                Bill Summary Report
            </h3>
            <dl class="mt-2 border-t border-b border-gray-200 divide-y divide-gray-200">
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
                            <dd class="text-gray-900 whitespace-nowrap">
                                PHP {{ number_format($transactions->sum('payable_amount'), 2) }}
                            </dd>
                        </div>
                    @endif
                @endforeach
                <div class="flex justify-between py-3 text-sm font-medium">
                    <dt class="text-gray-700">
                        Total
                    </dt>
                    <dd class="font-bold text-gray-900 whitespace-nowrap">
                        PHP {{ number_format($total, 2) }}
                    </dd>
                </div>
            </dl>
        </div>
        <div class="p-4 rounded-lg">
            <h3 class="font-medium text-gray-900">
                Deposits
            </h3>
            <dl class="mt-2 border-t border-b border-gray-200 divide-y divide-gray-200">
                @php
                    $totalDeposit = 0;
                @endphp
                @foreach ($transactionsGroup as $transaction_type_id => $transactions)
                    @foreach ($transactions->where('transaction_type_id', 2) as $transaction)
                        @php
                            $totalDeposit += $transaction->payable_amount;
                        @endphp
                        <div class="flex justify-between py-3 text-sm font-medium">
                            <dt class="text-gray-500"> {{ $transaction->remarks }}</dt>
                            <dd class="text-gray-900 whitespace-nowrap">
                                PHP {{ number_format($transaction->payable_amount, 2) }}
                            </dd>
                        </div>
                    @endforeach
                @endforeach
                <div class="flex justify-between py-3 text-sm font-medium">
                    <dt class="text-gray-500">Total</dt>
                    <dd class="text-gray-900 whitespace-nowrap">
                        PHP {{ number_format($totalDeposit, 2) }}
                    </dd>
                </div>
            </dl>
        </div>
        <div class="p-4 rounded-lg">
            <h3 class="font-medium text-gray-900">
                Payment
            </h3>
            <dl class="mt-2 border-t border-b border-gray-200 divide-y divide-gray-200">
                <div class="flex justify-between py-3 text-sm font-medium">
                    <dt class="text-gray-500">Balance</dt>
                    <dd class="text-gray-900 whitespace-nowrap">
                        PHP {{ number_format($balance, 2) }}
                    </dd>
                </div>
            </dl>
        </div>
        <div class="flex">
            <button type="button"
                wire:click="validateCheckOut"
                class="flex-1 px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Check Out
            </button>
        </div>
    </div>
</aside>
