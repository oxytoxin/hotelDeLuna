<div>
    <div class="">
        <div class="border-b border-gray-200 bg-white ">
            <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                <div class="ml-4 mt-4">
                    <h3 class="text-xl font-bold leading-6 text-gray-700">BRANCH USERS</h3>
                    <p class="mt-1 text-sm text-gray-500">A list of all users in
                    </p>
                </div>
                <div class="ml-4 mt-4 flex-shrink-0">
                    <div class="flex justify-between space-x-1 items-center">
                        <div class="flex border items-center px-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                class="fill-gray-500" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z" />
                            </svg>
                            <input type="text" wire:model="search_user"
                                placeholder="Search user..."
                                class="border-0 focus:outline focus:ring-0">
                        </div>
                        <x-button wire:click="$set('branch_modal', true)" class="font-semibold"
                            positive md label="+" />
                    </div>
                </div>
            </div>
        </div>
        <ul role="list"
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 mt-5 lg:grid-cols-5">
            @forelse ($users as $key => $user)
                <li 
                    class="col-span-1 flex flex-col relative  rounded-2xl py-3 border bg-white text-center shadow-lg">
                    <div class="absolute h-10 top-2 right-2 rounded-full w-10">
                        <x-button.circle wire:key="{{$key}}"  spinner="editUser({{ $user->id }})" wire:click="editUser({{ $user->id }})" sm positive
                            primary icon="pencil" />
                    </div>
                    <div class="flex flex-1 flex-col p-5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            class="mx-auto h-24 w-24 flex-shrink-0 fill-gray-700">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path d="M5 20h14v2H5v-2zm7-2a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                        </svg>
                        <h3 class="mt-5 font-semibold text-gray-600">{{ $user->name }}</h3>
                        <dl class="mt-1 flex flex-grow flex-col justify-between">

                            <dt class="sr-only">Role</dt>
                            <dd class="mt-1">
                                @switch($user->role_id)
                                    @case(1)
                                        <span
                                            class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-900">
                                            {{ $user->role->name }}</span>
                                    @break

                                    @case(2)
                                        <span
                                            class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-green-900">
                                            {{ $user->role->name }}</span>
                                    @break

                                    @case(3)
                                        <span
                                            class="rounded-full bg-cyan-100 px-2 py-1 text-xs font-medium text-green-900">
                                            {{ $user->role->name }}</span>
                                    @break

                                    @case(4)
                                        <span
                                            class="rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-green-900">
                                            {{ $user->role->name }}</span>
                                    @break

                                    @case(6)
                                        <span
                                            class="rounded-full bg-yellow-200 px-2 py-1 text-xs font-medium text-green-900">
                                            {{ $user->role->name }}</span>
                                    @break

                                    @case(5)
                                        <span
                                            class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-green-900">
                                            {{ $user->role->name }}</span>
                                    @break

                                    @default
                                @endswitch
                            </dd>
                        </dl>
                    </div>

                </li>
                @empty
                <div class="w-full col-span-5 flex justify-center items-center">
                    <p class="text-center text-gray-500">No users found</p>
                </div>
                @endforelse
            </ul>
            <div class="div mt-5">
                {{ $users->links() }}
            </div>
        </div>
        <div wire:key="branchModal">
            @if ($modal_edit == false)
                <x-modal.card title="Add New Branch" blur wire:model.defer="branch_modal">
                    <div class="grid grid-cols-2 gap-4">
                        <x-input label="Name" wire:model="user_name" />
                        <x-input label="Email" wire:model="user_email" />
                        <x-inputs.password label="Password" wire:model="user_password" />
                        <x-native-select label="Select Role" wire:model="user_role">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </x-native-select>
                    </div>
                    <x-slot:footer>
                        <div class="flex justify-end w-full space-x-2">
                            <x-button positive wire:click="saveUsers">Save</x-button>
                            <x-button wire:click="$set('branch_modal', false)" default>Cancel</x-button>
                        </div>
                    </x-slot:footer>
                </x-modal.card>
            @else
                <x-modal.card title="Edit Branch"  wire:model.defer="branch_modal">
                    <div class="grid grid-cols-2 gap-4">
                        <x-input label="Name" wire:model="user_name" />
                        <x-input label="Email" wire:model="user_email" />
                        <x-inputs.password label="Password" wire:model="user_password" />
                        <x-native-select label="Select Role" wire:model="user_role">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </x-native-select>
                    </div>
                    <x-slot:footer>
                        <div class="flex justify-end w-full space-x-2">
                            <x-button positive spinner="updateUser" wire:click="updateUser">Update</x-button>
                            <x-button wire:click="$set('branch_modal', false)" default>Cancel</x-button>
                        </div>
                    </x-slot:footer>
                </x-modal.card>
            @endif
        </div> 
        
</div>
