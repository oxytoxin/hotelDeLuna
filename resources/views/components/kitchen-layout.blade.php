<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>ALMA RESIDENCES | KITCHEN</title>

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

  <div class="flex h-screen" x-data="{ logout: false }">
    <div class="sidebar top-0 z-10 fixed bottom-0 left-0   bg-gray-600 w-28">
      <img src="{{ asset('images/dmorvielogo.png') }}" class="h-64 w-full opacity-10 absolute  bottom-10 object-cover"
        alt="">
      <div class="h-32 border-b w-full border-gray-400 grid place-content-center">
        <div class=" flex flex-col justify-center items-center ">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-14 fill-white ">
            <path fill="none" d="M0 0h24v24H0z" />
            <path
              d="M17 19h2v-8h-6v8h2v-6h2v6zM3 19V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2H2v-2h1zm4-8v2h2v-2H7zm0 4v2h2v-2H7zm0-8v2h2V7H7z" />
          </svg>
          <span class="text-center text-white font-bold">{{ app_name() }}</span>
        </div>
      </div>
      <div class="flex flex-col space-y-2 mt-10">
        <a href="{{ route('kitchen.dashboard') }}" class="flex h-12 hover:fill-white">
          <div
            class="flex-1 grid place-content-center {{ Request::routeIs('kitchen.dashboard') ? 'fill-white' : 'fill-gray-400' }} hover:fill-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-8 w-8">
              <path fill="none" d="M0 0h24v24H0z" />
              <path
                d="M21 20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.49a1 1 0 0 1 .386-.79l8-6.222a1 1 0 0 1 1.228 0l8 6.222a1 1 0 0 1 .386.79V20zm-10-7v6h2v-6h-2z" />
            </svg>
          </div>
          <div class="{{ Request::routeIs('kitchen.dashboard') ? 'bg-green-500' : '' }} w-1"></div>
        </a>

        <a href="{{ route('kitchen.menu') }}" class="flex h-12">
          <div
            class="flex-1 grid place-content-center {{ Request::routeIs('kitchen.menu') ? 'fill-white' : 'fill-gray-400' }} hover:fill-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-7 h-8">
              <path fill="none" d="M0 0h24v24H0z" />
              <path
                d="M22 9.999V20a1 1 0 0 1-1 1h-8V9.999h9zm-11 6V21H3a1 1 0 0 1-1-1v-4.001h9zM11 3v10.999H2V4a1 1 0 0 1 1-1h8zm10 0a1 1 0 0 1 1 1v3.999h-9V3h8z" />
            </svg>
          </div>
          <div class="{{ Request::routeIs('kitchen.menu') ? 'bg-green-500' : '' }} w-1"></div>
        </a>
        <a href="{{ route('kitchen.order') }}" class="flex h-12 ">
          <div
            class="flex-1 grid place-content-center  {{ Request::routeIs('kitchen.order') ? 'fill-white' : 'fill-gray-400' }} hover:fill-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-8 w-8">
              <path fill="none" d="M0 0h24v24H0z" />
              <path
                d="M15.366 3.438L18.577 9H22v2h-1.167l-.757 9.083a1 1 0 0 1-.996.917H4.92a1 1 0 0 1-.996-.917L3.166 11H2V9h3.422l3.212-5.562 1.732 1L7.732 9h8.535l-2.633-4.562 1.732-1zM13 13h-2v4h2v-4zm-4 0H7v4h2v-4zm8 0h-2v4h2v-4z" />
            </svg>
          </div>
          <div class="{{ Request::routeIs('kitchen.order') ? 'bg-green-500' : '' }} w-1"></div>
        </a>
        <a href="{{ route('kitchen.settings') }}" class="flex h-12">
          <div
            class="flex-1 grid place-content-center {{ Request::routeIs('kitchen.settings') ? 'fill-white' : 'fill-gray-400' }} hover:fill-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-8 w-8">
              <path fill="none" d="M0 0h24v24H0z" />
              <path
                d="M5.334 4.545a9.99 9.99 0 0 1 3.542-2.048A3.993 3.993 0 0 0 12 3.999a3.993 3.993 0 0 0 3.124-1.502 9.99 9.99 0 0 1 3.542 2.048 3.993 3.993 0 0 0 .262 3.454 3.993 3.993 0 0 0 2.863 1.955 10.043 10.043 0 0 1 0 4.09c-1.16.178-2.23.86-2.863 1.955a3.993 3.993 0 0 0-.262 3.455 9.99 9.99 0 0 1-3.542 2.047A3.993 3.993 0 0 0 12 20a3.993 3.993 0 0 0-3.124 1.502 9.99 9.99 0 0 1-3.542-2.047 3.993 3.993 0 0 0-.262-3.455 3.993 3.993 0 0 0-2.863-1.954 10.043 10.043 0 0 1 0-4.091 3.993 3.993 0 0 0 2.863-1.955 3.993 3.993 0 0 0 .262-3.454zM13.5 14.597a3 3 0 1 0-3-5.196 3 3 0 0 0 3 5.196z" />
            </svg>
          </div>
          <div class="{{ Request::routeIs('kitchen.settings') ? 'bg-green-500' : '' }} w-1"></div>
        </a>
      </div>
      <div class="absolute bottom-0 left-0 h-10 w-full flex justify-center">
        <button x-on:click="logout = true" class="grid place-content-center fill-gray-300 hover:fill-white">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-7 rotate-90 w-7">
            <path fill="none" d="M0 0h24v24H0z" />
            <path
              d="M5 11h8v2H5v3l-5-4 5-4v3zm-1 7h2.708a8 8 0 1 0 0-12H4A9.985 9.985 0 0 1 12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.985 9.985 0 0 1-8-4z" />
          </svg>
        </button>
      </div>
    </div>
    <main class="flex-1 relative">
      {{ $slot }}
    </main>

    <div x-show="logout" x-cloak class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

      <div x-show="logout" x-cloak x-transacion:enter="ease-out duration-300" x-transacion:enter-start="opacity-0"
        x-transacion:enter-end="opacity-100" x-transacion:leave="ease-in duration-200"
        x-transacion:leave-start="opacity-100" x-transacion:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

          <div x-show="logout" x-cloak x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm   sm:p-6">
            <div class="sm:flex sm:items-start">
              <div
                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <!-- Heroicon name: outline/exclamation-triangle -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-red-700">
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
  </div>
  <x-notifications z-index="z-50" />


  @livewireScripts
</body>

</html>
