<div x-data="{ branch: @entangle('addBranchModal'), deleteModal: false }">
    <div class="mt-5 mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-white sm:truncate sm:text-3xl sm:tracking-tight">
                    {{ $branches->name }}</h2>
                <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-yellow-400 fill-yellow-500">

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
            </div>
        </div>

        <div class="mt-5">
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                <select id="tabs" name="tabs"
                    class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    <option>Applied</option>

                    <option>Phone Screening</option>

                    <option selected>Interview</option>

                    <option>Offer</option>

                    <option>Disqualified</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent cursor-pointer text-gray-500 hover:text-gray-700 hover:border-green-600" -->


                        <button wire:click="$set('tab', 'users')"
                            class="{{ $tab == 'users' ? 'border-green-600 font-semibold text-green-600' : '' }} border-transparent cursor-pointer text-gray-500 hover:text-gray-700 hover:border-green-600 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm">
                            Users
                            <span
                                class="bg-gray-100 text-gray-700 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">{{$total_users}}</span>
                        </button>
                        <button wire:click="$set('tab', 'rooms')"
                            class="{{ $tab == 'rooms' ? 'border-green-600 font-semibold text-green-600' : '' }} border-transparent cursor-pointer text-gray-500 hover:text-gray-700 hover:border-green-600 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm">
                            Rooms
                            <span
                                class="bg-gray-100 text-gray-700 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">{{$total_rooms}}</span>
                        </button>
                        <button wire:click="$set('tab', 'rates')"
                            class="{{ $tab == 'rates' ? 'border-green-600 font-semibold text-green-600' : '' }} border-transparent cursor-pointer text-gray-500 hover:text-gray-700 hover:border-green-600 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm">
                            Rates
                            <span
                                class="bg-gray-100 text-gray-700 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">{{$total_rates}}</span>
                        </button>
                        <button wire:click="$set('tab', 'types')"
                            class="{{ $tab == 'types' ? 'border-green-600 font-semibold text-green-600' : '' }} border-transparent cursor-pointer text-gray-500 hover:text-gray-700 hover:border-green-600 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm">
                            Types
                            <span
                                class="bg-gray-100 text-gray-700 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">{{$total_types}}</span>
                        </button>

                    </nav>

                </div>
                <div class="mt-5">
                    @switch($tab)
                        @case('users')
                            @livewire('superadmin.branch-user', ['branch' => $branches->id])
                            @break
                        @case('rooms')
                        @livewire('superadmin.branch-room', ['branch' => $branches->id])
                            @break
                        @case('rates')
                        @livewire('superadmin.branch-rate', ['branch' => $branches->id])
                            @break
                        @case('types')
                        @livewire('superadmin.branch-type', ['branch' => $branches->id])
                            @break
                        @default
                    @endswitch
                    </div>
                </div>
            </div>


        </div>

        {{-- <div x-show="branch" x-cloak class="relative z-10" role="dialog" aria-modal="true">
           
            <div x-show="branch" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">
              
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
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
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
                                    @default
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        
    </div>
