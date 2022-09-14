<div x-data="{ selectCustomer: @entangle('customerpanel'), success:@entangle('confirmModal') }">
    <div class="header flex items-center justify-between">
        <div class="welcome">
            <h1 class="text-2xl font-semibold text-gray-600">Welcome to Kitchen</h1>
            <h1 class="text-gray-500 text-sm">Select whatever the customer needs.</h1>
        </div>
        <div class="search">
            <div class="flex bg-gray-50 p-1 px-3 space-x-1 items-center rounded-lg">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-gray-400">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z" />
                    </svg>
                </div>
                <input type="text" wire:model="searchMenu"
                    class="w-56 border-0 focus:border-0 bg-transparent focus:ring-0 text-sm"
                    placeholder="Search for Meal....">
            </div>
        </div>
    </div>
    <div class="mt-10 grid grid-cols-7 gap-3">
        @foreach ($categories as $category)
            <button wire:click="$set('category_id',{{ $category->id }})"
                class="{{ $category_id == $category->id ? 'bg-green-500 text-white text-gray' : 'bg-gray-50 text-gray-500' }} hover:bg-green-500 h-12 hover:text-white shado grid place-content-center  rounded-lg p-1">
                <p class="text-center font-semibold text-sm">{{ $category->name }}</p>
            </button>
        @endforeach

    </div>
    <div class="mt-5 grid grid-cols-4 gap-4 mb-6">
        @forelse ($meals as $key => $meal)
            <div wire:key="{{ $key }}" wire:click="selectMeal({{ $meal->id }})"
                class="bg-gray-50 hover:border-2 hover:border-green-400 cursor-pointer rounded-xl shadow p-2 h-[15.5 rem]">
                <div class="bg-gray-500 shadow h-40 rounded-xl relative">
                    <img src="{{ asset('images/no-image-available.png') }}"
                        class="h-full opacity-50 w-full rounded-xl object-cover" alt="">
                    <div class="absolute top-2 right-2">
                        <div class="bg-white bg-opacity-20 h-10 w-10 rounded-xl grid place-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 fill-green-500">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M4 6.414L.757 3.172l1.415-1.415L5.414 5h15.242a1 1 0 0 1 .958 1.287l-2.4 8a1 1 0 0 1-.958.713H6v2h11v2H5a1 1 0 0 1-1-1V6.414zM6 7v6h11.512l1.8-6H6zm-.5 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm12 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="py-3">
                    <h1 class="font-semibold text-gray-500">{{ $meal->name }}</h1>
                    <h1 class="font-semibold mt-1 text-lg text-green-500">&#8369;{{ number_format($meal->price, 2) }}
                    </h1>
                </div>
            </div>
        @empty
            <div class="col-span-4 flex flex-col justify-center space-y-2 items-center">
                <x-svg.no-result class="h-40" />
                <h1 class="text-gray-500">No Menu for this Category!</h1>
            </div>
        @endforelse
    </div>
    <div class="fixed right-0 top-0 bottom-0 bg-gray-200 py-8 px-5 w-72">

        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-lg text-gray-700">Current Order</h1>
            <div class="bg-white w-9 h-9 rounded-xl grid place-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 fill-gray-600">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                        d="M2 18h7v2H2v-2zm0-7h9v2H2v-2zm0-7h20v2H2V4zm18.674 9.025l1.156-.391 1 1.732-.916.805a4.017 4.017 0 0 1 0 1.658l.916.805-1 1.732-1.156-.391c-.41.37-.898.655-1.435.83L19 21h-2l-.24-1.196a3.996 3.996 0 0 1-1.434-.83l-1.156.392-1-1.732.916-.805a4.017 4.017 0 0 1 0-1.658l-.916-.805 1-1.732 1.156.391c.41-.37.898-.655 1.435-.83L17 11h2l.24 1.196c.536.174 1.024.46 1.434.83zM18 18a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                </svg>
            </div>
        </div>
        <div class="mt-3 flex flex-col space-y-1">
            @forelse ($transaction as $key => $meal)
                <div class="order bg-white relative rounded-lg p-2 flex space-x-2">
                    <div class="absolute -top-2 -right-3  grid place-content-center ">
                        <button wire:click="removeOrder({{ $key }})" class="fill-red-500 hover:fill-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-11.414L9.172 7.757 7.757 9.172 10.586 12l-2.829 2.828 1.415 1.415L12 13.414l2.828 2.829 1.415-1.415L13.414 12l2.829-2.828-1.415-1.415L12 10.586z" />
                            </svg>
                        </button>
                    </div>
                    <div class="bg-green-500 rounded-lg h-12 w-12 grid place-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-white">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M15.366 3.438L18.577 9H22v2h-1.167l-.757 9.083a1 1 0 0 1-.996.917H4.92a1 1 0 0 1-.996-.917L3.166 11H2V9h3.422l3.212-5.562 1.732 1L7.732 9h8.535l-2.633-4.562 1.732-1zM13 13h-2v4h2v-4zm-4 0H7v4h2v-4zm8 0h-2v4h2v-4z" />
                        </svg>
                    </div>
                    <div class="flex-1 flex-col">
                        <h1 class="font-semibold text-gray-600">{{ $meal['name'] }}</h1>
                        <div class="flex justify-between">
                            <h1 class="font-semibold text-green-600 text-sm">
                                &#8369;{{ number_format($meal['price'], 2) }}</h1>
                            <div class="flex text-sm space-x-3 items-center">
                                <button wire:click="minusQty({{ $key }})"
                                    class="bg-green-500 hover:bg-green-600 shadow p-0.5 px-2 rounded grid font-semibold text-white  place-content-center">
                                    <span>-</span>
                                </button>
                                <div class="font-semibold text-gray-600">{{ $meal['qty'] }}</div>
                                <button wire:click="addQty({{ $key }})"
                                    class="bg-green-500 hover:bg-green-600 shadow p-0.5 px-2 rounded font-semibold text-white grid place-content-center">
                                    <span>+</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class=" mt-9 flex flex-col space-y-3 justify-center items-center">
                    <x-svg.no-result class="h-28" />
                    <h1 class="text-gray-500">No Order!</h1>
                </div>
            @endforelse
        </div>

        <div class="absolute bottom-0 left-0 w-full px-4 pb-4">
            <div class="flex flex-col space-y-3">
                <div
                    class="
                bg-white rounded-lg relative h-40 flex flex-col justify-between overflow-hidden
                before:absolute before:bg-gray-200 before:h-5 before:w-5 before:rounded-full before:bottom-[2.5rem] before:-left-2
                after:absolute after:bg-gray-200 after:h-5 after:w-5 after:rounded-full after:bottom-[2.5rem] after:-right-2
                ">
                    <div class="flex-1  flex flex-col justify-between">
                        <section class="p-3">
                            <h1 class="text-gray-500">Order Summary</h1>
                            <h1 class="text-red-500 leading-3 text-xs">({{$customer['qr_code'] ?? '***********'}})</h1>
                            <div class="flex justify-between mt-4 text-gray-600">
                                <dt>Subtotal</dt>
                                <dd class="">&#8369;{{ number_format(collect($transaction)->sum('total'), 2) }}
                                </dd>
                            </div>
                        </section>
                        <section class="border border-dashed border-gray-400 "></section>
                    </div>
                    <section class="p-3">
                        <div class="flex justify-between  text-green-600">
                            <dt>Total</dt>
                            <dd class="font-semibold">
                                &#8369;{{ number_format(collect($transaction)->sum('total'), 2) }}
                            </dd>
                        </div>
                    </section>
                </div>
                <button wire:click="checkoutOrder" class="bg-green-500 py-2 rounded-lg text-white font-semibold hover:bg-green-600">
                    <span>CheckOut Order</span>
                </button>
            </div>
        </div>
    </div>
   
    <div x-show="selectCustomer" x-cloak class="relative z-10" role="dialog" aria-modal="true">
        <!--
      Background backdrop, show/hide based on modal state.
  
      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
        <div x-show="selectCustomer" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
            <!--
        Command palette, show/hide based on modal state.
  
        Entering: "ease-out duration-300"
          From: "opacity-0 scale-95"
          To: "opacity-100 scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 scale-100"
          To: "opacity-0 scale-95"
      -->
            <div x-show="selectCustomer" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
                class="mx-auto max-w-3xl transform divide-y divide-gray-100 overflow-hidden relative rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
             
                <div class="absolute top-2 right-2">
                    <x-button xs x-on:click="selectCustomer = false" negative class="z-10 relative" label="CLOSE" />
                </div>
                <div class="relative">
                    <!-- Heroicon name: solid/search -->
                    {{-- <svg class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
          </svg> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 fill-gray-400">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z" />
                    </svg>
                    <input type="text" wire:model="guestSearch"
                        class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm"
                        placeholder="Search Guest..." role="combobox" aria-expanded="false" aria-controls="options">
                </div>

                <div class="flex divide-x divide-gray-100">
                    <!-- Preview Visible: "sm:h-96" -->
                    <div class="max-h-96 min-w-0 flex-auto scroll-py-4 overflow-y-auto px-6 py-4 sm:h-96">
                        <!-- Default state, show/hide based on command palette state. -->
                        <h2 class="mt-2 mb-4 text-xs font-semibold text-gray-500">Guest List</h2>


                        <!-- Results, show/hide based on command palette state. -->
                        <ul class="-mx-2 text-sm text-gray-700" id="options" role="listbox">
                            <!-- Active: "bg-gray-100 text-gray-900" -->
                            @forelse ($guests as $guest)
                                <li wire:click="selectCustomer({{ $guest->id }})"
                                    class="group flex cursor-pointer hover:fill-green-500 fill-gray-600 select-none items-center rounded-md p-2"
                                    id="option-1" role="option" tabindex="-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path d="M5 20h14v2H5v-2zm7-2a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                                    </svg>
                                    <span class="ml-2 flex-auto truncate">{{ $guest->name }}</span>
                                    <!-- Not Active: "hidden" -->
                                    <!-- Heroicon name: solid/chevron-right -->
                                    <svg class="ml-3 hidden h-5 w-5 flex-none text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </li>
                                @empty
                             <span class="ml-3">No Guest...</span>
                            @endforelse

                        </ul>
                    </div>

                    <!-- Active item side-panel, show/hide based on active state -->
                    <div class="hidden h-96 w-1/2 flex-none flex-col divide-y divide-gray-100 overflow-y-auto sm:flex">
                        <div class="flex-none p-6 text-center">
                            {{-- <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="" class="mx-auto h-16 w-16 rounded-full"> --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mx-auto h-16 w-16 fill-green-500">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zM7 12a5 5 0 0 0 10 0h-2a3 3 0 0 1-6 0H7z" />
                            </svg>
                            <h2 class="mt-3 font-semibold text-gray-900">{{$customer['name'] ?? 'No Name'}}</h2>
                        </div>
                        <div class="flex flex-auto flex-col justify-between p-6">
                            <dl class="grid grid-cols-1 gap-x-6 gap-y-3 text-sm text-gray-700">
                                <dt class="col-end-1 font-semibold text-gray-900">Phone</dt>
                                <dd>{{$customer['contact_number'] ?? '09*********'}}</dd>
                                <dt class="col-end-1 font-semibold text-gray-900">QR_CODE</dt>
                                <dd class="truncate">{{$customer['qr_code'] ?? '************'}}</dd>
                                <dt class="col-end-1 font-semibold text-gray-900">Full Name</dt>
                                <dd class="truncate"><a href="#"
                                        class="text-indigo-600 uppercase underline">{{$customer['name'] ?? 'JUAN DELA CRUZ'}}</a></dd>
                            </dl>
                            @if ($customer != null)
                            <button type="button" wire:click="$set('customerpanel', false)"
                            class="mt-6 w-full rounded-md border border-transparent bg-gray-600 py-2 px-4 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Accept Order</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<div x-show="success" x-cloak class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!--
      Background backdrop, show/hide based on modal state.
  
      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <div x-show="success" x-cloak
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity"></div>
  
    <div class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
        <!--
          Modal panel, show/hide based on modal state.
  
          Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        -->
        <div x-show="success" x-cloak
        x-transition:enter="ease-out duration
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full sm:p-6">
          <div class="w-full grid place-content-center">
            <x-svg.success class="h-48" />
            <p class="mt-5 text-gray-500">Order has been successfully checkout.</p>
          </div>
          <div class="mt-5 flex">
            <button wire:click="$set('confirmModal', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-4 bg-green-500 text-base font-semibold text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">OK</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
