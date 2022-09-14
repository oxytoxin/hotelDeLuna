<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ALMA RESIDENCES | KIOSK</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@lottiefiles/lottie-interactivity@latest/dist/lottie-interactivity.min.js"></script>
    @wireUiScripts
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased h-full bg-gray-700">
    <div class="absolute bg-gradient-to-t from-transparent to-gray-500 w-full h-full overflow-hidden">
        <img src="{{ asset('images/kioskbg.jpg') }}" class="object-cover opacity-20" alt="">
    </div>
    <div
        class="absolute text-gray-300 flex justify-end items-end pb-5 pr-5 text-sm font-rubik font-medium w-full h-full">
        POWERED BY: J7 I.T SOLUTION</div>
    <div class="relative">
        <div class="flex justify-between items-center p-4 px-10">
            {{-- <x-svg.logo class="h-16" /> --}}
            @php
                $branch = App\Models\Branch::where('id', Auth::user()->branch_id)->first();
            @endphp
            <div class="flex items-end font-rubik">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-14 fill-white ">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                        d="M17 19h2v-8h-6v8h2v-6h2v6zM3 19V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2H2v-2h1zm4-8v2h2v-2H7zm0 4v2h2v-2H7zm0-8v2h2V7H7z" />
                </svg>
                <div class="flex flex-col ml-1">
                    <h1 class="text-xl text-white font-semibold">{{ $branch['name'] }}</h1>
                </div>
            </div>
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
        {{ $slot }}
    </div>
    <x-notifications z-index="z-50" />
    <x-dialog z-index="z-50" align="center" />
    @livewireScripts
    @stack('scripts')
</body>

</html>
