<div>
  <div class="px-4 pt-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-lg font-semibold text-gray-900">
          Transactions
        </h1>
      </div>
    </div>
    <div class="mt-3 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle">
          <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                    Details
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                    Amount
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                    Transaction Date
                  </th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                    Paid at
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($guest_transactions as $transaction_type_id => $transactions)
                  <tr class="border-t border-gray-200">
                    <th colspan="5" scope="colgroup"
                      class="bg-primary-600 px-4 py-2 text-left text-sm font-semibold text-white sm:px-6">
                      {{ $transactionTypes->find($transaction_type_id)->name }}
                    </th>
                  </tr>
                  @foreach ($transactions as $transaction)
                    <tr>
                      <td class="py-3.5 pl-4 pr-3 text-xs text-gray-900 sm:pl-6 lg:pl-8">
                        <p class="w-40">{{ $transaction->remarks }}</p>
                      </td>
                      <td class="px-3 py-3.5 text-xs text-gray-900">
                        {{ $transaction->payable_amount }}
                      </td>

                      <td class="px-3 py-3.5 text-xs text-gray-900">
                        {{ $transaction->created_at->format('M d, Y h:i A') }}
                      </td>
                      <td class="px-3 py-3.5 text-right text-xs font-medium">
                        <div class="flex space-x-3">
                          @if ($transaction->paid_at == null)
                            {{-- <x-my.button-success label="Pay"
                              x-on:click="$dispatch('confirm',{
                                                        title : 'Are you sure?',
                                                        message : 'Are you sure you want to proceed?',
                                                        confirmButtonText : 'Confirm',
                                                        cancelButtonText : 'Cancel',
                                                        confirmMethod : 'payTransaction',
                                                        confirmParams :{{ $transaction->id }},
                                                })"
                              py="py-1" /> --}}
                            <x-my.button-success label="Pay" wire:click="payTransaction({{ $transaction->id }})"
                              py="py-1" />
                            <x-my.button-warning label="Pay With Deposit"
                              wire:click="payWithDeposit({{ $transaction->id }}, {{ $transaction->payable_amount }})"
                              py="py-1" />
                          @else
                            {{ Carbon\Carbon::parse($transaction->paid_at)->format('M d, Y h:i A') }}
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
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
