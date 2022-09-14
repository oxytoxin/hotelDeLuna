<div x-data="{ addpanel: false }">
    <div class="header flex items-center justify-between">
        <div class="welcome">
            <h1 class="text-2xl font-semibold text-gray-600">Categories</h1>
            <h1 class="text-gray-500 text-sm">A list of menu categories.</h1>
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
                <input wire:model="searchCategory" type="text" class="w-56 border-0 focus:border-0 bg-transparent focus:ring-0 text-sm"
                    placeholder="Search for Category....">
            </div>
            <button x-on:click="addpanel = true"  class="bg-gray-600 text-white px-3 hover:bg-gray-700 rounded-lg">
                <span>Add New</span>
            </button>
        </div>
    </div>
    <div class="mt-10">
        <div class="flex flex-col space-y-2">
            @forelse ($foodCategories as $key => $category)
                <div wire:key="{{$key}}" class="px-5 py-3 rounded-lg shadow-sm bg-gray-50 flex justify-between items-center">
                    <div class="flex space-x-2 items-center">
                        <div class="bg-green-500 h-12 w-12 grid fill-white shadow place-content-center rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M20.083 10.5l1.202.721a.5.5 0 0 1 0 .858L12 17.65l-9.285-5.571a.5.5 0 0 1 0-.858l1.202-.721L12 15.35l8.083-4.85zm0 4.7l1.202.721a.5.5 0 0 1 0 .858l-8.77 5.262a1 1 0 0 1-1.03 0l-8.77-5.262a.5.5 0 0 1 0-.858l1.202-.721L12 20.05l8.083-4.85zM12.514 1.309l8.771 5.262a.5.5 0 0 1 0 .858L12 13 2.715 7.429a.5.5 0 0 1 0-.858l8.77-5.262a1 1 0 0 1 1.03 0z" />
                            </svg>
                        </div>
                        <div class="w-96">
                            <h1 class="font-bold text-lg text-gray-500 uppercase">{{$category->name}}</h1>
                        </div>
                        <h1>| {{$category->meals->count()}} Meals</h1>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button
                            class="py-2 px-4 bg-green-500 hover:bg-green-600 grid place-content-center fill-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M16.626 3.132L9.29 10.466l.008 4.247 4.238-.007 7.331-7.332A9.957 9.957 0 0 1 22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2c1.669 0 3.242.409 4.626 1.132zm3.86-1.031l1.413 1.414-9.192 9.192-1.412.003-.002-1.417L20.485 2.1z" />
                            </svg>
                        </button>
                        <a href='{{route('kitchen.manage-menu', ['id' => $category->id])}}' " target='_blank'
                            class="py-2 px-3 bg-gray-600 flex space-x-1 text-white items-center fill-white hover:bg-gray-700 rounded-md">
                            <span>Manage</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M10 6v2H5v11h11v-5h2v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6zm11-3v9l-3.794-3.793-5.999 6-1.414-1.414 5.999-6L12 3h9z" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="grid place-content-center h-40">
                    <div class="flex flex-col  items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-10 w-10 fill-gray-500">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M19 22H5a3 3 0 0 1-3-3V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v12h4v4a3 3 0 0 1-3 3zm-1-5v2a1 1 0 0 0 2 0v-2h-2zM6 7v2h8V7H6zm0 4v2h8v-2H6zm0 4v2h5v-2H6z" />
                        </svg>
                        <h1 class="text-gray-500 text-center">No Categories Found</h1>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="mt-4">
            {{$foodCategories->links()}}
        </div>
    </div>
    <!-- This example requires Tailwind CSS v2.0+ -->
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
                        <h1 class="font-semibold text-gray-600">Add New Category</h1>
                        <h1 class="text-xs leading-3 text-gray-400">Fill in required inputs below.</h1>
                        <div class="relative mt-5">
                            <div
                                class="border border-gray-300 rounded-lg shadow-sm overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                                <label for="title" class="sr-only">Category Name</label>
                                <h1 class="p-2 font-medium placeholder-gray-500"> Category Name</h1>
                                <label for="description" class="sr-only">Description</label>
                                <textarea wire:model="name" rows="2" 
                                    class="block w-full border-0 py-0 resize-none placeholder-gray-500 focus:ring-0 sm:text-sm"
                                    placeholder="Write a description..."></textarea>

                            </div>
                            <div class="mt-3 flex justify-end space-x-2">
                                <button  x-on:click="addpanel = false"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-600 border-1 border-gray-500 hover:border-red-600 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">
                                    Close
                                </button>
                                <button wire:click="saveCategory"
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
