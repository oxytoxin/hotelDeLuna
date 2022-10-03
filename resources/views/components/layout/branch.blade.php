<!-- This example requires Tailwind CSS v2.0+ -->
<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-100">
  <body class="h-full">
  ```
-->
<div>
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div class="relative z-40 md:hidden"
        role="dialog"
        aria-modal="true">
        <!--
      Off-canvas menu backdrop, show/hide based on off-canvas menu state.

      Entering: "transition-opacity ease-linear duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "transition-opacity ease-linear duration-300"
        From: "opacity-100"
        To: "opacity-0"
    -->
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

        <div class="fixed inset-0 z-40 flex">
            <!--
        Off-canvas menu, show/hide based on off-canvas menu state.

        Entering: "transition ease-in-out duration-300 transform"
          From: "-translate-x-full"
          To: "translate-x-0"
        Leaving: "transition ease-in-out duration-300 transform"
          From: "translate-x-0"
          To: "-translate-x-full"
      -->
            <div class="relative flex flex-col flex-1 w-full max-w-xs bg-white">
                <!--
          Close button, show/hide based on off-canvas menu state.

          Entering: "ease-in-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in-out duration-300"
            From: "opacity-100"
            To: "opacity-0"
        -->
                <div class="absolute top-0 right-0 pt-2 -mr-12">
                    <button type="button"
                        class="flex items-center justify-center w-10 h-10 ml-1 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <!-- Heroicon name: outline/x-mark -->
                        <svg class="w-6 h-6 text-white"
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

                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <img class="w-auto h-8"
                            src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                            alt="Your Company">
                    </div>
                    <nav class="px-2 mt-5 space-y-1">
                        <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                        <a href="#"
                            class="flex items-center px-2 py-2 text-base font-medium text-gray-900 bg-gray-100 rounded-md group">
                            <!--
                Heroicon name: outline/home

                Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500"
              -->
                            <svg class="flex-shrink-0 w-6 h-6 mr-4 text-gray-500"
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
                            class="flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 group">
                            <!-- Heroicon name: outline/users -->
                            <svg class="flex-shrink-0 w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500"
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
                            class="flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 group">
                            <!-- Heroicon name: outline/folder -->
                            <svg class="flex-shrink-0 w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500"
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
                            class="flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 group">
                            <!-- Heroicon name: outline/calendar -->
                            <svg class="flex-shrink-0 w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500"
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
                            class="flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 group">
                            <!-- Heroicon name: outline/inbox -->
                            <svg class="flex-shrink-0 w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500"
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
                            class="flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 group">
                            <!-- Heroicon name: outline/chart-bar -->
                            <svg class="flex-shrink-0 w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500"
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
                <div class="flex flex-shrink-0 p-4 border-t border-gray-200">
                    <a href="#"
                        class="flex-shrink-0 block group">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block w-10 h-10 rounded-full"
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

            <div class="flex-shrink-0 w-14">
                <!-- Force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
        <div class="flex flex-col flex-1 min-h-0 bg-white shadow-md">
            <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
                <div class="flex items-center justify-center flex-shrink-0 px-4">
                    <h1 class="text-center text-gray-600">
                        APP_NAME
                    </h1>
                </div>
                <nav class="flex-1 px-2 pt-5 mt-5  bg-white border-t">
                    <a href="{{ route('branch.dashboard') }}"
                        @class([
                            'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                            'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                'branch/dashboard*'
                            ),
                            'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                'branch/dashboard*'
                            ),
                        ])>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="flex-shrink-0 w-6 h-6 mr-3 ">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('branch.guests') }}"
                        @class([
                            'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                            'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                'branch/guests*'
                            ),
                            'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                'branch/guests*'
                            ),
                        ])>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="flex-shrink-0 w-6 h-6 mr-3 ">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                        Guests
                    </a>
                    <div>
                        <div class="text-gray-800  font-semibold p-2 w-full flex justify-between items-center">
                            <h1> Manage</h1>
                        </div>
                        <a href="{{ route('branch.manage-types') }}"
                            @class([
                                'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                                'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                    'branch/manage-types*'
                                ),
                                'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                    'branch/manage-types*'
                                ),
                            ])>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="flex-shrink-0 w-6 h-6 mr-3 ">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                            </svg>
                            Types
                        </a>
                        <a href="{{ route('branch.manage-rates') }}"
                            @class([
                                'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                                'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                    'branch/manage-rates*'
                                ),
                                'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                    'branch/manage-rates*'
                                ),
                            ])>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="flex-shrink-0 w-6 h-6 mr-3 ">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                            </svg>
                            Rates
                        </a>
                        <a href="{{ route('branch.manage-rooms') }}"
                            @class([
                                'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                                'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                    'branch/manage-rooms*'
                                ),
                                'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                    'branch/manage-rooms*'
                                ),
                            ])>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="flex-shrink-0 w-6 h-6 mr-3 ">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                            </svg>

                            Rooms
                        </a>
                        <a href="{{ route('branch.manage-users') }}"
                            @class([
                                'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                                'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                    'branch/manage-users*'
                                ),
                                'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                    'branch/manage-users*'
                                ),
                            ])>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="flex-shrink-0 w-6 h-6 mr-3 ">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            Users
                        </a>
                        <a href="{{ route('branch.discounts') }}"
                            @class([
                                'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                                'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                    'branch/manage-branch-discounts*'
                                ),
                                'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                    'branch/manage-branch-discounts*'
                                ),
                            ])>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="flex-shrink-0 w-6 h-6 mr-3 ">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                            </svg>
                            Discounts
                        </a>
                        <a href="{{ route('branch.extension-amounts') }}"
                            @class([
                                'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                                'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                    'branch/extension-amounts*'
                                ),
                                'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                    'branch/extension-amounts*'
                                ),
                            ])>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="flex-shrink-0 w-6 h-6 mr-3 ">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Extenstion Amounts
                        </a>
                        <a href="{{ route('branch.charges-on-stain-and-damages') }}"
                            @class([
                                'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                                'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                    'branch/charges-on-stain-and-damages*'
                                ),
                                'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                    'branch/charges-on-stain-and-damages*'
                                ),
                            ])>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="flex-shrink-0 w-6 h-6 mr-3 ">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                            Additional Charges
                        </a>
                        <a href="{{ route('branch.manage-requestable-items') }}"
                            @class([
                                'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                                'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                    'branch/manage-requestable-items*'
                                ),
                                'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                    'branch/manage-requestable-items*'
                                ),
                            ])>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="flex-shrink-0 w-6 h-6 mr-3 ">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                            Requestable Items
                        </a>
                    </div>
                </nav>
                <nav class="flex-1 px-2 pt-2 mt-2  bg-white border-t">
                    <div class="text-gray-800  font-semibold p-2 w-full flex justify-between items-center">
                        <h1>Front Desk Actions</h1>
                    </div>
                    <a href="{{ route('branch.check-in') }}"
                        @class([
                            'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                            'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                'branch/check-in*'
                            ),
                            'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                'branch/check-in*'
                            ),
                        ])>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="flex-shrink-0 w-6 h-6 mr-3 ">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                        </svg>
                        Check In
                    </a>
                    <a href="{{ route('branch.check-out') }}"
                        @class([
                            'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                            'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                'branch/check-out*'
                            ),
                            'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                'branch/check-out*'
                            ),
                        ])>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="flex-shrink-0 w-6 h-6 mr-3 ">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                        </svg>

                        Check Out
                    </a>
                    <a href="{{ route('branch.guest-transaction') }}"
                        @class([
                            'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                            'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                'branch/guest-transaction*'
                            ),
                            'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                'branch/guest-transaction*'
                            ),
                        ])>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="flex-shrink-0 w-6 h-6 mr-3 ">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>

                        Guest Transaction
                    </a>
                    <a href="{{ route('branch.room-monitoring') }}"
                        @class([
                            'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                            'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                'branch/room-monitoring*'
                            ),
                            'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                'branch/room-monitoring*'
                            ),
                        ])>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="flex-shrink-0 w-6 h-6 mr-3 ">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>

                        Room Monitoring
                    </a>


                </nav>
                <nav class="flex-1 px-2 pt-2 mt-2  bg-white border-t">
                    <div class="text-gray-800  font-semibold p-2 w-full flex justify-between items-center">
                        <h1>House Keeping</h1>
                    </div>
                    <a href="{{ route('branch.room-boy-designations') }}"
                        @class([
                            'group flex items-center px-2 py-2 text-sm font-medium rounded-lg',
                            'text-white bg-primary-500 hover:text-gray-50' => request()->is(
                                'branch/room-boy-designations*'
                            ),
                            'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->is(
                                'branch/room-boy-designations*'
                            ),
                        ])>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="flex-shrink-0 w-6 h-6 mr-3 ">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                        </svg>
                        Designations
                    </a>
                </nav>
            </div>
        </div>
    </div>
    <div class="flex flex-col flex-1 md:pl-64">
        <div class="sticky top-0 z-10 pt-1 pl-1 bg-gray-100 sm:pl-3 sm:pt-3 md:hidden">
            <button type="button"
                class="-ml-0.5 -mt-0.5 inline-flex h-12 w-12 items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6"
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
            <div x-data="{ scrollTop: 0 }"
                x-on:scroll.window="scrollTop = window.scrollY"
                x-bind:class="scrollTop > 0 ? 'backdrop-blur-sm shadow-md' : ''"
                x-init="scrollTop = window.scrollY"
                class="sticky top-0 z-50">
                <div class="sticky top-0 flex justify-between px-4 py-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 text-gray-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                        <h1 class="text-xl font-semibold text-gray-700">
                            {{ auth()->user()->branch_name }}
                        </h1>
                    </div>
                    <div>
                        <x-quick-menu />
                    </div>
                </div>
            </div>
            {{ $slot }}
        </main>
    </div>
</div>
