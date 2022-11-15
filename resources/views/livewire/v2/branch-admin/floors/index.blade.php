<div class="grid space-y-4">
    <div class="flex w-full items-center space-x-3">
        <x-my.button-primary wire:click="createFloor"
            label="New Floor">
            <x-slot name="icon">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-5 w-5">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </x-slot>
        </x-my.button-primary>
    </div>
    <ul role="list"
        class="grid grid-cols-1 gap-6 sm:grid-cols-5">
        @forelse ($floors as $floor)
            <li wire:key="{{ $floor->id }}"
                class="relative col-span-1 flex flex-col rounded-lg bg-white text-center shadow">
                <button type="button"
                    wire:click="edit({{ $floor->id }})"
                    class="absolute top-2 right-2 flex items-center space-x-2 rounded-md bg-yellow-400 px-2 py-1 text-white shadow-md hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </button>
                <div class="flex flex-1 flex-col p-4">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="mx-auto h-24 w-24 flex-shrink-0 text-gray-600">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                    <h3 class="mt-6 font-medium text-gray-700">
                        {{ ordinal($floor->number) }} Floor
                    </h3>
                </div>
                <div class="border-t">
                    <div class="-mt-px flex divide-x divide-gray-200">
                        <div class="-ml-px flex w-0 flex-1">
                            <button type="button"
                                wire:click="setSelectedFloor({{ $floor->id }})"
                                class="relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
                                <span class="ml-3">
                                    VIEW ROOMS
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </li>
        @empty
        @endforelse
    </ul>

    {{-- modals --}}

    <div wire:key="floorsModal">
        <form wire:submit.prevent="save">
            @csrf
            <x-my.modal title="{{ $floorModalMode == 'create' ? 'Create Floor' : 'Edit Floor' }}"
                :showOn="['show-floor-modal']"
                :closeOn="['close-floor-modal']">
                <x-my.input type="number"
                    numberOnly
                    label="Floor Number"
                    wire:model.defer="floor.number" />
                <x-slot name="footer">
                    <div class="flex space-x-3">
                        <x-my.button-secondary x-on:click="close"
                            label="Cancel" />
                        <x-my.button-success type="submit"
                            loadingOn="save"
                            label="Save" />
                    </div>
                </x-slot>
            </x-my.modal>
        </form>
    </div>
</div>
