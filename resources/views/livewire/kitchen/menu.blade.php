<div class="mx-auto max-w-7xl sm:px-6 lg:px-8" x-data="{ addpanel: false }">
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
        <input wire:model="searchCategory" type="text"
          class="w-56 border-0 focus:border-0 bg-transparent focus:ring-0 text-sm"
          placeholder="Search for Category....">
      </div>
      {{-- <button  class="bg-gray-600 text-white px-3 hover:bg-gray-700 rounded-lg">
        <span>Add New</span>
      </button> --}}
      <x-button wire:click="$set('add_modal', true)" label="Add New" right-icon="plus" dark />
    </div>
  </div>
  <div class="mt-10">
    <div class="flex flex-col space-y-2">
      @forelse ($foodCategories as $key => $category)
        <div wire:key="{{ $key }}"
          class="px-5 py-3 rounded-lg shadow-sm bg-gray-50 flex justify-between items-center">
          <div class="flex space-x-2 items-center">
            <div class="bg-green-500 h-12 w-12 grid fill-white shadow place-content-center rounded-xl">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6">
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                  d="M20.083 10.5l1.202.721a.5.5 0 0 1 0 .858L12 17.65l-9.285-5.571a.5.5 0 0 1 0-.858l1.202-.721L12 15.35l8.083-4.85zm0 4.7l1.202.721a.5.5 0 0 1 0 .858l-8.77 5.262a1 1 0 0 1-1.03 0l-8.77-5.262a.5.5 0 0 1 0-.858l1.202-.721L12 20.05l8.083-4.85zM12.514 1.309l8.771 5.262a.5.5 0 0 1 0 .858L12 13 2.715 7.429a.5.5 0 0 1 0-.858l8.77-5.262a1 1 0 0 1 1.03 0z" />
              </svg>
            </div>
            <div class="w-96">
              <h1 class="font-bold text-lg text-gray-500 uppercase">{{ $category->name }}</h1>
            </div>
            <h1>| {{ $category->meals->count() }} Meals</h1>
          </div>
          <div class="flex items-center space-x-2">
            <x-button right-icon="pencil-alt" wire:click="editCategory({{ $category->id }})" positive />
            <x-button label="MANAGE" href="{{ route('kitchen.manage-menu', ['id' => $category->id]) }}" target="_blank"
              right-icon="external-link" slate />
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
      {{ $foodCategories->links() }}
    </div>
  </div>


  <x-modal align="center" max-width="md" wire:model.defer="add_modal">
    <x-card>
      <div>
        <h1 class="font-semibold text-gray-600">Add New Category</h1>
        <h1 class="text-xs leading-3 text-gray-400">Fill in required inputs below.</h1>
        <div class="relative mt-5">
          <div
            class="border border-gray-300 rounded-lg @error('name')
                          border-red-500
                      @enderror shadow-sm overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
            <label for="title" class="sr-only">Category Name</label>
            <h1 class="p-2 font-medium placeholder-gray-500"> Category Name</h1>
            <label for="description" class="sr-only">Description</label>
            <textarea wire:model.defer="name" rows="2"
              class="block w-full border-0 py-0 resize-none placeholder-gray-500 focus:ring-0 sm:text-sm"
              placeholder="Write a description..."></textarea>

          </div>
          @error('name')
            <span class="text-red-500 mt-1 text-xs">{{ $message }}</span>
          @enderror

        </div>
      </div>
      <x-slot name="footer">
        <div class="flex justify-end gap-x-2">
          <x-button x-on:click="close" label="Close" flat negative />
          <x-button wire:click="saveCategory" spinner="saveCategory" label="Add Category" positive />
        </div>
      </x-slot>
    </x-card>
  </x-modal>

  <x-modal align="center" max-width="md" wire:model.defer="edit_modal">
    <x-card>
      <div>
        <h1 class="font-semibold text-gray-600">Edit Category</h1>
        <div class="relative mt-5">
          <div
            class="border border-gray-300 rounded-lg @error('name')
                          border-red-500
                      @enderror shadow-sm overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
            <label for="title" class="sr-only">Category Name</label>
            <h1 class="p-2 font-medium placeholder-gray-500"> Category Name</h1>
            <label for="description" class="sr-only">Description</label>
            <textarea wire:model.defer="name" rows="2"
              class="block w-full border-0 py-0 resize-none placeholder-gray-500 focus:ring-0 sm:text-sm"
              placeholder="Write a description..."></textarea>

          </div>
          @error('name')
            <span class="text-red-500 mt-1 text-xs">{{ $message }}</span>
          @enderror

        </div>
      </div>
      <x-slot name="footer">
        <div class="flex justify-end gap-x-2">
          <x-button x-on:click="close" label="Close" flat negative />
          <x-button wire:click="updateCategory" spinner="updateCategory" label="Update Category" positive />
        </div>
      </x-slot>
    </x-card>
  </x-modal>


</div>
