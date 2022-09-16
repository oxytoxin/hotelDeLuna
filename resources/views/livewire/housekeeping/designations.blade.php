<div>
    <div>
        @php
            $headers = ['Floor Number', 'Room Count', ''];
        @endphp
        <div class="mt-5">
            <div class="flex flex-col">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <div class="flex justify-between px-2 py-3 bg-white border-b border-gray-200 sm:px-6">
                                <div class="flex space-x-2">
                                    <x-input placeholder="Search"
                                        wire:model.debounce.500ms="search"
                                        icon="search" />
                                </div>
                                <div>
                                </div>
                            </div>
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach ($headers as $header)
                                            <th scope="col"
                                                class="py-3 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-4">
                                                {{ $header }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($floors as $floor)
                                        <tr>
                                            <td
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                {{ ordinal($floor->number) }} Floor
                                            </td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ Str::plural($floor->rooms_count . ' ROOM', $floor->rooms_count) }}
                                            </td>
                                            <td
                                                class="relative py-3 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                <x-button wire:click="manageFloorDesignations({{ $floor->id }})"
                                                    spinner="manageFloorDesignations({{ $floor->id }})"
                                                    sm>
                                                    Manage
                                                </x-button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3"
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                No Room Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="py-2">
                            {{ $floors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:key="model-panes">
        <x-modal.card title="Manage Designation"
            wire:model.defer="showModal">
            <div>
                <form wire:key="form"
                    class="grid space-y-3">
                    <x-select label="Select Room Boy"
                        wire:model.defer="room_boy"
                        placeholder="Select Room Boy"
                        :options="$users"
                        option-label="name"
                        option-value="id" />
                    <div class="flex">
                        <x-button wire:click="save"
                            spinner="save"
                            primary>
                            Assign
                        </x-button>
                    </div>
                </form>
                <div wire:key="list">
                    <div>
                        <div class="flex flex-col mt-5">
                            <h1>
                                List of all ROOM BOY assigned in the floor
                            </h1>
                            <div class="mt-2 -mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @forelse ($designations as $designation)
                                                    <tr>
                                                        <td
                                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                            {{ $designation->room_boy->user->name }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td
                                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                            No record found
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </x-modal.card>
    </div>
</div>
