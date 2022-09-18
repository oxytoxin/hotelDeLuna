<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ALMA RESIDENCES | SUPERADMIN</title>

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

<body class="font-rubik antialiased">
    <x-notifications z-index="z-50"/>
    <x-dialog z-index="z-50" blur="md" align="center" />
    <!--
  This example requires Tailwind CSS v2.0+
  
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  const colors = require('tailwindcss/colors')
  
  module.exports = {
    // ...
    theme: {
      extend: {
        colors: {
          sky: colors.sky,
          teal: colors.teal,
          cyan: colors.cyan,
          rose: colors.rose,
        },
      },
    },
    plugins: [
      // ...
      require('@tailwindcss/forms'),
      require('@tailwindcss/line-clamp'),
    ],
  }
  ```
-->
    <!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-100">
  <body class="h-full">
  ```
-->
    <div class="min-h-full">
        <header class="bg-gradient-to-r from-gray-800 to-gray-600 pb-24">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                class="h-40 fill-white opacity-25 -left-10 top-10 absolute">
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                    d="M17 19h2v-8h-6v8h2v-6h2v6zM3 19V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2H2v-2h1zm4-8v2h2v-2H7zm0 4v2h2v-2H7zm0-8v2h2V7H7z" />
            </svg>
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
                                <h1 class="text-white text-2xl font-bold">HOTEL [hotel_name]</h1>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    class="absolute -left-6 fill-yellow-300 top-0 h-5">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M9.822 2.238a9 9 0 0 0 11.94 11.94C20.768 18.654 16.775 22 12 22 6.477 22 2 17.523 2 12c0-4.775 3.346-8.768 7.822-9.762zm8.342.053L19 2.5v1l-.836.209a2 2 0 0 0-1.455 1.455L16.5 6h-1l-.209-.836a2 2 0 0 0-1.455-1.455L13 3.5v-1l.836-.209A2 2 0 0 0 15.29.836L15.5 0h1l.209.836a2 2 0 0 0 1.455 1.455zm5 5L24 7.5v1l-.836.209a2 2 0 0 0-1.455 1.455L21.5 11h-1l-.209-.836a2 2 0 0 0-1.455-1.455L18 8.5v-1l.836-.209a2 2 0 0 0 1.455-1.455L20.5 5h1l.209.836a2 2 0 0 0 1.455 1.455z" />
                                </svg>
                            </div>
                        </a>
                    </div>

                    <!-- Right section on desktop -->
                    <div class="hidden lg:ml-4 lg:flex lg:items-center lg:py-5 lg:pr-0.5">
                        <button type="button"
                            class="flex-shrink-0 rounded-full p-1 text-cyan-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                            <span class="sr-only">View notifications</span>
                            <!-- Heroicon name: outline/bell -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>

                        <!-- Profile dropdown -->
                        <div class="relative ml-4 flex-shrink-0" x-data="{ dropdown: false }">
                            <div>
                                <button type="button" x-on:click="dropdown = !dropdown"
                                    class="flex rounded-full bg-white text-sm ring-2 ring-green-500 ring-opacity-20 focus:outline-none focus:ring-opacity-100"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        class="h-8 fill-gray-600">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zM7 12a5 5 0 0 0 10 0h-2a3 3 0 0 1-6 0H7z" />
                                    </svg>
                                </button>
                            </div>

                            <!--
                Dropdown menu, show/hide based on menu state.
  
                Entering: ""
                  From: ""
                  To: ""
                Leaving: "transition ease-in duration-75"
                  From: "transform opacity-100 scale-100"
                  To: "transform opacity-0 scale-95"
              -->
                            <div x-show="dropdown" x-cloak x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute -right-2 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">

                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-2">Sign out</a>
                            </div>
                        </div>
                    </div>

                    <div class="w-full py-5 lg:border-t lg:border-white lg:border-opacity-20">
                        <div class="lg:grid lg:grid-cols-3 lg:items-center lg:gap-8">
                            <!-- Left nav -->
                            <div class="hidden lg:col-span-2 lg:block">
                                <nav class="flex space-x-4">
                                    <a href="{{route('superadmin.dashboard')}}"
                                        class="{{Request::routeIs('superadmin.dashboard') ? 'bg-white bg-opacity-10 text-green-400' : ' bg-white hover:text-white bg-opacity-0 hover:bg-opacity-10 text-gray-300 '}} text-sm font-semibold rounded-md  px-3 py-2 "
                                        aria-current="page">Home</a>
                                    <a href="{{route('superadmin.branch')}}"
                                        class="{{Request::routeIs('superadmin.branch') || Request::routeIs('superadmin.manage-branch') ? 'bg-white bg-opacity-10 text-green-400' : ' bg-white hover:text-white bg-opacity-0 hover:bg-opacity-10 text-gray-300 '}} text-sm font-semibold rounded-md  px-3 py-2 "
                                        aria-current="page">Branches</a>
                                    <a href="{{route('superadmin.settings')}}"
                                        class="{{Request::routeIs('superadmin.settings') ? 'bg-white bg-opacity-10 text-green-400' : ' bg-white hover:text-white bg-opacity-0 hover:bg-opacity-10 text-gray-300 '}} text-sm font-semibold rounded-md  px-3 py-2 "
                                        aria-current="page">Settings</a>

                                   

                                </nav>
                            </div>

                        </div>
                    </div>

                    <!-- Menu button -->
                    <div class="absolute right-0 flex-shrink-0 lg:hidden">
                        <!-- Mobile menu button -->
                        <button type="button"
                            class="inline-flex items-center justify-center rounded-md bg-transparent p-2 text-cyan-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                            aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!--
                Heroicon name: outline/bars-3
  
                Menu open: "hidden", Menu closed: "block"
              -->
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!--
                Heroicon name: outline/x-mark
  
                Menu open: "block", Menu closed: "hidden"
              -->
                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on mobile menu state. -->
            {{-- <div class="lg:hidden">
                <!--
          Mobile menu overlay, show/hide based on mobile menu state.
  
          Entering: "duration-150 ease-out"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "duration-150 ease-in"
            From: "opacity-100"
            To: "opacity-0"
        -->
                <div class="fixed inset-0 z-20 bg-black bg-opacity-25" aria-hidden="true"></div>

                <!--
          Mobile menu, show/hide based on mobile menu state.
  
          Entering: "duration-150 ease-out"
            From: "opacity-0 scale-95"
            To: "opacity-100 scale-100"
          Leaving: "duration-150 ease-in"
            From: "opacity-100 scale-100"
            To: "opacity-0 scale-95"
        -->
                <div
                    class="absolute inset-x-0 top-0 z-30 mx-auto w-full max-w-3xl origin-top transform p-2 transition">
                    <div
                        class="divide-y divide-gray-200 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <div class="pt-3 pb-2">
                            <div class="flex items-center justify-between px-4">
                                <div>
                                    <img class="h-8 w-auto"
                                        src="https://tailwindui.com/img/logos/mark.svg?color=cyan&shade=600"
                                        alt="Your Company">
                                </div>
                                <div class="-mr-2">
                                    <button type="button"
                                        class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500">
                                        <span class="sr-only">Close menu</span>
                                        <!-- Heroicon name: outline/x-mark -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1 px-2">
                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Home</a>

                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Profile</a>

                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Resources</a>

                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Company
                                    Directory</a>

                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Openings</a>
                            </div>
                        </div>
                        <div class="pt-4 pb-2">
                            <div class="flex items-center px-5">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                        src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <div class="truncate text-base font-medium text-gray-800">Chelsea Hagon</div>
                                    <div class="truncate text-sm font-medium text-gray-500">chelsea.hagon@example.com
                                    </div>
                                </div>
                                <button type="button"
                                    class="ml-auto flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                                    <span class="sr-only">View notifications</span>
                                    <!-- Heroicon name: outline/bell -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-3 space-y-1 px-2">
                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Your
                                    Profile</a>

                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Settings</a>

                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Sign
                                    out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </header>
        <main class="-mt-24 pb-8">
            {{$slot}}
        </main>
        <footer>
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="border-t border-gray-200 py-8 text-center text-sm text-gray-500 sm:text-left"><span
                        class="block sm:inline">&copy; 2021 Your Company, Inc.</span> <span
                        class="block sm:inline">All rights reserved.</span></div>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>

</html>
