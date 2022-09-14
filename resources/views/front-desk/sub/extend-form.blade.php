<div>
    <x-modal.card wire:model.defer="extendModal"
        title="Extent Check In Hour">
        <form>
            @csrf
            <div class="gap-3 sm:grid sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-native-select label="Room"
                        wire:model.defer="checked_in_room">
                        <option value="">Select Room</option>
                        @if ($loadTransactions == true)
                            @foreach ($transactions->where('transaction_type_id', 1) as $transaction)
                                @if ($transaction->check_in_detail->check_out_at == null)
                                    <option value="{{ $transaction->check_in_detail->id }}">
                                        Room # {{ $transaction->check_in_detail->room->number }}
                                    </option>
                                @endif
                            @endforeach
                        @endif
                    </x-native-select>
                </div>
                <x-input label="Extend Hour"
                    type="number"
                    wire:model.defer="hours" />
                <x-input label="Extension amount"
                    type="number"
                    prefix="₱"
                    wire:model.defer="extension_amount">
                </x-input>
                <x-checkbox id="right-label"
                    wire:model.defer="extention_paid"
                    label="Paid" />
            </div>
        </form>
        <x-slot:footer>
            <x-button label="Extend"
                wire:click="saveExtend"
                spinner="saveExtend"
                primary />
        </x-slot:footer>
    </x-modal.card>
</div>
