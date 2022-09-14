<div x-data="{addpanel:false}">
    <div class="header flex items-center justify-between">
        <div class="welcome">
            <h1 class="text-2xl font-semibold text-gray-600">{{ $category->name }}</h1>
            <h1 class="text-gray-500 text-sm">A list of menu for {{ $category->name }}.</h1>
        </div>
        <div class="search flex space-x-2">
            <div class="flex bg-gray-50 p-1 px-3 space-x-1 items-center rounded-lg">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-gray-400">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z" />
                    </svg>
                </div>
                <input wire:model="searchMenu" type="text"
                    class="w-56 border-0 focus:border-0 bg-transparent focus:ring-0 text-sm"
                    placeholder="Search for Menu....">
            </div>
            <button x-on:click="addpanel = true" class="bg-gray-600 text-white px-3 hover:bg-gray-700 rounded-lg">
                <span>Add New</span>
            </button>
        </div>
    </div>
    <div class="mt-8 grid grid-cols-5 gap-6">
        @forelse ($menus as $menu)
            <div class="bg-gray-50 rounded-xl shadow p-2 h-[15.5 rem]">
                <div class="bg-gray-500 shadow h-40 rounded-xl relative">
                    <img src="{{ asset('images/no-image-available.png') }}"
                        class="h-full opacity-50 w-full rounded-xl object-cover" alt="">
                    <div class="absolute top-2 right-2">
                        <div
                            class="bg-white bg-opacity-20 h-10 w-10 fill-white cursor-pointer hover:fill-green-200 rounded-xl grid place-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M2.132 13.63a9.942 9.942 0 0 1 0-3.26c1.102.026 2.092-.502 2.477-1.431.385-.93.058-2.004-.74-2.763a9.942 9.942 0 0 1 2.306-2.307c.76.798 1.834 1.125 2.764.74.93-.385 1.457-1.376 1.43-2.477a9.942 9.942 0 0 1 3.262 0c-.027 1.102.501 2.092 1.43 2.477.93.385 2.004.058 2.763-.74a9.942 9.942 0 0 1 2.307 2.306c-.798.76-1.125 1.834-.74 2.764.385.93 1.376 1.457 2.477 1.43a9.942 9.942 0 0 1 0 3.262c-1.102-.027-2.092.501-2.477 1.43-.385.93-.058 2.004.74 2.763a9.942 9.942 0 0 1-2.306 2.307c-.76-.798-1.834-1.125-2.764-.74-.93.385-1.457 1.376-1.43 2.477a9.942 9.942 0 0 1-3.262 0c.027-1.102-.501-2.092-1.43-2.477-.93-.385-2.004-.058-2.763.74a9.942 9.942 0 0 1-2.307-2.306c.798-.76 1.125-1.834.74-2.764-.385-.93-1.376-1.457-2.477-1.43zM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="py-3">
                    <h1 class="font-semibold text-gray-500">{{$menu->name}}</h1>
                    <h1 class="font-semibold mt-1 text-lg text-green-500">&#8369;{{number_format($menu->price,2)}}</h1>
                </div>
            </div>
        @empty
            <div class="col-span-6 flex justify-center items-center flex-col h-40">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-10 w-10 fill-gray-500">
                    <path fill="none" d="M0 0H24V24H0z" />
                    <path
                        d="M20 12v10c0 .552-.448 1-1 1H5c-.552 0-1-.448-1-1V12h16zM9 14H7v5h2v-5zM19 1c.552 0 1 .448 1 1v8H4V2c0-.552.448-1 1-1h14zM9 4H7v4h2V4z" />
                </svg>
                <h1 class="text-gray-500">No Menu Found</h1>
            </div>
        @endforelse
    </div>
    <div x-show="addpanel" x-cloak class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!--
      Background backdrop, show/hide based on modal state.
  
      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
        <div x-show="addpanel" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

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
                <div x-show="addpanel" x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative bg-white rounded-xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <h1 class="font-semibold text-gray-600">Add New Menu</h1>
                        <h1 class="text-xs leading-3 text-gray-400">Fill in required inputs below.</h1>
                        <div class="relative mt-5">
                            <div
                                class="border border-gray-300 rounded-lg shadow-sm overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                                <label for="title" class="sr-only">Category Name</label>
                                <h1 class="p-2 font-medium placeholder-gray-500"> Food Name</h1>
                                <label for="description" class="sr-only">Description</label>
                                <textarea wire:model="name" rows="2" 
                                    class="block w-full border-0 py-0 resize-none placeholder-gray-500 focus:ring-0 sm:text-sm"
                                    placeholder="Write a description..."></textarea>
                                <h1 class="p-2 font-medium placeholder-gray-500"> Price</h1>
                                <label for="description" class="sr-only">Description</label>
                                <input type="number" wire:model="price" name="" id="" class="w-full focus:ring-0 placeholder-gray-500 sm:text-sm border-0 py-0 appearance-none mb-2" placeholder="&#8369;100.00">

                            </div>
                            <div class="mt-3 flex justify-end space-x-2">
                                <button  x-on:click="addpanel = false"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-600 border-1 border-gray-500 hover:border-red-600 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">
                                    Close
                                </button>
                                <button wire:click="saveMenu"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600">
                                    Add Category
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
