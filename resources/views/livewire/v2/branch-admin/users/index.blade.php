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
            <x-my.table.head name="Email" />
            <x-my.table.head name="Role" />
            <x-my.table.head name="" />
        </x-slot>
        @forelse ($users as $user)
            <tr>
                <x-my.table.cell>{{ $user->name }}</x-my.table.cell>
                <x-my.table.cell>{{ $user->email }}</x-my.table.cell>
                <x-my.table.cell>{{ $user->role->name }}</x-my.table.cell>
                <x-my.table.cell>
                    <div class="flex justify-end space-x-3">
                        <x-my.edit-button wire:click="edit({{ $user->id }})" />
                        <span class="text-gray-400">|</span>
                        <x-my.delete-button wire:click="delete({{ $user->id }})" />
                    </div>
                </x-my.table.cell>
            </tr>
        @empty
            <x-my.table.empty span="4" />
        @endforelse
        <x-slot name="footer">
            {{ $users->links() }}
        </x-slot>
    </x-my.table>

    <div>
        <form wire:submit.prevent="save">
            @csrf
            <x-my.modal title="{{ $editMode ? 'Edit User' : 'Create User' }}"
                :showOn="['show-modal']"
                :closeOn="['close-modal']">
                <div class="grid space-y-4">
                    <x-my.input label="Name"
                        wire:model.defer="name"
                        required />
                    <x-my.input label="Email"
                        wire:model.defer="email"
                        required />
                    @if ($editMode == false)
                        <x-my.input label="Password"
                            wire:model.defer="password"
                            type="password"
                            required />
                        <x-my.input.select label="Role"
                            wire:model.defer="role_id"
                            required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </x-my.input.select>
                    @endif
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
