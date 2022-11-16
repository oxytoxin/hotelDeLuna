<div>
    <div class="mb-3 w-full">
        <div class="flex items-center space-x-3">
            <x-my.input.search wire:model.defer="search" />
            <x-my.input.select wire:model.defer="searchBy">
                <option value="1">QR CODE</option>
                <option value="2">ROOM Number</option>
            </x-my.input.select>
            @if ($realSearch == '')
                <button id="searchButton"
                    type="button"
                    wire:click.prevent="search"
                    class="mt-1 inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    Search
                </button>
            @else
                <button id="clearSearchButton"
                    type="button"
                    wire:click="clearSearch"
                    class="mt-1 inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto">
                    Clear Search
                </button>
            @endif
        </div>
    </div>
    <div x-animate>
        @if ($guest)
            <div x-animate
                wire:key="23jfnvmxclvnsdhjfiowejfslvcnml">
                <div class="mb-3">
                    <div>
                        <nav class="isolate flex divide-x divide-gray-200 rounded-lg shadow"
                            aria-label="Tabs">
                            <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->

                            @foreach ($tabs as $tab)
                                <button type="button"
                                    wire:click="changeTab({{ $tab['id'] }})"
                                    class="{{ $loop->first ? 'rounded-l-lg' : '' }} {{ $loop->last ? 'rounded-r-lg' : '' }} group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium text-gray-900 hover:bg-gray-50 focus:z-10"
                                    aria-current="page">
                                    <span>
                                        {{ $tab['name'] }}
                                    </span>
                                    @if ($tab['id'] == $activeTab)
                                        <span aria-hidden="true"
                                            class="absolute inset-x-0 bottom-0 h-0.5 bg-primary-500"></span>
                                    @endif
                                </button>
                            @endforeach

                            {{-- <a href="#"
                            class="group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 focus:z-10">
                            <span>Company</span>
                            <span aria-hidden="true"
                                class="absolute inset-x-0 bottom-0 h-0.5 bg-transparent"></span>
                        </a>

                        <a href="#"
                            class="group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 focus:z-10">
                            <span>Team Members</span>
                            <span aria-hidden="true"
                                class="absolute inset-x-0 bottom-0 h-0.5 bg-transparent"></span>
                        </a>

                        <a href="#"
                            class="group relative min-w-0 flex-1 overflow-hidden rounded-r-lg bg-white py-4 px-4 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 focus:z-10">
                            <span>Billing</span>
                            <span aria-hidden="true"
                                class="absolute inset-x-0 bottom-0 h-0.5 bg-transparent"></span>
                        </a> --}}
                        </nav>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-5">
                <div class="col-span-4 grid gap-3"
                    x-animate>
                    <div wire:key="99892398423jkjlsdjfskdlfjksjdklmvxclvlksdjflkse"
                        class="rounded-lg bg-white p-3 shadow">
                        <div wire:key="doja8324i2o3joirwf89c793q7c9r8"
                            class="mb-2 flex">
                            <h1 class="text-lg font-semibold text-gray-800">
                                Guest Details
                            </h1>
                        </div>
                        <div x-animate>
                            @if ($guest)
                                <div wire:key="ajs8213412qcxjzcnasyfdsaf"
                                    class="grid">
                                    <div class="grid">
                                        <label class="text-sm text-gray-500">
                                            QR Code
                                        </label>
                                        <h1 class="text-gray-700">
                                            {{ $guest->qr_code }}
                                        </h1>
                                    </div>
                                    <div class="grid border-t pt-2">
                                        <label class="text-sm text-gray-500">
                                            Name
                                        </label>
                                        <h1 class="text-gray-700">
                                            {{ $guest->name }}
                                        </h1>
                                    </div>
                                    <div class="grid border-t pt-2">
                                        <label class="text-sm text-gray-500">
                                            Contact Number
                                        </label>
                                        <h1 class="text-gray-700">
                                            {{ $guest->contact_number }}
                                        </h1>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div wire:key="923jfsjzjdfisdfw39r823sdcvkszdjcv"
                        x-animate>
                        <div class="rounded-lg bg-white p-3 shadow">
                            <div class="mb-2 flex">
                                <h1 class="text-lg font-semibold text-gray-800">
                                    Check In Details
                                </h1>
                            </div>
                            <div class="grid">
                                <div class="grid">
                                    <label class="text-sm text-gray-500">
                                        Room Number
                                    </label>
                                    <h1 class="text-gray-700">
                                        ROOM # {{ $guest->checkInDetail->room->number }}
                                    </h1>
                                </div>
                                <div class="grid border-t pt-2">
                                    <label class="text-sm text-gray-500">
                                        Staying Hours
                                    </label>
                                    <h1 class="text-gray-700">
                                        {{ $guest->checkInDetail->rate->staying_hour->number }}
                                        {{ Str::plural('Hour', $guest->checkInDetail->rate->staying_hour->number) }}
                                    </h1>
                                </div>
                                <div class="grid border-t pt-2">
                                    <label class="text-sm text-gray-500">
                                        Check In Date
                                    </label>
                                    <h1 class="text-gray-700">
                                        {{ Carbon\Carbon::parse($guest->check_in_at)->format('M d, Y h:i A') }}
                                    </h1>
                                </div>
                                <div class="grid border-t pt-2">
                                    <label class="text-sm text-gray-500">
                                        Expected Check Out Date
                                    </label>
                                    <h1 class="text-lg text-red-700">
                                        {{ Carbon\Carbon::parse($guest->checkInDetail->expected_check_out_at)->format('M d, Y H:i A') }}
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-8 rounded-lg bg-white p-2 shadow">
                    <div>
                        <div>

                        </div>

                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
