<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>HOTEL [hotel_name]</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;600;700&display=swap" rel="stylesheet">
  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    [x-cloak] {
      display: none !important;
    }

    @media print {
      .show-on-print {
        display: block !important;
      }
    }
  </style>
  <!-- Styles -->
  @livewireStyles
</head>

<body x-data class="font-rubik antialiased ">

  <div>
    <div class="relative z-40 md:hidden" role="dialog" aria-modal="true">

      <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

      <div class="fixed inset-0 z-40 flex">

        <div class="relative flex w-full max-w-xs flex-1 flex-col bg-white pt-5 pb-4">

          <div class="absolute top-0 right-0 -mr-12 pt-2">
            <button type="button"
              class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
              <span class="sr-only">Close sidebar</span>
              <!-- Heroicon name: outline/x-mark -->
              <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="flex flex-shrink-0 items-center px-4">
            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
              alt="Your Company">
          </div>
          <div class="mt-5 h-0 flex-1 overflow-y-auto">
            <nav class="space-y-1 px-2">
              <a href="#"
                class="bg-gray-100 text-gray-900 group rounded-md py-2 px-2 flex items-center text-base font-medium">

                <svg class="text-gray-500 mr-4 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
              </a>

              <a href="#"
                class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group rounded-md py-2 px-2 flex items-center text-base font-medium">
                <!-- Heroicon name: outline/users -->
                <svg class="text-gray-400 group-hover:text-gray-500 mr-4 flex-shrink-0 h-6 w-6"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                Team
              </a>

              <a href="#"
                class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group rounded-md py-2 px-2 flex items-center text-base font-medium">
                <svg class="text-gray-400 group-hover:text-gray-500 mr-4 flex-shrink-0 h-6 w-6"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                </svg>
                Projects
              </a>

              <a href="#"
                class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group rounded-md py-2 px-2 flex items-center text-base font-medium">
                <svg class="text-gray-400 group-hover:text-gray-500 mr-4 flex-shrink-0 h-6 w-6"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                Calendar
              </a>

              <a href="#"
                class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group rounded-md py-2 px-2 flex items-center text-base font-medium">
                <svg class="text-gray-400 group-hover:text-gray-500 mr-4 flex-shrink-0 h-6 w-6"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
                </svg>
                Documents
              </a>

              <a href="#"
                class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group rounded-md py-2 px-2 flex items-center text-base font-medium">
                <!-- Heroicon name: outline/chart-bar -->
                <svg class="text-gray-400 group-hover:text-gray-500 mr-4 flex-shrink-0 h-6 w-6"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                </svg>
                Reports
              </a>
            </nav>
          </div>
        </div>

        <div class="w-14 flex-shrink-0">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex flex-grow flex-col overflow-y-auto border-r border-gray-200 bg-white pt-5">
        <div class="flex flex-shrink-0 items-center px-4">
          {{-- <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
            alt="Your Company"> --}}
          <svg class="w-8 h-8 text-gray-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512">
            <path
              d="M480 0C497.7 0 512 14.33 512 32C512 49.67 497.7 64 480 64V448C497.7 448 512 462.3 512 480C512 497.7 497.7 512 480 512H304V448H208V512H32C14.33 512 0 497.7 0 480C0 462.3 14.33 448 32 448V64C14.33 64 0 49.67 0 32C0 14.33 14.33 0 32 0H480zM112 96C103.2 96 96 103.2 96 112V144C96 152.8 103.2 160 112 160H144C152.8 160 160 152.8 160 144V112C160 103.2 152.8 96 144 96H112zM224 144C224 152.8 231.2 160 240 160H272C280.8 160 288 152.8 288 144V112C288 103.2 280.8 96 272 96H240C231.2 96 224 103.2 224 112V144zM368 96C359.2 96 352 103.2 352 112V144C352 152.8 359.2 160 368 160H400C408.8 160 416 152.8 416 144V112C416 103.2 408.8 96 400 96H368zM96 240C96 248.8 103.2 256 112 256H144C152.8 256 160 248.8 160 240V208C160 199.2 152.8 192 144 192H112C103.2 192 96 199.2 96 208V240zM240 192C231.2 192 224 199.2 224 208V240C224 248.8 231.2 256 240 256H272C280.8 256 288 248.8 288 240V208C288 199.2 280.8 192 272 192H240zM352 240C352 248.8 359.2 256 368 256H400C408.8 256 416 248.8 416 240V208C416 199.2 408.8 192 400 192H368C359.2 192 352 199.2 352 208V240zM256 288C211.2 288 173.5 318.7 162.1 360.2C159.7 373.1 170.7 384 184 384H328C341.3 384 352.3 373.1 349 360.2C338.5 318.7 300.8 288 256 288z">
            </path>
          </svg>
          <span class="text-xl font-semibold text-gray-500 uppercase ml-2">{{ app_name() }}</span>
        </div>
        <div class="mt-20 flex flex-grow flex-col">
          <nav class="flex-1 space-y-1 pb-4">
            <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
            <a href="{{ route('office.dashboard') }}"
              class="{{ request()->routeIs('office.dashboard') ? 'bg-gray-50 before:w-1 before:h-full before:bg-green-500 before:absolute before:right-0 font-semibold text-gray-500' : 'text-gray-400' }} relative hover:bg-gray-50 hover:text-gray-500 hover:fill-gray-500 fill-gray-400 px-4  group py-2 flex items-center text-sm
              ">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-2 flex-shrink-0 h-6 w-6">
                <path fill="none" d="M0 0H24V24H0z" />
                <path
                  d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2zm0 2c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zm0 1c1.018 0 1.985.217 2.858.608L13.295 7.17C12.882 7.06 12.448 7 12 7c-2.761 0-5 2.239-5 5 0 1.38.56 2.63 1.464 3.536L7.05 16.95l-.156-.161C5.72 15.537 5 13.852 5 12c0-3.866 3.134-7 7-7zm6.392 4.143c.39.872.608 1.84.608 2.857 0 1.933-.784 3.683-2.05 4.95l-1.414-1.414C16.44 14.63 17 13.38 17 12c0-.448-.059-.882-.17-1.295l1.562-1.562zm-2.15-2.8l1.415 1.414-3.724 3.726c.044.165.067.338.067.517 0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2c.179 0 .352.023.517.067l3.726-3.724z" />
              </svg>
              Dashboard
            </a>
            <a href="{{ route('office.sales') }}"
              class="{{ request()->routeIs('office.sales') ? 'bg-gray-50 before:w-1 before:h-full before:bg-green-500 before:absolute before:right-0 font-semibold text-gray-500' : 'text-gray-400' }} hover:bg-gray-50  relative hover:text-gray-500 hover:fill-gray-500 fill-gray-400 px-4  group py-2 flex items-center text-sm
              ">
              <svg class="mr-2 flex-shrink-0 h-6 w-6" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-width="2"
                  d="M16 16c0-1.105-3.134-2-7-2s-7 .895-7 2s3.134 2 7 2s7-.895 7-2zM2 16v4.937C2 22.077 5.134 23 9 23s7-.924 7-2.063V16M9 5c-4.418 0-8 .895-8 2s3.582 2 8 2M1 7v5c0 1.013 3.582 2 8 2M23 4c0-1.105-3.1-2-6.923-2c-3.824 0-6.923.895-6.923 2s3.1 2 6.923 2S23 5.105 23 4zm-7 12c3.824 0 7-.987 7-2V4M9.154 4v10.166M9 9c0 1.013 3.253 2 7.077 2C19.9 11 23 10.013 23 9">
                </path>
              </svg>
              Sales
            </a>
            <a href="{{ route('office.expenses') }}"
              class="{{ request()->routeIs('office.expenses') ? 'bg-gray-50 before:w-1 before:h-full before:bg-green-500 before:absolute before:right-0 font-semibold text-gray-500' : 'text-gray-400' }} relative hover:bg-gray-50 hover:text-gray-500 hover:fill-gray-500 fill-gray-400 px-4  group py-2 flex items-center text-sm
              ">
              <svg class="mr-2 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                fill="none">
                <path
                  d="M3.28033 2.21967C2.98744 1.92678 2.51256 1.92678 2.21967 2.21967C1.92678 2.51256 1.92678 2.98744 2.21967 3.28033L3.9581 5.01876C2.85336 5.16187 2 6.10628 2 7.25V14.75C2 15.9926 3.00736 17 4.25 17H15.9393L17.4342 18.4949C17.3733 18.4983 17.3118 18.5 17.25 18.5H4.40137C4.92008 19.3967 5.8896 20 7.00002 20H17.25C17.7596 20 18.2504 19.9198 18.7106 19.7712L20.7197 21.7803C21.0126 22.0732 21.4874 22.0732 21.7803 21.7803C22.0732 21.4874 22.0732 21.0126 21.7803 20.7197L3.28033 2.21967ZM14.4393 15.5H6.5V14.75C6.5 13.5074 5.49264 12.5 4.25 12.5H3.5V9.5H4.25C5.39372 9.5 6.33813 8.64664 6.48124 7.5419L8.11684 9.1775C7.72992 9.6827 7.5 10.3145 7.5 11C7.5 12.6569 8.84315 14 10.5 14C11.1855 14 11.8173 13.7701 12.3225 13.3832L14.4393 15.5ZM9.19654 10.2572L11.2428 12.3035C11.0238 12.4285 10.7702 12.5 10.5 12.5C9.67157 12.5 9 11.8284 9 11C9 10.7298 9.07147 10.4762 9.19654 10.2572ZM3.5 7.25C3.5 6.83579 3.83579 6.5 4.25 6.5H5V7.25C5 7.66421 4.66421 8 4.25 8H3.5V7.25ZM4.25 15.5C3.83579 15.5 3.5 15.1642 3.5 14.75V14H4.25C4.66421 14 5 14.3358 5 14.75V15.5H4.25ZM16.75 12.5C16.4349 12.5 16.1348 12.5648 15.8626 12.6818L17.1808 14H17.5V14.3192L18.8182 15.6374C18.9352 15.3652 19 15.0651 19 14.75V7.25C19 6.00736 17.9926 5 16.75 5H8.18078L9.68078 6.5H14.5V7.25C14.5 8.49264 15.5074 9.5 16.75 9.5H17.5V12.5H16.75ZM17.5 7.25V8H16.75C16.3358 8 16 7.66421 16 7.25V6.5H16.75C17.1642 6.5 17.5 6.83579 17.5 7.25ZM20.0618 16.881L21.1472 17.9664C21.6847 17.1966 22 16.2601 22 15.25V10C22 8.8896 21.3967 7.92008 20.5 7.40137V15.25C20.5 15.8445 20.3404 16.4016 20.0618 16.881Z"
                  fill="currentColor"></path>
              </svg>
              Expenses
            </a>
            <a href="{{ route('office.report') }}"
              class="{{ request()->routeIs('office.report') ? 'bg-gray-50 before:w-1 before:h-full before:bg-green-500 before:absolute before:right-0 font-semibold text-gray-500' : 'text-gray-400' }} relative hover:bg-gray-50 hover:text-gray-500 hover:fill-gray-500 fill-gray-400 px-4  group py-2 flex items-center text-sm
              ">
              <svg class="mr-2 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                <rect x="9" y="3" width="6" height="4" rx="2"></rect>
                <path d="M9 17v-5"></path>
                <path d="M12 17v-1"></path>
                <path d="M15 17v-3"></path>
              </svg>
              Reports
            </a>


          </nav>
        </div>
      </div>
    </div>

    <div class="md:pl-64">
      <div class="flex mx-24 flex-col md:px-8 xl:px-0">
        <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 border-b border-gray-200 bg-white">
          <button type="button"
            class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
            <span class="sr-only">Open sidebar</span>
            <!-- Heroicon name: outline/bars-3-bottom-left -->
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
            </svg>
          </button>
          <div class="flex flex-1 justify-between items-center px-4 md:px-0">
            <div class="flex flex-1">
              <h1 class="text-xl font-bold text-gray-600">{{ auth()->user()->branch->name }}</h1>

            </div>
            <div class="ml-4 flex items-center md:ml-6">
              <x-button>
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                  version="1.1" viewBox="0 0 36 36" preserveAspectRatio="xMidYMid meet" fill="currentColor">
                  <title>logout-solid</title>
                  <path
                    d="M23,4H7A2,2,0,0,0,5,6V30a2,2,0,0,0,2,2H23a2,2,0,0,0,2-2V24H15.63a1,1,0,0,1-1-1,1,1,0,0,1,1-1H25V6A2,2,0,0,0,23,4Z"
                    class="clr-i-solid clr-i-solid-path-1"></path>
                  <path
                    d="M28.16,17.28a1,1,0,0,0-1.41,1.41L30.13,22H25v2h5.13l-3.38,3.46a1,1,0,1,0,1.41,1.41L34,23.07Z"
                    class="clr-i-solid clr-i-solid-path-2"></path>
                  <rect x="0" y="0" width="36" height="36" fill-opacity="0"></rect>
                </svg>
              </x-button>

              <!-- Profile dropdown -->
              <div class="relative ml-3">
                <div>
                  <x-button label="{{ auth()->user()->name }}" positive class="font-semibold" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <main class="flex-1">
          {{ $slot }}
        </main>
      </div>
    </div>
  </div>

  @livewireScripts
  @stack('scripts')
</body>

</html>
