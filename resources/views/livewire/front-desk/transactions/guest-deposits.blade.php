<div class="grid gap-4"
    x-data
    x-intersect.once="$wire.componentIsLoaded">
    <form wire:submit.prevent="save">
        @csrf
        <x-card title="Deposit">
            <div class="gap-3 sm:grid sm:grid-cols-1">
                <x-input wire:model.defer="form.amount"
                    label="Amount"
                    type="number" />
                <x-textarea wire:model.defer="form.remarks"
                    label="Remarks" />
            </div>
            <x-slot:footer>
                <div class="flex space-x-3">
                    <x-button label="Clean Form"
                        negative />
                    <x-button label="Save"
                        type="submit"
                        spinner="save"
                        positive />
                </div>
            </x-slot:footer>
        </x-card>
    </form>

    <div wire:key="salkjhfdq98ehrlkahfznkcvneiuhf9q328">
        <x-card title="Transactions">
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
                                    <x-button wire:click="showDeductionModal({{ $deposit->id }})"
                                        warning
                                        xs>
                                        Deduct
                                    </x-button>
                                    <x-button positive
                                        wire:click="claimeDeposit({{ $deposit->id }})"
                                        xs>
                                        Claim
                                    </x-button>
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

    <div wire:key="modals-deposit">
        <form wire:submit.prevent="saveDeduction">
            @csrf
            <x-modal.card wire:model.defer="deductionModal"
                title="Deposit Deduction">
                <x-input wire:model.defer="deductionAmount"
                    label="Amount"
                    type="number" />
                <x-slot:footer>
                    <div class="flex space-x-3">
                        <x-button negative
                            x-on:click="close">
                            Cancel
                        </x-button>
                        <x-button type="submit"
                            positive>
                            Save
                        </x-button>
                    </div>
                </x-slot:footer>
            </x-modal.card>
        </form>
    </div>
</div>
