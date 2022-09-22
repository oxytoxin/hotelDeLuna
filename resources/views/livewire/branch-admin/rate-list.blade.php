<div>
    <x-table :headers="['Hours', 'Amount', 'Room Type', '']">
        <x-slot:topRight>
            <x-button label="Add Rate"
                wire:click="add"
                primary />
        </x-slot:topRight>
        @forelse ($rates as $groups)
            <x-table-row>
                <x-table-data colspan="4"
                    class="font-bold bg-gray-50">
                    {{ $groups[0]->type->name }}
                </x-table-data>
            </x-table-row>
            @forelse ($groups as $rate)
                <x-table-row>
                    <x-table-data>
                        {{ $rate->staying_hour->number }}
                    </x-table-data>
                    <x-table-data>
                        {{ $rate->amount }}
                    </x-table-data>
                    <x-table-data>
                        {{ $rate->type->name }}
                    </x-table-data>
                    <x-table-data>
                        <div class="flex justify-end px-2">
                            <button wire:key="{{ $rate->id }}"
                                wire:click="edit({{ $rate->id }})"
                                wire:loading.class="cursor-progress"
                                wire:loading.attr="disabled"
                                wire:target="edit({{ $rate->id }})"
                                class="uppercase text-primary-600 hover:text-primary-900">Edit</button>
                        </div>
                    </x-table-data>
                </x-table-row>
            @empty
                <x-table-empty rows="5" />
            @endforelse
        @empty
            <x-table-empty rows="5" />
        @endforelse
    </x-table>
    <div wire:key="modal-panel">
        <x-modal.card title="{{ $this->getModeTitle() }}"
            wire:model.defer="showModal">
            <form>
                @csrf
                <div class="gap-3 sm:grid sm:grid-cols-2">
                    <x-native-select label="Select Hours"
                        wire:model.defer="staying_hour_id">
                        <option value=""
                            disabled>Select Hours</option>
                        @foreach ($hours as $hour)
                            <option value="{{ $hour->id }}">{{ $hour->number }}</option>
                        @endforeach
                    </x-native-select>
                    <x-native-select label="Select Room Type"
                        wire:model.defer="room_type_id">
                        <option value=""
                            disabled>Select type</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </x-native-select>
                    <x-input label="Amount"
                        placeholder="Enter amount"
                        type="number"
                        wire:model.defer="amount" />
                </div>
            </form>
            <x-slot:footer>
                <x-button wire:click="save"
                    spinner="save"
                    primary>
                    Save
                </x-button>
            </x-slot:footer>
        </x-modal.card>
    </div>
</div>
