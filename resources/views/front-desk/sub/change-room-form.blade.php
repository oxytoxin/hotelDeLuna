<div>
    <x-modal.card wire:model.defer="changeRoomModal"
        title="Change Room">
        <form>
            @csrf
            <div class="gap-3 sm:grid sm:grid-cols-1">
                <x-native-select label="From what room"
                    wire:model.defer="from_room">
                    <option value="">Select Room</option>
                    @if ($changeRoomModal == true)
                        @foreach ($transactions->where('transaction_type_id', 1) as $transaction)
                            @if ($transaction->check_in_detail->check_out_at == null)
                                <option value="{{ $transaction->check_in_detail->id }}">
                                    Room # {{ $transaction->check_in_detail->room->number }}
                                </option>
                            @endif
                        @endforeach
                    @endif
                </x-native-select>
                <x-native-select label="To what room"
                    wire:model.defer="to_room">
                    <option value="">Select Room</option>
                    @if ($changeRoomModal == true)
                        @foreach (App\Models\Room::where('room_status_id', 1)->get() as $room)
                            <option value="{{ $room->id }}">
                                Room # {{ $room->number }}
                            </option>
                        @endforeach
                    @endif
                </x-native-select>
                <div>
                    <x-textarea label="Reason"
                        wire:model.defer="reason">
                    </x-textarea>
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button label="Save Changes"
                wire:click="saveChangeRoom"
                spinner="saveChangeRoom"
                primary />
        </x-slot:footer>
    </x-modal.card>
</div>
