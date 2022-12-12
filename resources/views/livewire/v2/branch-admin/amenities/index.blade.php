<div x-data
    class="grid space-y-4">
    {{-- bulk actions --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="mt-1 flex space-x-2 sm:flex-none">
            <x-my.button-primary label="Add New"
                wire:click="create">
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
            <x-my.table.head name="Amount" />
            <x-my.table.head name="" />
        </x-slot>
        @forelse ($amenities as $amenity)
            <tr>
                <x-my.table.cell>
                    {{ $amenity->name }}
                </x-my.table.cell>
                <x-my.table.cell> ₱ {{ $amenity->price }} </x-my.table.cell>
                <x-my.table.cell>
                    <div class="flex justify-end space-x-2 px-2">
                        <x-my.edit-button wire:click="edit({{ $amenity->id }})" />
                        <span class="text-gray-600">|</span>
                        <x-my.delete-button
                            x-on:click="$dispatch('confirm',{
                            title : 'Are you sure?',
                            message : 'This action cannot be undone.',
                            confirmButtonText : 'Continue', 
                            cancelButtonText : 'No', 
                            confirmMethod : 'deleteAmenity',
                            'confirmParams' : {{ $amenity->id }}
                            })" />
                    </div>
                </x-my.table.cell>
            </tr>
        @empty
            <x-my.table.empty span="3" />
        @endforelse
        <x-slot name="footer">
            {{ $amenities->links() }}
        </x-slot>
    </x-my.table>

    {{-- modal --}}

    <div wire:key="modals-amenity">
        <form wire:submit.prevent="save">
            @csrf
            <x-my.modal title="{{ $editMode ? 'Edit Amenity' : 'Create Amenity' }}"
                :showOn="['show-modal']"
                :closeOn="['close-modal']">
                <div class="grid space-y-4">
                    <x-my.input label="Name"
                        wire:model.defer="form.name"
                        required />
                    <x-my.input label="Amount"
                        numberOnly
                        wire:model.defer="form.price"
                        required />
                </div>
                <x-slot name="footer">
                    <div class="flex items-center space-x-3">
                        <x-my.button-secondary x-on:click="close()"
                            label="Cancel" />
                        <x-my.button-success type="submit"
                            loadingOn="save"
                            label="Cancel" />
                    </div>
                </x-slot>
            </x-my.modal>
        </form>
    </div>

</div>
