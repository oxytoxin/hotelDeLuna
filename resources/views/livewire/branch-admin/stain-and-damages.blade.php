<div>
    <div>
        <x-table :headers="['Item', 'Price', '']">
            <x-slot:topLeft>
                <x-input placeholder="Search"
                    wire:model.debounce.500ms="filter.search"
                    icon="search" />
            </x-slot:topLeft>
            <x-slot:topRight>
                <div class="flex items-center space-x-3">
                    <x-button primary
                        wire:click="add"
                        label="Add New" />
                </div>
            </x-slot:topRight>
            @forelse ($hotel_items as $hotel_item)
                <x-table-row>
                    <x-table-data>
                        {{ $hotel_item->name }}
                    </x-table-data>
                    <x-table-data>
                        ₱ {{ $hotel_item->price }}
                    </x-table-data>
                    <x-table-data>
                        <div class="flex justify-end px-2">
                            <x-actions.edit wire:key="{{ $hotel_item->id }}"
                                wire:click="edit({{ $hotel_item->id }})"
                                wire:loading.class="cursor-progress"
                                wire:loading.attr="disabled"
                                wire:target="edit({{ $hotel_item->id }})" />
                        </div>
                    </x-table-data>
                </x-table-row>
            @empty
                <x-table-empty rows="3" />
            @endforelse
            <x-slot:pagination>
                {{ $hotel_items->links() }}
            </x-slot:pagination>
        </x-table>
    </div>
    <div wire:key="modal-panel">
        <x-modal.card title="{{ $this->getModalTitle() }}"
            wire:model.defer="modal.show">
            <form class="gap-3 sm:grid sm:grid-cols-2">
                @csrf
                <x-input label="Item Name"
                    wire:model.defer="form.name"
                    placeholder="Item Name" />
                <x-input label="Price"
                    type="number"
                    wire:model.defer="form.price"
                    placeholder="Price" />
            </form>
            <x-slot:footer>
                @switch($modal['mode'])
                    @case('create')
                        <x-button wire:key="add-button"
                            positive
                            wire:click="create"
                            spinner="create"
                            label="Save" />
                    @break

                    @case('edit')
                        <x-button wire:key="update-button"
                            info
                            wire:click="update"
                            spinner="update"
                            label="Update" />
                    @break

                    @default
                @endswitch
            </x-slot:footer>
        </x-modal.card>
    </div>
</div>
