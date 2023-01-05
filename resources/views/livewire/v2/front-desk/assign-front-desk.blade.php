<div>

    <div class="mb-10">
        <h1 class="text-center text-2xl font-semibold uppercase">
            Front Desk Shift Assignment
        </h1>
        <div class="mt-3 rounded-md border border-yellow-400 bg-yellow-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: mini/exclamation-triangle -->
                    <svg class="h-5 w-5 text-yellow-400"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8.485 3.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 3.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        No front desk assigned
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>
                            Please assign a front desk to start the shift. Select as much as applicable.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div>
            <x-my.input label="Select your Name"
                wire:model.debounce.500ms="search"
                placeholder="Search" />
        </div>
        <div>
            <div class="mt-6 flow-root">
                <ul role="list"
                    class="-my-5 divide-y divide-gray-200">
                    @foreach ($frontdesks as $frontdesk)
                        <li wire:key='ff{{ $frontdesk->id }}'
                            class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-900">
                                        {{ $frontdesk->name }}
                                    </p>
                                    <p class="truncate text-sm text-gray-500">
                                        {{ $frontdesk->contact_number }}
                                    </p>
                                </div>
                                <div>
                                    <button type="button"
                                        wire:click="select({{ $frontdesk->id }},'{{ $frontdesk->name }}')"
                                        class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                                        Select
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div wire:key="selected"
        class="mt-20">
        @if (count($selecteds) > 0)
            <div>
                <h1 class="mb-3 text-center text-xl">
                    Selected Front Desks
                </h1>
                <div class="space-y-3 p-2">
                    @forelse ($selecteds as $key => $selected)
                        <div wire:key="xx{{ $key }}"
                            class="flex justify-between rounded-lg border bg-white px-3 py-2 shadow">
                            <span>
                                {{ $selected }}
                            </span>
                        </div>
                    @empty
                        <div>
                            <span>
                                Please select a front desk
                            </span>
                        </div>
                    @endforelse
                </div>
                <div class="buttons mt-3 flex justify-center">
                    <x-button positive
                        wire:click="startShift">
                        Start Shift
                    </x-button>
                </div>
            </div>
        @endif
    </div>
</div>
