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
    @php
        $branch = App\Models\Branch::where('id', Auth::user()->branch_id)->first();
    @endphp
    <div class="flex h-screen">
        <div class="sidebar top-0 z-10 fixed bottom-0 left-0   bg-gray-600 w-28">
            <img src="{{ asset('images/dmorvielogo.png') }}"
                class="h-64 w-full opacity-10 absolute  bottom-10 object-cover" alt="">
            <div class="h-32 border-b w-full border-gray-400 grid place-content-center">
                <div class=" flex flex-col justify-center items-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-14 fill-white ">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M17 19h2v-8h-6v8h2v-6h2v6zM3 19V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2H2v-2h1zm4-8v2h2v-2H7zm0 4v2h2v-2H7zm0-8v2h2V7H7z" />
                    </svg>
                    <span class="text-center text-white text-xs">{{$branch['name']}}</span>
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
            <div class="absolute bottom-0 left-0 h-10 w-full">
                <form method="POST" action="{{ route('logout') }}" role="none">
                    @csrf
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                this.closest('form').submit();"
                        class="grid place-content-center fill-gray-300 hover:fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-7 rotate-90 w-7">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M5 11h8v2H5v3l-5-4 5-4v3zm-1 7h2.708a8 8 0 1 0 0-12H4A9.985 9.985 0 0 1 12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.985 9.985 0 0 1-8-4z" />
                        </svg>
                    </a>
                </form>
            </div>
        </div>
        <main class="flex-1 relative">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>

</html>
