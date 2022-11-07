<div class="grid gap-4"
    x-data
    x-intersect.once="$wire.componentIsLoaded">
    <x-card title="Amenities">
        <form>
            @csrf
            <div class="gap-3 sm:grid sm:grid-cols-2">
                <x-native-select label="Select"
                    wire:model="form.requestable_item_id">
                    <option value="">Select</option>
                    @foreach ($requestableItems as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </x-native-select>
                <x-input wire:model.defer="form.price"
                    label="Price"
                    disabled="true" />
                <x-input wire:model="form.quantity"
                    label="Quantity"
                    type="number" />
                <x-input label="Additional Charge"
                    wire:model.defer="form.additional_charge"
                    type="number" />
            </div>
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
        </form>
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
                                    {{ Carbon\Carbon::parse($transaction->paid_at)->format('Y/m/d h:i:s A') }}
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
