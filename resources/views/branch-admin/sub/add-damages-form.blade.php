<div>
    <x-modal.card wire:model.defer="addDamageModal"
        title="Add Damages">
        <form>
            @csrf
            <div class="gap-3 sm:grid sm:grid-cols-2">
                <x-input label="Damage Item"
                    wire:model.defer="damaged_item"
                    list="autocompletedata"
                    autocomplete="on" />
                <datalist id="autocompletedata">
                    @foreach ($damages as $damage)
                        <option value="{{ $damage }}">
                    @endforeach
                </datalist>
                <x-input label="Amount"
                    wire:model.defer="amount" />
                <x-input label="Occured At"
                    wire:model.defer="occured_at"
                    type="Datetime-local" />
                <x-native-select label="Room"
                    wire:model.defer="room_id">
                    <option value="">Select Room</option>
                    @if ($loadTransactions == true)
                        @foreach ($transactions->where('transaction_type_id', 1) as $transaction)
                            @if ($transaction->check_in_detail->check_out_at == null)
                                <option value="{{ $transaction->check_in_detail->room->id }}">
                                    Room # {{ $transaction->check_in_detail->room->number }}
                                </option>
                            @endif
                        @endforeach
                    @endif
                </x-native-select>
                <x-checkbox id="right-label"
                    wire:model.defer="paid"
                    label="Paid" />
            </div>
        </form>
        <x-slot:footer>
            <x-button label="Save"
                wire:click="saveDamageRecord"
                spinner="saveDamageRecord"
                primary />
        </x-slot:footer>
    </x-modal.card>
</div>
