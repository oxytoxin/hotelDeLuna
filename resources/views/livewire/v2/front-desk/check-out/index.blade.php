<div x-data="{
    reminder: false,
    showReminder() {
        this.reminder = true
    },
    reminders: [
        'Hand over by the guest/room boy the key and remote',
        'Check room by the body',
        'Call guest to check-out in Kiosk',
    ],
    allowNext: true,
    reminderCount: 0,
    next() {
        if (this.reminderCount == 2) {
            $dispatch('confirm', {
                title: 'Are you sure?',
                message: 'Are you sure you want to check-out this guest?',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                confirmMethod: 'checkOut',
            })
        } else {
            this.allowNext = false
            this.reminderCount++
        }
    },
}" x-init="$watch('allowNext', (value) => {
    if (this.allowNext == false) {
        setTimeout(() => {
            this.allowNext = true
        }, 3000)
    }
})" x-on:show-reminder.window="showReminder();reminderCount = 0"
  x-on:close-reminder.window="reminder = false" class="grid gap-4">
  <div class="sm:flex sm:items-center sm:justify-between">
    <div class="flex items-center space-x-3">
      <x-my.input.search wire:model.defer="search" />
      <x-my.input.select wire:model.defer="searchBy">
        <option value="1">QR CODE</option>
        <option value="2">ROOM Number</option>
      </x-my.input.select>
      @if ($search == '')
        <button id="searchButton" type="button" wire:click.prevent="searchGuest"
          class="inline-flex items-center justify-center px-4 py-2 mt-1 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
          Search
        </button>
      @else
        <button id="clearSearchButton" type="button" wire:click="clearSearch"
          class="inline-flex items-center justify-center px-4 py-2 mt-1 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto">
          Clear Search
        </button>
      @endif
    </div>
  </div>
  {{-- <div>
        @if ($guest)
            <div class="grid gap-3">
                <div wire:key="information-and-transactions">
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
                            class="overflow-hidden bg-white border border-gray-300 shadow sm:rounded-lg">
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
                                                            <td
                                                                class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                                ₱ {{ $transaction->payable_amount }}
                                                            </td>
                                                            <td
                                                                class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
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
                </div>

                <div wire:key="button-checkOut">
                    <div>
                        @if ($guest->totaly_checked_out == false)
                            <x-button label="Check Out"
                                lg
                                wire:click="validateCheckOut"
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
    <div class="relative z-40"
        x-cloak
        x-show="reminder"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true">
        <div x-cloak
            x-show="reminder"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">

                <div x-cloak
                    x-show="reminder"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                    <div>

                        <div class="mt-2 text-center sm:mt-5">
                            <h3 class="text-lg font-medium leading-6 text-gray-900"
                                id="modal-title">
                                Check Out Reminder
                            </h3>
                            <div class="mt-2">
                                <p class="font-bold text-gray-700"
                                    x-text="reminders[reminderCount]"></p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="button"
                            x-on:click="next()"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:bg-red-500 sm:text-sm"
                            x-text="reminderCount == 2 ? 'Check Out' : 'Next'">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

  @if ($guest)
    <div x-data="{ tab: '1' }" class="grid gap-5" x-animate>
      <div>
        <div>
          <div class="border-b border-gray-200">
            <nav class="flex -mb-px space-x-8" aria-label="Tabs">
              <button type="button" x-on:click="tab = '1'"
                class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent whitespace-nowrap hover:border-gray-300 hover:text-gray-700">
                Details
              </button>
              <button type="button" x-on:click="tab = '2'"
                class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent whitespace-nowrap hover:border-gray-300 hover:text-gray-700">
                Transactions
              </button>
              <button type="button" x-on:click="tab = '3'"
                class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent whitespace-nowrap hover:border-gray-300 hover:text-gray-700">
                Deposits
              </button>
            </nav>
          </div>
        </div>
      </div>
      <div x-show="tab=='1'" class="flex items-stretch flex-1 space-x-5 overflow-hidden">
        @include('v2.partials.guest-details')

        <!-- Details sidebar -->
        @include('v2.partials.bill-summary')
      </div>
      <div x-cloak x-show="tab=='2'" wire:key="transactions">
        @include('v2.partials.transactions')
      </div>
      <div x-cloak x-show="tab=='3'" wire:key="deposits">
        @include('v2.partials.deposits')
      </div>
    </div>
    <div>
      <x-my.modal title="Override payable amount" :showOn="['show-override-modal']" :closeOn="['close-override-modal']">
        <x-my.input type="number" label="Amount" numberOnly wire:model="overrideAmount" />
        <x-slot name="footer">
          <div class="flex items-center space-x-3">
            <x-my.button-secondary x-on:click="close()" label="Cancel" />
            <x-my.button-success wire:click="saveOverride" label="Save" />
          </div>
        </x-slot>
      </x-my.modal>
    </div>
    <div class="relative z-40" x-cloak x-show="reminder" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div x-cloak x-show="reminder" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

      <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">

          <div x-cloak x-show="reminder" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
            <div>

              <div class="mt-2 text-center sm:mt-5">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                  Check Out Reminder
                </h3>
                <div class="mt-2">
                  <p class="font-bold text-gray-700" x-text="reminders[reminderCount]"></p>
                </div>
              </div>
            </div>
            <div class="mt-5 sm:mt-6">
              <button type="button" x-on:click="next()"
                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:bg-red-500 sm:text-sm"
                x-text="reminderCount == 2 ? 'Check Out' : 'Next'">
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div wire:key="modals-pay">
    <form wire:submit.prevent="payTransactionConfirm">
      @csrf
      <x-my.modal title="Pay Transaction : ₱ {{ $transactionToPayAmount }} " :showOn="['show-pay-modal']" :closeOn="['close-pay-modal']">
        <div class="grid space-y-4" x-animate>
          <x-my.input label="Enter Amount" wire:model.debounce.500ms="transactionToPayGivenAmount" numberOnly
            required />
          <x-my.input label="Excess Amount" wire:model="transactionToPayExcessAmount" numberOnly required />
          @if ($this->transactionToPayExcessAmount > 0)
            <div class="flex items-center space-x-3">
              <input id="deposit" aria-describedby="comments-description" name="deposit" type="checkbox"
                wire:model.defer="transactionToPaySaveExcessAmount"
                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500">
              <span>
                Save excess amount as deposit
              </span>
            </div>
          @endif
        </div>
        <x-slot name="footer">
          <div class="flex items-center space-x-3">
            <x-my.button-secondary x-on:click="close()" label="Cancel" />
            <x-my.button-success type="submit" loadingOn="payTransactionConfirm" label="Save" />
          </div>
        </x-slot>
      </x-my.modal>
    </form>
  </div>
</div>
