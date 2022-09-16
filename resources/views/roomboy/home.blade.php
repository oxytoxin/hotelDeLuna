@extends('layouts.master')

@section('content')
    <div>
        <div>
            <nav class="bg-gray-800">
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <h1 class="text-xl text-white">
                                    Alma Residences Gensan
                                </h1>
                            </div>
                        </div>
                        <div class="sm:ml-6 ">
                            <div x-data="{ isOpen: false }"
                                class="flex items-center">
                                <div class="relative ml-3">
                                    <div>
                                        <button x-on:click="isOpen=!isOpen"
                                            type="button"
                                            class="flex text-sm bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                                            id="user-menu-button"
                                            aria-expanded="false"
                                            aria-haspopup="true">
                                            <span class="sr-only">Open user menu</span>
                                            <img class="w-8 h-8 rounded-full"
                                                src="{{ auth()->user()->profile_photo_url }}"
                                                alt="">
                                        </button>
                                    </div>
                                    <div x-cloak
                                        x-show="isOpen"
                                        x-transition
                                        x-on:click.away="isOpen=false"
                                        class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        role="menu"
                                        aria-orientation="vertical"
                                        aria-labelledby="user-menu-button"
                                        tabindex="-1">
                                        <div x-data="{ logout: false }">
                                            <button x-on:click="logout=!logout"
                                                class="block px-4 py-2 text-sm text-gray-700"
                                                role="menuitem"
                                                tabindex="-1"
                                                id="user-menu-item-2">Sign out</button>
                                            <div x-cloak
                                                x-show="logout"
                                                class="relative z-50"
                                                aria-labelledby="modal-title"
                                                role="dialog"
                                                aria-modal="true">
                                                <div x-cloak
                                                    x-show="logout"
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="transition ease-in duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0"
                                                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75">
                                                </div>
                                                <div class="fixed inset-0 z-50 overflow-y-auto">
                                                    <div
                                                        class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                                                        <div x-cloak
                                                            x-show="logout"
                                                            x-transition:enter="transition ease-out duration-300"
                                                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                            x-transition:leave="transition ease-in duration-200"
                                                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                            class="relative z-50 px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-96 sm:max-w-lg sm:p-6">
                                                            <div class="sm:flex sm:items-start">
                                                                <div
                                                                    class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="w-6 h-6 text-red-600"
                                                                        fill="none"
                                                                        viewBox="0 0 24 24"
                                                                        stroke="currentColor"
                                                                        stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>
                                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                    <h3 class="text-lg font-medium leading-6 text-gray-900"
                                                                        id="modal-title">
                                                                        Logout
                                                                    </h3>
                                                                    <div class="mt-2">
                                                                        <p class="text-sm text-gray-500">
                                                                            Are you sure you want to logout?
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                                                <form method="POST"
                                                                    action="{{ route('logout') }}"
                                                                    x-data>
                                                                    @csrf
                                                                    <a href="{{ route('logout') }}"
                                                                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                                                        @click.prevent="$root.submit();">
                                                                        {{ __('Logout') }}
                                                                    </a>
                                                                </form>
                                                                <button type="button"
                                                                    x-on:click="logout=false"
                                                                    class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="max-w-5xl px-4 mx-auto mt-5 sm:px-6 lg:px-8">
            @livewire('room-boy.cleaning')
        </div>
    </div>
@endsection
