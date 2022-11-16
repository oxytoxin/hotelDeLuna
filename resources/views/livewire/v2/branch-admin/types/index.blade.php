<div x-data
    class="grid space-y-4">

    {{-- bulk actions --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="mt-1 flex space-x-2 sm:flex-none">
            <x-my.button-primary wire:click="create"
                label="Add New">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </x-slot>
            </x-my.button-primary>
        </div>
        <div class="flex">
            <x-my.input.search wire:model.debounce="search" />
        </div>
    </div>
    {{-- table --}}
    <x-my.table>
        <x-slot name="header">
            <x-my.table.head name="Name" />
            <x-my.table.head name="" />
        </x-slot>
        @forelse ($types as $type)
            <tr>
                <x-my.table.cell>{{ $type->name }}</x-my.table.cell>
                <x-my.table.cell>
                    <div class="flex justify-end">
                        <x-my.edit-button wire:click="edit({{ $type->id }})" />
                    </div>
                </x-my.table.cell>
            </tr>
        @empty
            <x-my.table.empty span="2" />
        @endforelse
        <x-slot name="footer">
            {{ $types->links() }}
        </x-slot>
    </x-my.table>

    {{-- modals --}}

    <div>
        <form wire:submit.prevent="save">
            @csrf
            <x-my.modal title="{{ $editMode ? 'Edit Type' : 'Create Type' }}"
                :showOn="['show-create-modal', 'show-edit-modal']"
                :closeOn="['close-create-modal', 'close-edit-modal']">
                <div>
                    <x-my.input label="Name"
                        wire:model.defer="form.name"
                        required />
                </div>
                <x-slot name="footer">
                    <div class="flex space-x-3">
                        <x-my.button-secondary x-on:click="close"
                            label="Cancel" />
                        <x-my.button-success type="submit"
                            loadingOn="save"
                            label="Save" />
                    </div>
                </x-slot>
            </x-my.modal>
        </form>
    </div>
</div>
