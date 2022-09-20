<x-kiosk-layout>
   
    <div class="mt-20 mx-10 font-rubik text-white">
        <h1 class="text-2xl ml-2 font-medium">Welcome to</h1>
        <h1 class="text-7xl uppercase font-black">ALMA RESIDENCES |</h1>
        <h1 class="text">General Santos City</h1>
    </div>
    <div class="flex mx-10 mt-20 mb-2">
        <h1 class="text-gray-300  font-medium font-rubik">Select Transactions:</h1>
    </div>
    <div class="mx-10 font-rubik flex space-x-5 shadow-">
        <button onclick="document.location='{{route('kiosk.checkin')}}'"
            class="focus:ring-2 ring-white bg-white hover:bg-opacity-30 hover:border-4 bg-opacity-10 grid place-content-center w-56 rounded-3xl h-56">
            <div class="text-center grid place-content-center fill-green-500 mb-10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-20 bg-white rounded-full w-20">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                        d="M10 11H2.05C2.55 5.947 6.814 2 12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10c-5.185 0-9.449-3.947-9.95-9H10v3l5-4-5-4v3z" />
                </svg>
            </div>
            <h1 class="font-black text-white font-rubik text-2xl">CHECK-IN</h1>
        </button>
        <button onclick="document.location='{{route('kiosk.checkout')}}'"
            class="focus:ring-2 ring-white hover:bg-opacity-30 bg-white bg-opacity-10 hover:border-4 grid place-content-center w-56 rounded-3xl h-56">
            <div class="text-center grid place-content-center fill-red-500 mb-10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-20 bg-white rounded-full w-20">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                        d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zM7 11V8l-5 4 5 4v-3h8v-2H7z" />
                </svg>
            </div>
            <h1 class="font-black text-white font-rubik text-2xl">CHECK-OUT</h1>
        </button>
    </div>
</x-kiosk-layout>
