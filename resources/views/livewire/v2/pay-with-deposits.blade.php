<div>
    <x-my.modal title="Select Deposits"
        width="sm:max-w-xl"
        :showOn="['show-deposits-modal']"
        :closeOn="['close-deposits-modal']">
        @if ($guest)
            <div class="grid gap-4">
                <div class="">
                    Total Balance: ₱ {{ $guest->deposit_balance }}
                </div>
                <div class="">
                    Total Amount to Pay: ₱ {{ $payableAmount }}
                </div>
                @if ($guest->deposit_balance < $payableAmount)
                    <div class="">
                        <span class="text-sm text-red-500">Deposit amount is not enough. Please enter the amount in
                            addition to the total balance.</span>
                        <x-my.input type="number"
                            label=""
                            wire:model.debounce.500ms="additionalAmount" />
                    </div>
                    <div class="">
                        @if ($additionalAmountChange >= 0)
                            @if ($additionalAmountChange > 0)
                                <span> Excess Amount : ₱ {{ $additionalAmountChange }}</span>
                                <div class="flex items-center space-x-3">
                                    <input id="deposit"
                                        aria-describedby="comments-description"
                                        name="deposit"
                                        type="checkbox"
                                        wire:model.defer="additionalAmountChangeSaveToDeposit"
                                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500">
                                    <span>
                                        Save excess amount as deposit
                                    </span>
                                </div>
                            @endif
                        @else
                            <span class="text-sm text-red-500">
                                Invalid amount.
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        @endif
        <x-slot:footer>
            <div class="flex space-x-3">
                <x-my.button-success wire:click="save"
                    label="Pay" />
            </div>
        </x-slot:footer>
    </x-my.modal>
</div>
