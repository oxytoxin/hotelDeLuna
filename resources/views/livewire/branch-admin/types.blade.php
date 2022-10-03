<div>
    <div>
        <x-table :headers="['Type Name', '']">
            <x-slot:topRight>
                <x-button label="Add Type"
                    wire:click="add"
                    primary />
            </x-slot:topRight>
            @forelse ($types as $type)
                <x-table-row>
                    <x-table-data>
                        {{ $type->name }}
                    </x-table-data>
                    <x-table-data>
                        <div class="flex justify-end px-2">
                            <x-actions.edit wire:key="{{ $type->id }}"
                                wire:click="edit({{ $type->id }})"
                                wire:loading.class="cursor-progress"
                                wire:loading.attr="disabled"
                                wire:target="edit({{ $type->id }})" />
                        </div>
                    </x-table-data>
                </x-table-row>
            @empty
                <x-table-empty rows="5" />
            @endforelse
        </x-table>
    </div>
    <x-modal.card title="{{ $this->getModalTitle() }}"
        wire:model.defer="modal.show">
        <form class="gap-3 sm:grid sm:grid-cols-1">
            @csrf
            <x-input label="Type Name"
                wire:model.defer="form.name"
                placeholder="Type Name" />
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
