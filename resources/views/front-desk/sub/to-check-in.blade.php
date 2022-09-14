<div>
    @php
        $headers = ['QR CODE', 'Name', 'Contact Number', ''];
    @endphp
    <div x-data="{ noteShow: $persist(true) }">
        <div>
            <template x-if="noteShow">
                <div x-cloak
                    x-show="noteShow"
                    x-transition
                    class="p-4 mb-2 border border-blue-400 rounded-md bg-blue-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-400"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 ml-3 md:flex md:justify-between">
                            <p class="text-sm text-blue-700">
                                <strong>NOTE:</strong> Please make sure to focus on the search box before scanning the
                                QR
                                Code.
                            </p>
                            <p class="mt-3 text-sm md:mt-0 md:ml-6">
                                <button x-on:click="noteShow = false"
                                    class="font-medium text-blue-700 whitespace-nowrap hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div class="flex flex-col">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <div
                            class="flex items-center justify-between px-2 py-3 space-x-2 bg-white border-b border-gray-200 sm:px-6">
                            <div class="flex items-center space-x-2">
                                <x-native-select wire:model="searchBy">
                                    <option value="1">Search By Qr Code</option>
                                    <option value="2">Search By Name</option>
                                    <option value="3">Search By Contact Number</option>
                                </x-native-select>
                                <x-input icon="search"
                                    wire:model.defer="search"
                                    placeholder="Search" />
                                <x-button primary
                                    wire:click="searchReal"
                                    spinner="searchReal"
                                    label="Search"
                                    icon="search" />

                            </div>
                            <div>
                                <x-button x-cloak
                                    x-show="noteShow==false"
                                    blue
                                    x-on:click="noteShow = true"
                                    icon="information-circle"
                                    flat />
                            </div>
                        </div>
                        <table class="min-w-full divide-y divide-gray-300">
                            @if ($realSearch)
                                <thead id="sr"
                                    class="bg-gray-50">
                                    <tr>
                                        <th colspan="3"
                                            class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">
                                            Search Result for : <span class="text-gray-700">{{ $realSearch }}</span>
                                        </th>
                                        <th
                                            class="py-3 pr-4 text-xs font-medium tracking-wide text-right text-gray-500 uppercase">
                                            <x-button wire:click="$set('realSearch', '')"
                                                sm
                                                negative>CLEAR SEARCH</x-button>
                                        </th>
                                    </tr>
                                </thead>
                            @endif
                            <thead id="tableh"
                                class="bg-gray-50">
                                <tr>
                                    @foreach ($headers as $header)
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">
                                            {{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($guests as $guest)
                                    <tr>
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            {{ $guest->qr_code }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $guest->name }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $guest->contact_number }}
                                        </td>
                                        <td
                                            class="relative py-2 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                            <x-button wire:key="{{ $guest->id }}"
                                                wire:click="setGuest({{ $guest->id }})"
                                                spinner="setGuest({{ $guest->id }})"
                                                sm>
                                                VIEW
                                            </x-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            No Rates Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="py-2">
                        {{ $guests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
