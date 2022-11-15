@props(['title' => null])

@extends('layouts.master')

@section('content')
    <div>
        <div class="relative z-40 md:hidden"
            role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
            <div class="fixed inset-0 z-40 flex">
                <div class="relative flex w-full max-w-xs flex-1 flex-col bg-white">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button"
                            class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Close sidebar</span>
                            <!-- Heroicon name: outline/x-mark -->
                            <svg class="h-6 w-6 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="h-0 flex-1 overflow-y-auto pt-5 pb-4">
                        <div class="flex flex-shrink-0 items-center px-4">
                            <img class="h-8 w-auto"
                                src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                                alt="Your Company">
                        </div>
                        <nav class="mt-5 space-y-1 px-2">
                            <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                            <a href="#"
                                class="group flex items-center rounded-md bg-gray-100 px-2 py-1.5 text-base font-medium text-gray-900">
                                <!--
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      Heroicon name: outline/home
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -->
                                <svg class="mr-4 h-6 w-6 flex-shrink-0 text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Dashboard
                            </a>

                            <a href="#"
                                class="group flex items-center rounded-md px-2 py-1.5 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                <!-- Heroicon name: outline/users -->
                                <svg class="mr-4 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                Team
                            </a>

                            <a href="#"
                                class="group flex items-center rounded-md px-2 py-1.5 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                <!-- Heroicon name: outline/folder -->
                                <svg class="mr-4 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                </svg>
                                Projects
                            </a>

                            <a href="#"
                                class="group flex items-center rounded-md px-2 py-1.5 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                <!-- Heroicon name: outline/calendar -->
                                <svg class="mr-4 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                Calendar
                            </a>

                            <a href="#"
                                class="group flex items-center rounded-md px-2 py-1.5 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                <!-- Heroicon name: outline/inbox -->
                                <svg class="mr-4 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
                                </svg>
                                Documents
                            </a>

                            <a href="#"
                                class="group flex items-center rounded-md px-2 py-1.5 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                <!-- Heroicon name: outline/chart-bar -->
                                <svg class="mr-4 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                                Reports
                            </a>
                        </nav>
                    </div>
                    <div class="flex flex-shrink-0 border-t border-gray-200 p-4">
                        <a href="#"
                            class="group block flex-shrink-0">
                            <div class="flex items-center">
                                <div>
                                    <img class="inline-block h-10 w-10 rounded-full"
                                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                </div>
                                <div class="ml-3">
                                    <p class="text-base font-medium text-gray-700 group-hover:text-gray-900">Tom Cook</p>
                                    <p class="text-sm font-medium text-gray-500 group-hover:text-gray-700">View profile</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="w-14 flex-shrink-0">
                    <!-- Force sidebar to shrink to fit close icon -->
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
            <div class="flex min-h-0 flex-1 flex-col bg-white shadow-md">
                <div class="flex flex-1 flex-col overflow-y-auto pt-5 pb-10">
                    <div class="flex flex-shrink-0 items-center px-4">
                        <img class="h-8 w-auto"
                            src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                            alt="Your Company">
                    </div>
                    <nav class="mt-5 grid space-y-2 bg-white px-2">
                        <div class="flex-1 space-y-1 rounded-lg bg-blue-100 px-3 pt-3 pb-3">
                            <div>
                                <h1 class="text-blue-700">
                                    Overview
                                </h1>
                            </div>
                            <a href="{{ route('re-branch-admin.dashboard') }}"
                                class="group flex items-center rounded-md bg-blue-700 px-2 py-1.5 text-sm font-medium text-white hover:bg-blue-600">
                                <svg class="mr-3 h-6 w-6 flex-shrink-0"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('re-branch-admin.guests') }}"
                                class="group flex items-center rounded-md bg-blue-700 px-2 py-1.5 text-sm font-medium text-white hover:bg-blue-600">
                                <svg class="mr-3 h-6 w-6 flex-shrink-0"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.753 2c1.158 0 2.111.875 2.234 2h1.763a2.25 2.25 0 0 1 2.245 2.096L20 6.25v13.505a2.25 2.25 0 0 1-2.096 2.244l-.154.006H6.25a2.25 2.25 0 0 1-2.245-2.096L4 19.755V6.25a2.25 2.25 0 0 1 2.096-2.245L6.25 4h1.763a2.247 2.247 0 0 1 2.234-2h3.506Zm0 4.493h-3.506c-.777 0-1.461-.393-1.865-.992L6.25 5.5a.75.75 0 0 0-.743.648L5.5 6.25v13.505c0 .38.282.693.648.743l.102.007h11.5a.75.75 0 0 0 .743-.649l.007-.101V6.25a.75.75 0 0 0-.648-.743L17.75 5.5h-2.132a2.244 2.244 0 0 1-1.865.993Zm.997 7.502c.69 0 1.25.56 1.25 1.25v.5c0 1.846-1.472 2.754-4 2.754s-4-.909-4-2.756v-.498c0-.69.56-1.25 1.25-1.25h5.5Zm-2.75-6a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM13.753 3.5h-3.506a.747.747 0 1 0 0 1.493h3.506a.747.747 0 1 0 0-1.493Z"
                                        fill="#ffffff" />
                                </svg>
                                Guests
                            </a>
                        </div>
                        {{-- ----------------------------------------------------- --}}
                        <div class="flex-1 space-y-1 rounded-lg bg-yellow-100 px-3 pt-3 pb-3">
                            <div>
                                <h1 class="text-yellow-700">
                                    Manage
                                </h1>
                            </div>
                            <a href="{{ route('re-branch-admin.types') }}"
                                class="group flex items-center rounded-md bg-yellow-600 px-2 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="mr-3 h-6 w-6 flex-shrink-0 fill-white"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11 4h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6h-4v-4h4v4zM17 3c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zM7 13c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z">
                                    </path>
                                </svg>
                                Types
                            </a>
                            <a href="{{ route('re-branch-admin.rates') }}"
                                class="group flex items-center rounded-md bg-yellow-600 px-2 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="mr-3 h-6 w-6 flex-shrink-0 fill-white">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                                Rates
                            </a>

                            <a href="{{ route('re-branch-admin.floors') }}"
                                class="group flex items-center rounded-md bg-yellow-600 px-2 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"class="mr-3 h-6 w-6 flex-shrink-0">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                                Floors
                            </a>

                            <a href="{{ route('re-branch-admin.rooms') }}"
                                class="group flex items-center rounded-md bg-yellow-600 px-2 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                <svg class="mr-3 h-6 w-6 flex-shrink-0 fill-white"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m10.821 2.003.1.017 8.5 2a.75.75 0 0 1 .572.627L20 4.75v14.5a.75.75 0 0 1-.48.7l-.098.03-8.5 2a.75.75 0 0 1-.915-.628L10 21.25V2.75a.75.75 0 0 1 .723-.75l.098.003Zm.679 1.694v16.606l7-1.647V5.344l-7-1.647ZM9 4v1.5H5.5v13H9V20H4.75a.75.75 0 0 1-.743-.648L4 19.25V4.75a.75.75 0 0 1 .648-.743L4.75 4H9Zm5 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2Z"
                                        fill="#ffffff" />
                                </svg>
                                Rooms
                            </a>
                            <a href="{{ route('re-branch-admin.users') }}"
                                class="group flex items-center rounded-md bg-yellow-600 px-2 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="mr-3 h-6 w-6 flex-shrink-0 text-white">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                Users
                            </a>
                            <a href="{{ route('re-branch-admin.discounts') }}"
                                class="group flex items-center rounded-md bg-yellow-600 px-2 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="mr-3 h-6 w-6 flex-shrink-0 text-white">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                </svg>
                                Discounts
                            </a>
                            <a href="{{ route('re-branch-admin.extensions') }}"
                                class="group flex items-center rounded-md bg-yellow-600 px-2 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="mr-3 h-6 w-6 flex-shrink-0 fill-white">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                                Extension Rates
                            </a>
                            <a href="{{ route('re-branch-admin.charges-for-damages') }}"
                                class="group flex items-center rounded-md bg-yellow-600 px-2 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="mr-3 h-6 w-6 flex-shrink-0 text-white">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                                Charges for Damages
                            </a>
                            <a href="{{ route('re-branch-admin.amenities') }}"
                                class="group flex items-center rounded-md bg-yellow-600 px-2 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                <svg class="mr-3 h-6 w-6 flex-shrink-0 fill-white"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-7.498c.198-.474.34-.977.422-1.5H20a.5.5 0 0 0 .5-.5V6a.5.5 0 0 0-.5-.5H7.5v5.576A6.554 6.554 0 0 0 6 11.02V5.5H4a.5.5 0 0 0-.5.5v5.732A6.517 6.517 0 0 0 2 12.81V6Z"
                                        fill="#ffffff" />
                                    <path
                                        d="M12 7a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-4Zm4 1.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5V9a.5.5 0 0 1 .5-.5h4ZM6.5 12a5.5 5.5 0 1 1 0 11 5.5 5.5 0 0 1 0-11Zm.501 8.503V18h2.496a.5.5 0 0 0 0-1H7v-2.5a.5.5 0 1 0-1 0V17H3.496a.5.5 0 0 0 0 1H6v2.503a.5.5 0 1 0 1 0Z"
                                        fill="#ffffff" />
                                </svg>

                                Amenities
                            </a>
                        </div>
                        {{-- ------------------ --}}
                        <div class="flex-1 space-y-1 rounded-lg bg-green-100 px-3 pt-3 pb-3">
                            <div>
                                <h1 class="text-green-700">
                                    Front Desk Actions
                                </h1>
                            </div>
                            <a href="#"
                                class="group flex items-center rounded-md bg-green-700 px-2 py-1.5 text-sm font-medium text-white hover:bg-green-600">
                                <svg class="mr-3 h-6 w-6 flex-shrink-0"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Check In
                            </a>
                            <a href="#"
                                class="group flex items-center rounded-md bg-green-700 px-2 py-1.5 text-sm font-medium text-white hover:bg-green-600">
                                <svg class="mr-3 h-6 w-6 flex-shrink-0"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.753 2c1.158 0 2.111.875 2.234 2h1.763a2.25 2.25 0 0 1 2.245 2.096L20 6.25v13.505a2.25 2.25 0 0 1-2.096 2.244l-.154.006H6.25a2.25 2.25 0 0 1-2.245-2.096L4 19.755V6.25a2.25 2.25 0 0 1 2.096-2.245L6.25 4h1.763a2.247 2.247 0 0 1 2.234-2h3.506Zm0 4.493h-3.506c-.777 0-1.461-.393-1.865-.992L6.25 5.5a.75.75 0 0 0-.743.648L5.5 6.25v13.505c0 .38.282.693.648.743l.102.007h11.5a.75.75 0 0 0 .743-.649l.007-.101V6.25a.75.75 0 0 0-.648-.743L17.75 5.5h-2.132a2.244 2.244 0 0 1-1.865.993Zm.997 7.502c.69 0 1.25.56 1.25 1.25v.5c0 1.846-1.472 2.754-4 2.754s-4-.909-4-2.756v-.498c0-.69.56-1.25 1.25-1.25h5.5Zm-2.75-6a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM13.753 3.5h-3.506a.747.747 0 1 0 0 1.493h3.506a.747.747 0 1 0 0-1.493Z"
                                        fill="#ffffff" />
                                </svg>
                                Check Out
                            </a>
                            <a href="#"
                                class="group flex items-center rounded-md bg-green-700 px-2 py-1.5 text-sm font-medium text-white hover:bg-green-600">
                                <svg class="mr-3 h-6 w-6 flex-shrink-0"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.753 2c1.158 0 2.111.875 2.234 2h1.763a2.25 2.25 0 0 1 2.245 2.096L20 6.25v13.505a2.25 2.25 0 0 1-2.096 2.244l-.154.006H6.25a2.25 2.25 0 0 1-2.245-2.096L4 19.755V6.25a2.25 2.25 0 0 1 2.096-2.245L6.25 4h1.763a2.247 2.247 0 0 1 2.234-2h3.506Zm0 4.493h-3.506c-.777 0-1.461-.393-1.865-.992L6.25 5.5a.75.75 0 0 0-.743.648L5.5 6.25v13.505c0 .38.282.693.648.743l.102.007h11.5a.75.75 0 0 0 .743-.649l.007-.101V6.25a.75.75 0 0 0-.648-.743L17.75 5.5h-2.132a2.244 2.244 0 0 1-1.865.993Zm.997 7.502c.69 0 1.25.56 1.25 1.25v.5c0 1.846-1.472 2.754-4 2.754s-4-.909-4-2.756v-.498c0-.69.56-1.25 1.25-1.25h5.5Zm-2.75-6a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM13.753 3.5h-3.506a.747.747 0 1 0 0 1.493h3.506a.747.747 0 1 0 0-1.493Z"
                                        fill="#ffffff" />
                                </svg>
                                Transactions
                            </a>
                            <a href="#"
                                class="group flex items-center rounded-md bg-green-700 px-2 py-1.5 text-sm font-medium text-white hover:bg-green-600">
                                <svg class="mr-3 h-6 w-6 flex-shrink-0"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.753 2c1.158 0 2.111.875 2.234 2h1.763a2.25 2.25 0 0 1 2.245 2.096L20 6.25v13.505a2.25 2.25 0 0 1-2.096 2.244l-.154.006H6.25a2.25 2.25 0 0 1-2.245-2.096L4 19.755V6.25a2.25 2.25 0 0 1 2.096-2.245L6.25 4h1.763a2.247 2.247 0 0 1 2.234-2h3.506Zm0 4.493h-3.506c-.777 0-1.461-.393-1.865-.992L6.25 5.5a.75.75 0 0 0-.743.648L5.5 6.25v13.505c0 .38.282.693.648.743l.102.007h11.5a.75.75 0 0 0 .743-.649l.007-.101V6.25a.75.75 0 0 0-.648-.743L17.75 5.5h-2.132a2.244 2.244 0 0 1-1.865.993Zm.997 7.502c.69 0 1.25.56 1.25 1.25v.5c0 1.846-1.472 2.754-4 2.754s-4-.909-4-2.756v-.498c0-.69.56-1.25 1.25-1.25h5.5Zm-2.75-6a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM13.753 3.5h-3.506a.747.747 0 1 0 0 1.493h3.506a.747.747 0 1 0 0-1.493Z"
                                        fill="#ffffff" />
                                </svg>
                                Room Monitoring
                            </a>
                            <a href="#"
                                class="group flex items-center rounded-md bg-green-700 px-2 py-1.5 text-sm font-medium text-white hover:bg-green-600">
                                <svg class="mr-3 h-6 w-6 flex-shrink-0"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.753 2c1.158 0 2.111.875 2.234 2h1.763a2.25 2.25 0 0 1 2.245 2.096L20 6.25v13.505a2.25 2.25 0 0 1-2.096 2.244l-.154.006H6.25a2.25 2.25 0 0 1-2.245-2.096L4 19.755V6.25a2.25 2.25 0 0 1 2.096-2.245L6.25 4h1.763a2.247 2.247 0 0 1 2.234-2h3.506Zm0 4.493h-3.506c-.777 0-1.461-.393-1.865-.992L6.25 5.5a.75.75 0 0 0-.743.648L5.5 6.25v13.505c0 .38.282.693.648.743l.102.007h11.5a.75.75 0 0 0 .743-.649l.007-.101V6.25a.75.75 0 0 0-.648-.743L17.75 5.5h-2.132a2.244 2.244 0 0 1-1.865.993Zm.997 7.502c.69 0 1.25.56 1.25 1.25v.5c0 1.846-1.472 2.754-4 2.754s-4-.909-4-2.756v-.498c0-.69.56-1.25 1.25-1.25h5.5Zm-2.75-6a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM13.753 3.5h-3.506a.747.747 0 1 0 0 1.493h3.506a.747.747 0 1 0 0-1.493Z"
                                        fill="#ffffff" />
                                </svg>
                                Room Priority
                            </a>
                        </div>
                        {{-- ------------------------------- --}}
                        <div class="flex-1 space-y-1 rounded-lg bg-red-100 px-3 pt-3 pb-3">
                            <div>
                                <h1 class="text-red-700">
                                    Housekeeping Actions
                                </h1>
                            </div>
                            <a href="#"
                                class="group flex items-center rounded-md bg-red-700 px-2 py-1.5 text-sm font-medium text-white hover:bg-red-600">
                                <svg class="mr-3 h-6 w-6 flex-shrink-0"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Room Boy Designation
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="flex flex-1 flex-col md:pl-64">
            <div class="sticky top-0 z-10 bg-gray-100 pt-1 pl-1 sm:pl-3 sm:pt-3 md:hidden">
                <button type="button"
                    class="-ml-0.5 -mt-0.5 inline-flex h-12 w-12 items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open sidebar</span>
                    <!-- Heroicon name: outline/bars-3 -->
                    <svg class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <main class="flex-1">
                <div class="py-6">
                    <div class="sticky top-6 z-40 mx-auto max-w-7xl rounded-lg bg-white p-2 shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg class="h-10 fill-gray-700"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM11 15a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM9 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM8 15a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM18 15a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM17 19a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" />
                                    <path
                                        d="M8.25 2.002a.75.75 0 0 0-.75.75V5H6.25a.75.75 0 0 0-.75.75V7.8A2.75 2.75 0 0 0 4 10.25v10.5c0 .415.336.75.75.75h15a.75.75 0 0 0 .75-.75v-5a5.75 5.75 0 0 0-5.51-5.745 2.751 2.751 0 0 0-1.487-2.203V5.75a.75.75 0 0 0-.75-.75H11.5V2.752a.75.75 0 0 0-.75-.75h-2.5ZM12.003 7.5H7v-1h5.003v1ZM13.5 20H12v-2.75a.75.75 0 0 0-.75-.75h-3.5a.75.75 0 0 0-.75.75V20H5.5v-9.75C5.5 9.56 6.06 9 6.75 9h5.5c.69 0 1.25.56 1.25 1.25V20Zm-5 0v-2h2v2h-2Zm6.5 0v-8.492c2.23.129 4 1.979 4 4.242V20h-4ZM10 5H9V3.502h1V5Z" />
                                </svg>
                                <h1 class="text-xl font-semibold text-gray-700">
                                    {{ auth()->user()->branch_name }}
                                </h1>
                            </div>
                            <div class="item-center flex space-x-3">
                                <x-quick-menu />
                            </div>
                        </div>
                    </div>
                    <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 md:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            {{ $title }}
                        </h1>
                    </div>
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 md:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
