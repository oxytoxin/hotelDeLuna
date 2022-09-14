<div>
    @php
        $headers = ['Name', 'Email', 'Role', ''];
    @endphp
    <div class="mt-5">
        <div class="flex flex-col">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <div class="flex justify-between px-2 py-3 bg-white border-b border-gray-200 sm:px-6">
                            <div class="flex space-x-2">
                                <x-input icon="search"
                                    wire:model.debounce.500ms="search"
                                    placeholder="Search..." />
                                <x-native-select wire:model.debounce="filter">
                                    <option value="all">All</option>
                                    @foreach ($roles as $key => $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </x-native-select>
                            </div>
                            <div>
                                <x-button primary
                                    wire:click="add"
                                    label="Add User" />
                            </div>
                        </div>
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    @foreach ($headers as $header)
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">
                                            {{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr>
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $user->role->name }}
                                        </td>
                                        <td
                                            class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                            <button wire:key="{{ $user->id }}"
                                                wire:click="edit({{ $user->id }})"
                                                wire:loading.class="cursor-progress"
                                                wire:loading.attr="disabled"
                                                wire:target="edit({{ $user->id }})"
                                                class="uppercase text-primary-600 hover:text-primary-900">Edit</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            No User Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="py-2">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  --}}
    <div wire:key="modal-panel">
        <x-modal.card title="{{ $this->getModeTitle() }}"
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
                <x-button primary
                    wire:click="save"
                    spinner="save"
                    label="Save" />
            </x-slot:footer>
        </x-modal.card>
    </div>
</div>
