<div>
    <x-table :headers="['Hours', 'Amount', 'Room Type', '']">
        <x-slot:topRight>
            <x-button label="Add Rate" wire:click="add" emerald />
        </x-slot:topRight>
        @forelse ($types as $key=>$type)
            <x-table-row wire:key="{{ $type->id }}-type">
                <x-table-data colspan="4" class="font-bold bg-gray-50">
                    {{ $type->name }}
                </x-table-data>
            </x-table-row>
            @forelse ($type->rates as $rate)
                <x-table-row wire:key="{{ $rate->id }}rates">
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
                            <x-actions.edit wire:key="{{ $rate->id }}" wire:click="edit({{ $rate->id }})"
                                wire:loading.class="cursor-progress" wire:loading.attr="disabled"
                                wire:target="edit({{ $rate->id }})" />
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
        <x-modal.card title="{{ $this->getModalTitle() }}" wire:model.defer="showModal">
            <form>
                @csrf
                <div class="gap-3 sm:grid sm:grid-cols-1">
                    <x-native-select label="Select Hours" wire:model.defer="staying_hour_id">
                        <option value="" disabled>Select Hours</option>
                        @foreach ($hours as $hour)
                            <option value="{{ $hour->id }}">{{ $hour->number }}</option>
                        @endforeach
                    </x-native-select>
                    <div wire:key="select_type">
                        @if ($mode == 'create')
                            <x-native-select label="Select Room Type" wire:model.defer="room_type_id">
                                <option value="" disabled>Select type</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </x-native-select>
                        @endif
                    </div>
                    <x-input label="Amount" placeholder="Enter amount" type="number" wire:model.defer="amount" />
                </div>
            </form>
            <x-slot:footer>
                <div wire:key="action-buttons">
                    @switch($mode)
                        @case('create')
                            <x-button wire:click="create" spinner="create" positive label="Save" />
                        @break

                        @case('edit')
                            <x-button wire:click="update" spinner="update" info label="Update" />
                        @break

                        @default
                    @endswitch
                </div>
            </x-slot:footer>
        </x-modal.card>
    </div>
</div>
