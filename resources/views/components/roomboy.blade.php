<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ALMA RESIDENCES | Room Boy</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;600;700&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @wireUiScripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Styles -->
   
    @livewireStyles
</head>

<body class="font-rubik antialiased" x-data="{logout:false, confirm:false}">
  <x-notifications z-index="z-50" />
  <x-dialog z-index="z-50"
      blur="sm"
      align="center" />
    <div class="min-h-full">
        <header class="bg-gradient-to-r from-gray-800 to-gray-600 pb-24">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="relative flex flex-wrap items-center justify-center lg:justify-between">
                    <!-- Logo -->
                    <div class="absolute left-0 flex-shrink-0 py-5 lg:static">
                        <a href="#">
                            <span class="sr-only">Your Company</span>
                            <div class="flex relative items-end space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-10 fill-white">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M17 19h2v-8h-6v8h2v-6h2v6zM3 19V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2H2v-2h1zm4-8v2h2v-2H7zm0 4v2h2v-2H7zm0-8v2h2V7H7z" />
                                </svg>
                                <h1 class="text-white lg:text-2xl text-lg font-bold">{{ auth()->user()->branch->name }}</h1>

                            </div>
                        </a>
                    </div>

                    <!-- Right section on desktop -->
                    <div class="hidden lg:ml-4 lg:flex lg:items-center relative lg:py-5 lg:pr-0.5" >
                      <div class="relative inline-block px-3 text-left">
                        <div>
                          <button x-on:click="logout = !logout"  type="button" class="group w-full rounded-md  px-3.5 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-100 hover:bg-opacity-50 focus:outline-none" id="options-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="flex w-full items-center justify-between">
                              <span class="flex min-w-0 items-center justify-between space-x-3">
                                <img class="h-10 w-10 flex-shrink-0 rounded-full border-2 border-green-500 bg-gray-300" src="{{auth()->user()->profile_photo_url}}" alt="">
                                <span class="flex min-w-0 flex-1 flex-col">
                                  <span class="truncate text-sm font-medium text-white">{{auth()->user()->name}}</span>
                                  <span class="truncate text-sm text-gray-500">{{auth()->user()->email}}</span>
                                </span>
                              </span>
                              <!-- Heroicon name: mini/chevron-up-down -->
                              <svg class="h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
                              </svg>
                            </span>
                          </button>
                        </div>
                
                        <!--
                          Dropdown menu, show/hide based on menu state.
                
                          Entering: "transition ease-out duration-100"
                            From: "transform opacity-0 scale-95"
                            To: "transform opacity-100 scale-100"
                          Leaving: "transition ease-in duration-75"
                            From: "transform opacity-100 scale-100"
                            To: "transform opacity-0 scale-95"
                        -->
                        <div x-show="logout" x-cloak  x-on:click.away="logout = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 left-0 z-10 mx-3 mt-1 origin-top divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu-button" tabindex="-1">
                        
                          <div class="py-1" role="none">
                            <a x-on:click="confirm = true" class="text-gray-700 cursor-pointer hover:text-green-800 px-4 py-2 text-sm flex items-center space-x-1" role="menuitem" tabindex="-1" id="options-menu-item-5 "><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            <span class="font-semibold">Logout</span></a>
                          </div>
                        </div>
                    </div>
                    <div class="h-20 lg:h-8 w-full"></div>

                    <!-- Menu button -->
                    <div class="absolute right-0 flex-shrink-0 lg:hidden">
                        <!-- Mobile menu button -->
                        <button type="button"
                            class="inline-flex items-center justify-center rounded-md bg-transparent p-2 text-cyan-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                            aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="rotate-90 fill-white" width="24"
                                height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M5 11h8v2H5v3l-5-4 5-4v3zm-1 7h2.708a8 8 0 1 0 0-12H4A9.985 9.985 0 0 1 12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.985 9.985 0 0 1-8-4z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <main class="-mt-24 pb-8">
            {{$slot}}
        </main>
        <footer>
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="border-t border-gray-200 py-8 text-center text-sm text-gray-500 sm:text-left"><span
                        class="block sm:inline">&copy; 2022 J7 IT SOLUTIONS & SERVICES</span> <span
                        class="block sm:inline">All rights reserved.</span></div>
            </div>
        </footer>
    </div>

    <div x-show="confirm" x-cloak class="relative z-10" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">

    <div x-show="confirm" x-cloak x-transacion:enter="ease-out duration-300" x-transacion:enter-start="opacity-0"
        x-transacion:enter-end="opacity-100" x-transacion:leave="ease-in duration-200"
        x-transacion:leave-start="opacity-100" x-transacion:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            <div x-show="confirm" x-cloak x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm   sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Heroicon name: outline/exclamation-triangle -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            class="h-6 w-6 fill-red-700">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zM7 11V8l-5 4 5 4v-3h8v-2H7z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Logout
                            account</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Are you sure you want to logout your account?</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <form method="POST" action="{{ route('logout') }}" role="none">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
        this.closest('form').submit();"
                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Logout</a>
                    </form>
                    <button x-on:click="logout=false"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
   
    @livewireScripts
</body>

</html>
