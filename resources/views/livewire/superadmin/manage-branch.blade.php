<div x-data="{branch: @entangle('branchModal')}">
    <div class="fixed right-20 bottom-20">
        <x-button.circle x-on:click="branch = true"  xl positive icon="plus" />
    </div>
    <div class="mt-5 mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($branches as $branch)
                <li class="col-span-1 divide-y divide-gray-200 rounded-xl bg-white shadow-lg">
                    <div class="flex w-full items-center justify-between space-x-6 p-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="truncate font-semibold text-blue-700">{{ $branch->name }}</h3>

                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4 fill-green-600">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M11 17.938A8.001 8.001 0 0 1 12 2a8 8 0 0 1 1 15.938v2.074c3.946.092 7 .723 7 1.488 0 .828-3.582 1.5-8 1.5s-8-.672-8-1.5c0-.765 3.054-1.396 7-1.488v-2.074zM12 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12zm0-4a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
                                </svg>
                                <p class="text-gray-500 text-sm truncate">{{ $branch->address }}</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-7 w-7 fill-green-700">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M22 21H2v-2h1V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2zm-5-2h2v-8h-6v8h2v-6h2v6zm0-10V5H5v14h6V9h6zM7 11h2v2H7v-2zm0 4h2v2H7v-2zm0-8h2v2H7V7z" />
                        </svg>
                    </div>
                    <div>
                        <div class="-mt-px p-3 flex divide-x divide-gray-200">
                            <div class="w-full grid place-content-center">
                                <a href="{{route('superadmin.manage-branch', ['id' => $branch->id])}}" target="_blank"
                                    class="flex space-x-1 items-center text-green-600 fill-green-600 hover:text-green-700 hover:fill-green-700">
                                    <span class="text-sm font-semibold">Manage</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M10 6v2H5v11h11v-5h2v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6zm11-3v8h-2V6.413l-7.793 7.794-1.414-1.414L17.585 5H13V3h8z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
            <span class="text-white">No Branch Available for now...</span>
            @endforelse

            <!-- More people... -->
        </ul>
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
                    class="flex w-full transform text-left text-base transition md:my-8 md:max-w-xl md:px-4 lg:max-w-2xl">
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
                            <div class="sm:col-span-8 lg:col-span-7">
                                <h2 class="text-2xl font-bold text-gray-700 sm:pr-12">Add Branch </h2>

                                <section aria-labelledby="information-heading" class="mt-3">
                                    <h3 id="information-heading" class="sr-only">Product information</h3>

                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700">Name</label>
                                        <div class="mt-1">
                                            <input type="text" wire:model.lazy="name"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        @error('name')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
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

                                <section aria-labelledby="options-heading" class="mt-10">
                                    <h3 id="options-heading" class="sr-only">Product options</h3>
                                    <div class="flex justify-end">
                                        <x-button wire:click="createBranch" spinner="createBranch" md positive
                                            class="font-semibold" icon="save" label="Save" />
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
