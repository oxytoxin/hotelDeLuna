<div>
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="sr-only">Profile</h1>
        <!-- Main 3 column grid -->
        <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
            <!-- Left column -->
            <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                <!-- Welcome panel -->
                <section aria-labelledby="profile-overview-title">
                    <div class="overflow-hidden rounded-xl bg-white shadow">
                        <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
                        <div class="bg-white p-6">
                            <div class="sm:flex sm:items-center sm:justify-between">
                                <div class="sm:flex sm:space-x-5">
                                    <div class="flex-shrink-0">
                                        {{-- <img class="mx-auto h-20 w-20 rounded-full"
                                            src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                            alt=""> --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            class="h-20 fill-gray-700">
                                            <path fill="none" d="M0 0h24v24H0z" />
                                            <path d="M5 20h14v2H5v-2zm7-2a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                                        </svg>
                                    </div>
                                    <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                                        <p class="text-sm font-medium text-gray-600">Welcome back,</p>
                                        <p class="text-xl font-bold text-gray-700 uppercase sm:text-2xl">
                                            {{ auth()->user()->name }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-600">
                                            {{ auth()->user()->role->name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-5 flex justify-center sm:mt-0">
                                    <x-button href="" sm dark label="View Profile" />
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- Actions panel -->
                {{-- <section aria-labelledby="quick-links-title">
                    <div
                        class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-gray-200 shadow sm:grid sm:grid-cols-2 sm:gap-px sm:divide-y-0">
                        <h2 class="sr-only" id="quick-links-title">Quick links</h2>

                        <div
                            class="rounded-tl-lg rounded-tr-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                            <div>
                                <span
                                    class="rounded-lg inline-flex p-3 bg-teal-50 text-teal-700 ring-4 ring-white">
                                    <!-- Heroicon name: outline/clock -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-8">
                                <h3 class="text-lg font-medium">
                                    <a href="#" class="focus:outline-none">
                                        <!-- Extend touch target to entire panel -->
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Request time off
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">Doloribus dolores nostrum quia qui natus
                                    officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et
                                    molestiae.</p>
                            </div>
                            <span
                                class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                                aria-hidden="true">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                </svg>
                            </span>
                        </div>

                        <div
                            class="sm:rounded-tr-lg relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                            <div>
                                <span
                                    class="rounded-lg inline-flex p-3 bg-purple-50 text-purple-700 ring-4 ring-white">
                                    <!-- Heroicon name: outline/check-badge -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-8">
                                <h3 class="text-lg font-medium">
                                    <a href="#" class="focus:outline-none">
                                        <!-- Extend touch target to entire panel -->
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Benefits
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">Doloribus dolores nostrum quia qui natus
                                    officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et
                                    molestiae.</p>
                            </div>
                            <span
                                class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                                aria-hidden="true">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                </svg>
                            </span>
                        </div>

                        <div
                            class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                            <div>
                                <span
                                    class="rounded-lg inline-flex p-3 bg-sky-50 text-sky-700 ring-4 ring-white">
                                    <!-- Heroicon name: outline/users -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-8">
                                <h3 class="text-lg font-medium">
                                    <a href="#" class="focus:outline-none">
                                        <!-- Extend touch target to entire panel -->
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Schedule a one-on-one
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">Doloribus dolores nostrum quia qui natus
                                    officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et
                                    molestiae.</p>
                            </div>
                            <span
                                class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                                aria-hidden="true">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                </svg>
                            </span>
                        </div>

                        <div
                            class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                            <div>
                                <span
                                    class="rounded-lg inline-flex p-3 bg-yellow-50 text-yellow-700 ring-4 ring-white">
                                    <!-- Heroicon name: outline/banknotes -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-8">
                                <h3 class="text-lg font-medium">
                                    <a href="#" class="focus:outline-none">
                                        <!-- Extend touch target to entire panel -->
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Payroll
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">Doloribus dolores nostrum quia qui natus
                                    officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et
                                    molestiae.</p>
                            </div>
                            <span
                                class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                                aria-hidden="true">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                </svg>
                            </span>
                        </div>

                        <div
                            class="sm:rounded-bl-lg relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                            <div>
                                <span
                                    class="rounded-lg inline-flex p-3 bg-rose-50 text-rose-700 ring-4 ring-white">
                                    <!-- Heroicon name: outline/receipt-refund -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 9.75h4.875a2.625 2.625 0 010 5.25H12M8.25 9.75L10.5 7.5M8.25 9.75L10.5 12m9-7.243V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-8">
                                <h3 class="text-lg font-medium">
                                    <a href="#" class="focus:outline-none">
                                        <!-- Extend touch target to entire panel -->
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Submit an expense
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">Doloribus dolores nostrum quia qui natus
                                    officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et
                                    molestiae.</p>
                            </div>
                            <span
                                class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                                aria-hidden="true">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                </svg>
                            </span>
                        </div>

                        <div
                            class="rounded-bl-lg rounded-br-lg sm:rounded-bl-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                            <div>
                                <span
                                    class="rounded-lg inline-flex p-3 bg-indigo-50 text-indigo-700 ring-4 ring-white">
                                    <!-- Heroicon name: outline/academic-cap -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-8">
                                <h3 class="text-lg font-medium">
                                    <a href="#" class="focus:outline-none">
                                        <!-- Extend touch target to entire panel -->
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Training
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">Doloribus dolores nostrum quia qui natus
                                    officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et
                                    molestiae.</p>
                            </div>
                            <span
                                class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                                aria-hidden="true">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </section> --}}
            </div>

            <!-- Right column -->
            <div class="grid grid-cols-1 gap-4">
                <!-- Announcements -->
                <section aria-labelledby="announcements-title">
                    <div class="overflow-hidden ">
                        <div class="p-3">
                            <div class="flex space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    class="fill-white" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M21 20h2v2H1v-2h2V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v17zM8 11v2h3v-2H8zm0-4v2h3V7H8zm0 8v2h3v-2H8zm5 0v2h3v-2h-3zm0-4v2h3v-2h-3zm0-4v2h3V7h-3z" />
                                </svg>
                                <span class="text-lg font-bold text-white">ALL BRANCHES</span>
                            </div>
                            <div class="mt-6 flow-root">
                                @forelse ($branches as $branch)
                                <div class="bg-white mb-2 rounded-xl shadow-lg p-4 flex  justify-between">
                                    <div class="w-14">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            class="h-12 fill-gray-700">
                                            <path fill="none" d="M0 0h24v24H0z" />
                                            <path
                                                d="M17 19h2v-8h-6v8h2v-6h2v6zM3 19V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2H2v-2h1zm4-8v2h2v-2H7zm0 4v2h2v-2H7zm0-8v2h2V7H7z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 flex flex-col">
                                        <h1 class="font-semibold text-blue-700">{{$branch->name}}</h1>
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                               class="h-4 fill-green-600">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M11 17.938A8.001 8.001 0 0 1 12 2a8 8 0 0 1 1 15.938v2.074c3.946.092 7 .723 7 1.488 0 .828-3.582 1.5-8 1.5s-8-.672-8-1.5c0-.765 3.054-1.396 7-1.488v-2.074zM12 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12zm0-4a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
                                            </svg>
                                            <span class="text-sm text-gray-600">{{$branch->address}}</span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                    
                                @endforelse
                            </div>
                        </div>
                </section>

            </div>
        </div>
    </div>
</div>
