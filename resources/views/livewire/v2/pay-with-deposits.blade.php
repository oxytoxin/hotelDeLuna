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
