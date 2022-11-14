<div class="grid gap-4">
    <x-card title="Food and Beverage">
        <form>
            @csrf
            <div class="sm:grid sm:grid-cols-1 sm:gap-3">
                <x-input wire:model.defer="form.name"
                    label="Name" />
                <x-input type="number"
                    wire:model.defer="form.quantity"
                    label="Quantity" />
                <x-input wire:model.defer="form.price"
                    label="Total Price" />
            </div>
        </form>
        <x-slot:footer>
            <div class="flex space-x-3">
                <x-button label="Clean Form"
                    negative />
                <x-button label="Save"
                    wire:click="save"
                    spinner="save"
                    positive />
            </div>
        </x-slot:footer>
    </x-card>
    <div wire:key="salkjhfdq98ehrlkahfznkcvneiuhf9q328">
        <x-card title="Transactions">
            <x-transactions :headers="['Details', 'Amount', 'Paid At', 'Date']">
                <x-slot:body>
                    @forelse ($transactions as $key => $transaction)
                        <tr wire:key="{{ $key . $transaction->id }}">
                            <x-transactions.cell>
                                {{ $transaction->remarks }}
                            </x-transactions.cell>
                            <x-transactions.cell>
                                {{ $transaction->payable_amount }}
                            </x-transactions.cell>
                            <x-transactions.cell>
                                @if ($transaction->paid_at)
                                    {{ Carbon\Carbon::parse($transaction->paid_at)->format('M d, Y h:i:s A') }}
                                @else
                                    <button type="button"
                                        wire:click="payTransaction({{ $transaction->id }})"
                                        class="text-green-600 hover:text-green-900">
                                        <span> Pay </span>
                                    </button>
                                @endif
                            </x-transactions.cell>
                            <x-transactions.cell>
                                {{ $transaction->created_at }}
                            </x-transactions.cell>
                        </tr>
                    @empty
                        <tr>
                            <x-transactions.cell colspan="4">
                                No transactions found
                            </x-transactions.cell>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-transactions>
        </x-card>
    </div>
</div>
