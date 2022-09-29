<div>
    <div>
        <x-table :headers="['Name', 'Email', 'Role', '']">
            <x-slot:topLeft>
                <x-input icon="search"
                    wire:model.debounce.500ms="search"
                    placeholder="Search..." />
                <x-native-select wire:model.debounce="filter">
                    <option value="all">All</option>
                    @foreach ($roles as $key => $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </x-native-select>
            </x-slot:topLeft>
            <x-slot:topRight>
                <x-button primary
                    wire:click="add"
                    label="Add User" />
            </x-slot:topRight>
            @forelse ($users as $user)
                <x-table-row>
                    <x-table-data>
                        {{ $user->name }}
                    </x-table-data>
                    <x-table-data>
                        {{ $user->email }}
                    </x-table-data>
                    <x-table-data>
                        {{ $user->role->name }}
                    </x-table-data>
                    <x-table-data>
                        <div class="flex justify-end px-2">
                            <x-actions.edit wire:key="{{ $user->id }}"
                                wire:click="edit({{ $user->id }})"
                                wire:loading.class="cursor-progress"
                                wire:loading.attr="disabled"
                                wire:target="edit({{ $user->id }})" />
                        </div>
                    </x-table-data>
                </x-table-row>
            @empty
                <x-table-empty rows="4" />
            @endforelse
            <x-slot:pagination>
                {{ $users->links() }}
            </x-slot:pagination>
        </x-table>
    </div>


    {{--  --}}
    <div wire:key="modal-panel">
        <x-modal.card title="{{ $this->getModalTitle() }}"
            wire:model.defer="showModal">
            <form>
                @csrf
                <div class="gap-3 sm:grid sm:grid-cols-2">
                    <x-input label="Name"
                        wire:model.defer="name"
                        placeholder="Enter Name" />
                    <x-input label="Email"
                        wire:model.defer="email"
                        placeholder="Enter Email" />
                    @if ($mode == 'create')
                        <x-input label="Password"
                            type="password"
                            wire:model.defer="password"
                            placeholder="Enter Password" />
                    @endif
                    <x-native-select label="Role"
                        wire:model.defer="role_id">
                        <option value="">Select Role</option>
                        @foreach ($roles as $key => $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </x-native-select>
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
