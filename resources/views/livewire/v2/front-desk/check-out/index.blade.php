<div class="grid gap-4">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="flex items-center space-x-3">
            <x-my.input.search wire:model.defer="search" />
            <x-my.input.select wire:model.defer="searchBy">
                <option value="1">QR CODE</option>
                <option value="2">ROOM Number</option>
            </x-my.input.select>
            @if ($search == '')
                <button id="searchButton"
                    type="button"
                    wire:click.prevent="searchGuest"
                    class="mt-1 inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    Search
                </button>
            @else
                <button id="clearSearchButton"
                    type="button"
                    wire:click="clearSearch"
                    class="mt-1 inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto">
                    Clear Search
                </button>
            @endif
        </div>
    </div>
    <div>
        @if ($guest)
            <div class="grid gap-3">
                <div wire:key="information-and-transactions">
                    @if ($guest->totaly_checked_out)
                        <div class="mb-3 rounded-md border border-red-500 bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: mini/information-circle -->
                                    <svg class="h-5 w-5 text-red-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1 md:flex md:justify-between">
                                    <p class="text-sm text-red-700">
                                        This guest has already checked out.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="guest-info">
                        <div wire:key="{{ $guest->id }}-guest-information"
                            class="overflow-hidden border border-gray-300 bg-white shadow sm:rounded-lg">
                            <div class="px-4 py-3 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Guest Information</h3>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
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
                </div>
                <div wire:key="deposits">
                    <x-card title="Deposits">
                        <x-transactions :headers="['Remarks', 'Amount', 'Deposit At', 'Deduction', 'Retrived', 'Actions']">
                            <x-slot:body>
                                @forelse ($deposits as $key => $deposit)
                                    <tr wire:key="{{ $key . $deposit->id }}">
                                        <x-transactions.cell>
                                            {{ $deposit->remarks }}
                                        </x-transactions.cell>
                                        <x-transactions.cell>
                                            {{ $deposit->amount }}
                                        </x-transactions.cell>
                                        <x-transactions.cell>
                                            {{ $deposit->created_at->format('d M Y') }}
                                        </x-transactions.cell>
                                        <x-transactions.cell>
                                            ₱{{ $deposit->deducted ?? '0' }}
                                        </x-transactions.cell>
                                        <x-transactions.cell>
                                            @if ($deposit->claimed_at)
                                                {{ Carbon\Carbon::parse($deposit->claimed_at)->format('d M Y') }}
                                            @else
                                                'Not yet'
                                            @endif
                                        </x-transactions.cell>
                                        <x-transactions.cell>
                                            <div class="flex space-x-3">
                                                @if ($deposit->claimed_at)
                                                    Claimed
                                                @else
                                                    <x-my.button-success label="Claim"
                                                        py="py-1"
                                                        x-on:click="$dispatch('confirm',{
                                                title : 'Are you sure?',
                                                message : 'Are you sure you want to proceed? Guest has PHP {{ $deposit->amount - $deposit->deducted }} left to claim.',
                                                confirmButtonText : 'Confirm',
                                                cancelButtonText : 'Cancel',
                                                confirmMethod : 'claimDeposit',
                                                confirmParams : {{ $deposit->id }}
                                            })" />
                                                @endif

                                            </div>
                                        </x-transactions.cell>
                                    </tr>
                                @empty
                                    <tr>
                                        <x-transactions.cell colspan="5">
                                            No transactions found
                                        </x-transactions.cell>
                                    </tr>
                                @endforelse
                            </x-slot:body>
                        </x-transactions>
                    </x-card>
                </div>
                <div wire:key="transactions">
                    <div class="rounded-md border bg-white shadow">
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
                                                            class="bg-primary-600 px-4 py-2 text-left text-sm font-semibold text-white sm:px-6">
                                                            {{ $transactionTypes->find($transaction_type_id)->name }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col"
                                                            class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-600 sm:pl-6">
                                                            Transaction Type</th>
                                                        <th scope="col"
                                                            class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-600">
                                                            Details</th>
                                                        <th scope="col"
                                                            class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-600">
                                                            Amount</th>
                                                        <th scope="col"
                                                            class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-600">
                                                            Paid At</th>
                                                        <th scope="col"
                                                            class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-600">
                                                            Date</th>
                                                    </tr>
                                                    @forelse ($transactions as $key=>$transaction)
                                                        <tr wire:key="rows{{ $transaction_type_id . $key }}"
                                                            class="border-t border-gray-300">
                                                            <td
                                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                {{ $transaction->transaction_type->name }}
                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                                {{ $transaction->remarks }}
                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                                ₱ {{ $transaction->payable_amount }}
                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
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
                                                            <td
                                                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                                {{ $transaction->created_at }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr wire:key="empty{{ $transaction_type_id }}"
                                                            class="border-t border-gray-300">
                                                            <td colspan="5"
                                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
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
                        <div class="bg-gray-100 p-3">
                            <dl class="mt-10 space-y-6 text-sm font-medium text-gray-500">
                                <div wire:key="totalAmount"
                                    class="flex justify-between">
                                    <dt class="flex text-gray-900">Total Amount</dt>
                                    <dd class="text-xl font-bold text-gray-900">
                                        ₱ {{ $totalAmountToPay }}
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
                </div>

                <div wire:key="button-checkOut">
                    <div>
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
        @endif
    </div>

    <div>
        <x-my.modal title="Override payable amount"
            :showOn="['show-override-modal']"
            :closeOn="['close-override-modal']">
            <x-my.input type="number"
                label="Amount"
                numberOnly
                wire:model="overrideAmount" />
            <x-slot name="footer">
                <div class="flex items-center space-x-3">
                    <x-my.button-secondary x-on:click="close()"
                        label="Cancel" />
                    <x-my.button-success wire:click="saveOverride"
                        label="Save" />
                </div>
            </x-slot>
        </x-my.modal>
    </div>
</div>
