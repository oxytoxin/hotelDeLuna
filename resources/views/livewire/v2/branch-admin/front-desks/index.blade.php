<div x-data
    class="grid space-y-4">

    {{-- bulk actions --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="flex mt-1 space-x-2 sm:flex-none">
            <x-my.button-primary wire:click="create"
                label="Add New">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5">
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
            <x-my.table.head name="Number" />
            <x-my.table.head name="" />
        </x-slot>
        @forelse ($frontDesks as $frontDesk)
            <tr>
                <x-my.table.cell>{{ $frontDesk->name }}</x-my.table.cell>
                <x-my.table.cell>{{ $frontDesk->contact_number }}</x-my.table.cell>
                <x-my.table.cell>
                    <div class="flex justify-end space-x-3">
                        <x-my.edit-button wire:click="edit({{ $frontDesk->id }})" />
                    </div>
                </x-my.table.cell>
            </tr>
        @empty
            <x-my.table.empty span="3" />
        @endforelse
        <x-slot name="footer">
            {{ $frontDesks->links() }}
        </x-slot>
    </x-my.table>

    <div>
        <form wire:submit.prevent="save">
            @csrf
            <x-my.modal title="{{ $editMode ? 'Edit Front Desk' : 'Create Front Desk' }}"
                :showOn="['show-modal']"
                :closeOn="['close-modal']">
                <div class="grid space-y-4">
                    <x-my.input label="Name"
                        wire:model.defer="frontdesk.name"
                        required />
                    <x-my.input label="Contact Number"
                        wire:model.defer="frontdesk.contact_number"
                        required />
                </div>
                <x-slot name="footer">
                    <div class="flex items-center space-x-3">
                        <x-my.button-secondary x-on:click="close()"
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
