<div>
    <div>
        <x-table :headers="['Hour(s)', 'Amount', '']">
            <x-slot:topLeft>
                <x-input placeholder="Search"
                    wire:model.debounce.500ms="search"
                    icon="search" />
            </x-slot:topLeft>
            <x-slot:topRight>
                <div class="flex items-center space-x-3">
                    <x-button primary
                        wire:click="add"
                        label="Add Room" />
                </div>
            </x-slot:topRight>
            @forelse ($extend_amounts as $extend_amount)
                <x-table-row>
                    <x-table-data>
                        {{ $extend_amount->hours }} {{ Str::plural('hrs', $extend_amount->hours) }}
                    </x-table-data>
                    <x-table-data>
                        &#8369; {{ $extend_amount->amount }}
                    </x-table-data>
                    <x-table-data>
                        <div class="flex justify-end px-2">
                            <x-actions.edit wire:key="{{ $extend_amount->id }}"
                                wire:click="edit({{ $extend_amount->id }})"
                                wire:loading.class="cursor-progress"
                                wire:loading.attr="disabled"
                                wire:target="edit({{ $extend_amount->id }})" />
                        </div>
                    </x-table-data>
                </x-table-row>
            @empty
                <x-table-empty rows="3" />
            @endforelse
            <x-slot:pagination>
                {{ $extend_amounts->links() }}
            </x-slot:pagination>
        </x-table>
    </div>
    <div wire:key="modal-panel">
        <x-modal.card title="{{ $this->getModalTitle() }}"
            wire:model.defer="showModal">
            <form>
                @csrf
                <div class="gap-3 sm:grid sm:grid-cols-2">
                    <x-input label="Hours"
                        wire:model.defer="hours"
                        type="number"
                        placeholder="Hours" />
                    <x-input label="Amount"
                        wire:model.defer="amount"
                        type="number"
                        placeholder="Amount" />
                </div>
            </form>
            <x-slot:footer>
                <div wire:key="action-buttons">
                    @switch($mode)
                        @case('create')
                            <x-button wire:click="create"
                                spinner="create"
                                positive
                                label="Save" />
                        @break

                        @case('edit')
                            <x-button wire:click="update"
                                spinner="update"
                                info
                                label="Update" />
                        @break

                        @default
                    @endswitch
                </div>
            </x-slot:footer>
        </x-modal.card>
    </div>
</div>
