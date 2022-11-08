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
            wire:click="search('qr_code')"
            spinner="search('qr_code')"
            primary />
        <x-button label="Room Number"
            icon="search"
            wire:click="search('phone_number')"
            spinner="search('phone_number')"
            primary />
        @if ($this->guest)
            <x-button negative
                label="Clear"
                wire:click="clear"
                spinner="clear" />
        @endif
    </div>
    <div wire:key="main"
        class="mt-5"
        x-animate>
        @if ($this->guest)
            <div class="grid gap-3">
                <div wire:key="information-and-transactions">
                    @if ($this->guest->totaly_checked_out)
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
                        <div wire:key="{{ $this->guest->id }}-guest-information"
                            class="overflow-hidden bg-white border border-gray-300 shadow sm:rounded-lg">
                            <div class="px-4 py-3 sm:px-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Guest Information</h3>
                            </div>
                            <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Qr Code</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $this->guest?->qr_code }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Full name</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $this->guest?->name }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $this->guest?->contact_number }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Check in at
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $this->guest?->check_in_at }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div wire:key="transactions">
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
                                                @foreach ($guest_transactions as $transaction_type_id => $transactions)
                                                    <tr wire:key="head{{ $transaction_type_id }}"
                                                        class="border-t border-gray-200">
                                                        <th colspan="5"
                                                            scope="colgroup"
                                                            class="px-4 py-2 text-sm font-semibold text-left text-white bg-primary-600 sm:px-6">
                                                            {{ $transaction_types->find($transaction_type_id)->name }}
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
                                                            <td
                                                                class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                                ₱ {{ $transaction->payable_amount }}
                                                            </td>
                                                            <td
                                                                class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                                @if ($transaction->paid_at)
                                                                    {{ $transaction->paid_at }}
                                                                @else
                                                                    <x-button positive
                                                                        label="Pay"
                                                                        xs
                                                                        wire:click="payTransaction({{ $transaction->id }})" />
                                                                @endif
                                                            </td>
                                                            <td
                                                                class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
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
                                    <dt class="flex text-gray-900">Total Amount</dt>
                                    <dd class="text-xl font-bold text-gray-900">
                                        ₱ {{ $total_amount_to_pay }}
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
                        @if ($this->guest->totaly_checked_out == false)
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
