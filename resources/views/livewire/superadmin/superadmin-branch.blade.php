<div x-data="{ branch: @entangle('addBranchModal'), deleteModal: false }">
    <div class="mt-5 mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-white sm:truncate sm:text-3xl sm:tracking-tight">
                    {{ $branches->name }}</h2>
                <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-yellow-400 fill-yellow-500">
                        <!-- Heroicon name: mini/briefcase -->
                        {{-- <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M6 3.75A2.75 2.75 0 018.75 1h2.5A2.75 2.75 0 0114 3.75v.443c.572.055 1.14.122 1.706.2C17.053 4.582 18 5.75 18 7.07v3.469c0 1.126-.694 2.191-1.83 2.54-1.952.599-4.024.921-6.17.921s-4.219-.322-6.17-.921C2.694 12.73 2 11.665 2 10.539V7.07c0-1.321.947-2.489 2.294-2.676A41.047 41.047 0 016 4.193V3.75zm6.5 0v.325a41.622 41.622 0 00-5 0V3.75c0-.69.56-1.25 1.25-1.25h2.5c.69 0 1.25.56 1.25 1.25zM10 10a1 1 0 00-1 1v.01a1 1 0 001 1h.01a1 1 0 001-1V11a1 1 0 00-1-1H10z" clip-rule="evenodd" />
                    <path d="M3 15.055v-.684c.126.053.255.1.39.142 2.092.642 4.313.987 6.61.987 2.297 0 4.518-.345 6.61-.987.135-.041.264-.089.39-.142v.684c0 1.347-.985 2.53-2.363 2.686a41.454 41.454 0 01-9.274 0C3.985 17.585 3 16.402 3 15.055z" />
                  </svg> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-5 w-5 flex-shrink-0 ">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M11 17.938A8.001 8.001 0 0 1 12 2a8 8 0 0 1 1 15.938v2.074c3.946.092 7 .723 7 1.488 0 .828-3.582 1.5-8 1.5s-8-.672-8-1.5c0-.765 3.054-1.396 7-1.488v-2.074zM12 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                        </svg>
                        {{ $branches->address }}
                    </div>

                </div>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <span class="hidden sm:block">
                    <x-button class="font-semibold" wire:click="editBranch" white icon="pencil-alt"
                        label="EDIT BRANCH" />
                </span>

                <span class="ml-3 hidden sm:block">
                    <x-button wire:click="addUser" class="font-semibold" positive icon="plus-circle" label="ADD USER" />
                </span>
            </div>
        </div>

        <div class="mt-10">
            <div class="border-b border-gray-200 bg-white ">
                <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                    <div class="ml-4 mt-4">
                        <h3 class="text-xl font-bold leading-6 text-gray-700">BRANCH USERS</h3>
                        <p class="mt-1 text-sm text-gray-500">A list of all users in {{ $branches->name }}</p>
                    </div>
                    <div class="ml-4 mt-4 flex-shrink-0">
                        <div class="flex border items-center px-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-gray-500"
                                width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z" />
                            </svg>
                            <input type="text" wire:model="search_user" placeholder="Search user..."
                                class="border-0 focus:outline focus:ring-0">
                        </div>
                    </div>
                </div>
            </div>
            <!-- This example requires Tailwind CSS v2.0+ -->
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 mt-5 lg:grid-cols-5">
                @forelse ($users as $user)
                    <li
                        class="col-span-1 flex flex-col relative  rounded-2xl py-3 border bg-white text-center shadow-lg">
                        <div class="absolute h-10 top-2 right-2 rounded-full w-10">
                            <x-button.circle wire:click="editUser({{ $user->id }})" sm positive primary
                                icon="pencil" />
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            {{-- <img class="mx-auto h-32 w-32 flex-shrink-0 rounded-full"
                        src="https://scontent.fmnl9-3.fna.fbcdn.net/v/t39.30808-1/290217300_2684378598359678_6265156717532339991_n.jpg?stp=dst-jpg_p200x200&_nc_cat=100&ccb=1-7&_nc_sid=7206a8&_nc_eui2=AeHrBPQhN4qthVLuyPLqHBe0kClqsy4loX-QKWqzLiWhf5C5i8MM2TYb1X9L4rrIzmFoAAUU0aGJdiPUTsEzWezg&_nc_ohc=EZrWvslkKgsAX9oeMvq&_nc_ht=scontent.fmnl9-3.fna&oh=00_AT9oddBCT9lrqRGht1JwMOu7pW13R8GL4Pl4oGootFEvHw&oe=632C3AF5"
                        alt=""> --}}
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
                                            <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-green-900">
                                                {{ $user->role->name }}</span>
                                        @break

                                        @case(3)
                                            <span class="rounded-full bg-cyan-100 px-2 py-1 text-xs font-medium text-green-900">
                                                {{ $user->role->name }}</span>
                                        @break

                                        @case(4)
                                            <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-green-900">
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
                    @endforelse

                    <!-- More people... -->
                </ul>
                <div class="div mt-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        <div x-show="branch" x-cloak class="relative z-10" role="dialog" aria-modal="true">
            <!--
                Background backdrop, show/hide based on modal state.
            
                Entering: "ease-out duration-300"
                  From: "opacity-0"
                  To: "opacity-100"
                Leaving: "ease-in duration-200"
                  From: "opacity-100"
                  To: "opacity-0"
              -->
            <div x-show="branch" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">
                    <!--
                    Modal panel, show/hide based on modal state.
            
                    Entering: "ease-out duration-300"
                      From: "opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                      To: "opacity-100 translate-y-0 md:scale-100"
                    Leaving: "ease-in duration-200"
                      From: "opacity-100 translate-y-0 md:scale-100"
                      To: "opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                  -->
                    <div x-show="branch" x-cloak x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 md:scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 md:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                        class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">
                        <div
                            class="relative flex w-full items-center overflow-hidden bg-white px-4 pt-14 pb-8 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                            <button type="button" x-on:click="branch = false"
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8">
                                <span class="sr-only">Close</span>
                                <!-- Heroicon name: outline/x-mark -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <div class="grid w-full grid-cols-1 items-start gap-y-8 gap-x-6 sm:grid-cols-12 lg:gap-x-8">
                                <div class="sm:col-span-4 lg:col-span-5">
                                    <div class="aspect-w-1 aspect-h-1 overflow-hidden rounded-lg relative bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            class="absolute left-5 top-4 h-10 fill-yellow-400">
                                            <path fill="none" d="M0 0h24v24H0z" />
                                            <path
                                                d="M9.822 2.238a9 9 0 0 0 11.94 11.94C20.768 18.654 16.775 22 12 22 6.477 22 2 17.523 2 12c0-4.775 3.346-8.768 7.822-9.762zm8.342.053L19 2.5v1l-.836.209a2 2 0 0 0-1.455 1.455L16.5 6h-1l-.209-.836a2 2 0 0 0-1.455-1.455L13 3.5v-1l.836-.209A2 2 0 0 0 15.29.836L15.5 0h1l.209.836a2 2 0 0 0 1.455 1.455zm5 5L24 7.5v1l-.836.209a2 2 0 0 0-1.455 1.455L21.5 11h-1l-.209-.836a2 2 0 0 0-1.455-1.455L18 8.5v-1l.836-.209a2 2 0 0 0 1.455-1.455L20.5 5h1l.209.836a2 2 0 0 0 1.455 1.455z" />
                                        </svg>
                                        <div class="grid place-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                class="h-96 fill-gray-700">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M22 21H2v-2h1V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2zm-5-2h2v-8h-6v8h2v-6h2v6zm0-10V5H5v14h6V9h6zM7 11h2v2H7v-2zm0 4h2v2H7v-2zm0-8h2v2H7V7z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                @switch($modal)
                                    @case('branch')
                                        <div class="sm:col-span-8 lg:col-span-7">
                                            <h2 class="text-2xl font-bold text-gray-700 sm:pr-12">Edit Branch Information</h2>

                                            <section aria-labelledby="information-heading" class="mt-3">
                                                <h3 id="information-heading" class="sr-only">Product information</h3>

                                                <div>
                                                    <label for="email"
                                                        class="block text-sm font-medium text-gray-700">Name</label>
                                                    <div class="mt-1">
                                                        <input type="text" wire:model="name"
                                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <label for="comment"
                                                        class="block text-sm font-medium text-gray-700">Address</label>
                                                    <div class="mt-1">
                                                        <textarea rows="4" wire:model="address"
                                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                                    </div>
                                                </div>
                                            </section>

                                            <section aria-labelledby="options-heading" class="mt-6">
                                                <h3 id="options-heading" class="sr-only">Product options</h3>




                                                <div class="mt-6">
                                                    {{-- <button type="submit"
                                                      class="flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 py-3 px-8 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Update</button> --}}
                                                    <x-button wire:click="updateBranch" class="w-full font-semibold" lg
                                                        icon="save-as" positive label="Update" />
                                                </div>

                                                <p class="absolute top-4 left-4 text-center sm:static sm:mt-6">
                                                    <button wire:click="deleteDialog"
                                                        class="font-medium text-red-600 hover:text-red-500">Delete Branch</button>
                                                </p>

                                            </section>

                                        </div>
                                    @break

                                    @case('users')
                                        <div class="sm:col-span-8 lg:col-span-7">
                                            <h2 class="text-2xl font-bold text-gray-700 sm:pr-12">Add Branch Users</h2>

                                            <section aria-labelledby="information-heading" class="mt-3">
                                                <h3 id="information-heading" class="sr-only">Product information</h3>

                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="email"
                                                            class="block text-sm font-medium text-gray-700">Name</label>
                                                        <div class="mt-1">
                                                            <input type="text" wire:model.lazy="user_name"
                                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>
                                                        @error('user_name')
                                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="email"
                                                            class="block text-sm font-medium text-gray-700">Email</label>
                                                        <div class="mt-1">
                                                            <input type="text" wire:model.lazy="user_email"
                                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>
                                                        @error('user_email')
                                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="email"
                                                            class="block text-sm font-medium text-gray-700">Password</label>
                                                        <div class="mt-1">
                                                            <input type="password" wire:model.lazy="user_password"
                                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>
                                                        @error('user_password')
                                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="location"
                                                            class="block text-sm font-medium text-gray-700">Role</label>
                                                        <select wire:model.lazy="user_role"
                                                            class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                            @endforeach

                                                        </select>
                                                        @error('user_role')
                                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </section>

                                            <section aria-labelledby="options-heading" class="mt-10">
                                                <h3 id="options-heading" class="sr-only">Product options</h3>
                                                <div class="flex justify-end">
                                                    <x-button wire:click="saveUsers" spinner="saveUsers" md positive
                                                        class="font-semibold" icon="save" label="Save" />
                                                </div>
                                            </section>
                                        </div>
                                    @break

                                    @case('edit_users')
                                        <div class="sm:col-span-8 lg:col-span-7">
                                            <h2 class="text-2xl font-bold text-gray-700 sm:pr-12">Edit Branch Users</h2>

                                            <section aria-labelledby="information-heading" class="mt-3">
                                                <h3 id="information-heading" class="sr-only">Product information</h3>

                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="email"
                                                            class="block text-sm font-medium text-gray-700">Name</label>
                                                        <div class="mt-1">
                                                            <input type="text" wire:model.lazy="user_name"
                                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>
                                                        @error('user_name')
                                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="email"
                                                            class="block text-sm font-medium text-gray-700">Email</label>
                                                        <div class="mt-1">
                                                            <input type="text" wire:model.lazy="user_email"
                                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>
                                                        @error('user_email')
                                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="email"
                                                            class="block text-sm font-medium text-gray-700">Password</label>
                                                        <div class="mt-1">
                                                            <input type="password" wire:model.lazy="user_password"
                                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>
                                                        @error('user_password')
                                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label for="location"
                                                            class="block text-sm font-medium text-gray-700">Role</label>
                                                        <select wire:model.lazy="user_role"
                                                            class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                            @endforeach

                                                        </select>
                                                        @error('user_role')
                                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </section>

                                            <section aria-labelledby="options-heading" class="mt-10">
                                                <h3 id="options-heading" class="sr-only">Product options</h3>
                                                <div class="flex justify-end">
                                                    <x-button wire:click="updateUser" spinner="updateUser" md positive
                                                        class="font-semibold" icon="save" label="Update" />
                                                </div>
                                            </section>
                                        </div>
                                    @break

                                    @default
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div x-show="deleteModal" x-cloak class="relative z-10" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <!--
                Background backdrop, show/hide based on modal state.
            
                Entering: "ease-out duration-300"
                  From: "opacity-0"
                  To: "opacity-100"
                Leaving: "ease-in duration-200"
                  From: "opacity-100"
                  To: "opacity-0"
              -->
            <div x-show="deleteModal" x-cloak x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
            </div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!--
                    Modal panel, show/hide based on modal state.
            
                    Entering: "ease-out duration-300"
                      From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                      To: "opacity-100 translate-y-0 sm:scale-100"
                    Leaving: "ease-in duration-200"
                      From: "opacity-100 translate-y-0 sm:scale-100"
                      To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                  -->
                    <div x-show="deleteModal" x-cloak x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                        <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                            <button type="button"
                                class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <span class="sr-only">Close</span>
                                <!-- Heroicon name: outline/x-mark -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Heroicon name: outline/exclamation-triangle -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-red-600">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-7v2h2v-2h-2zm2-1.645A3.502 3.502 0 0 0 12 6.5a3.501 3.501 0 0 0-3.433 2.813l1.962.393A1.5 1.5 0 1 1 12 11.5a1 1 0 0 0-1 1V14h2v-.645z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-700" id="modal-title">Delete Branch
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to delete this branch? </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button type="button"
                                class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Delete</button>
                            <button type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
