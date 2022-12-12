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
            <div x-data="{ openGuestInfo: true }"
                class="grid grid-cols-12 gap-5"
                x-animate>
                <template x-if="openGuestInfo">
                    <div x-show="openGuestInfo"
                        wire:key="99892398423jkjlsdjfskdlfjksjdklmvxclvlksdjflkse"
                        class="col-span-3 grid gap-3 duration-150">
                        <div>
                            <div class="rounded-lg bg-white p-3 shadow">
                                <div wire:key="doja8324i2o3joirwf89c793q7c9r8"
                                    class="mb-2 flex">
                                    <h1 class="text-lg font-semibold text-gray-800">
                                        Guest Details
                                    </h1>
                                </div>
                                <div class="grid gap-5">
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
                                        <div class="rounded-lg bg-gray-100 p-3 shadow">
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
                                                        Initial Check In Hour
                                                    </label>
                                                    <h1 class="text-gray-700">
                                                        {{ $guest->checkInDetail->rate->staying_hour->number }}
                                                        {{ Str::plural('Hour', $guest->checkInDetail->rate->staying_hour->number) }}
                                                    </h1>
                                                </div>
                                                <div class="grid border-t pt-2">
                                                    <label class="text-sm text-gray-500">
                                                        Time Remaining
                                                    </label>
                                                    <h1 class="text-gray-700">
                                                        @php
                                                            $expiredAt = Carbon\Carbon::parse($guest->checkInDetail->expected_check_out_at);
                                                        @endphp
                                                        <x-countdown :expires="$expiredAt">
                                                            <div class="flex space-x-2 text-xs"
                                                                x-bind:class="timer.hours == '00' ? 'text-red-600' :
                                                                    'text-green-600'">
                                                                <div class="flex space-x-1">
                                                                    <span
                                                                        x-text="timer.days">{{ $component->days() }}</span>
                                                                    <span> days -</span>
                                                                </div>
                                                                <div class="flex space-x-1">
                                                                    <span
                                                                        x-text="timer.hours">{{ $component->hours() }}</span>
                                                                    <span> hrs -</span>
                                                                </div>
                                                                <div class="flex space-x-1">
                                                                    <span
                                                                        x-text="timer.minutes">{{ $component->minutes() }}</span>
                                                                    <span> mins-</span>
                                                                </div>
                                                                <div class="flex space-x-1">
                                                                    <span
                                                                        x-text="timer.seconds">{{ $component->seconds() }}</span>
                                                                    <span>secs</span>
                                                                </div>
                                                            </div>
                                                        </x-countdown>
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
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <div x-bind:class="openGuestInfo ? 'translate-x-0  duration-300 ease-in-out' :
                    'col-span-12  duration-300 ease-in-out'"
                    class="col-span-9 rounded-lg bg-white shadow">

                    {{-- <button type="button"
                        x-on:click="openGuestInfo = !openGuestInfo"
                        class="absolute top-2 -left-4 inline-flex items-center rounded-full border border-transparent bg-primary-600 p-1.5 text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            x-bind:class="openGuestInfo ? '' : 'transform rotate-180'"
                            class="h-6 w-6 duration-150">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                        </svg>
                    </button> --}}
                    @switch($activeTab)
                        @case(1)
                            <div wire:key="cccdsjfjdfsdiofsiodfu">
                                @livewire('v2.front-desk.transactions.transactions', [
                                    'guest_id' => $guest->id,
                                ])
                            </div>
                        @break

                        @case(2)
                            <div wire:key="jcjascni823jawjhfdalsndfasc">
                                @livewire('v2.front-desk.transactions.transfer-room', [
                                    'guestId' => $guest->id,
                                    'newRoomTypeId' => $guest->checkInDetail->room->type_id,
                                    'newRoomFloorId' => $guest->checkInDetail->room->floor_id,
                                    'oldCheckInRateId' => $guest->checkInDetail->rate_id,
                                    'oldCheckInStayingHourId' => $guest->checkInDetail->rate->staying_hour_id,
                                    'guestCheckInTime' => $guest->check_in_at,
                                    'oldRoomId' => $guest->checkInDetail->room_id,
                                    'oldRoomNumber' => $guest->checkInDetail->room->number,
                                    'oldRoomTypeName' => $guest->checkInDetail->room->type->name,
                                    'guestCheckInDetailId' => $guest->checkInDetail->id,
                                    'isLongStay' => $guest->checkInDetail->is_long_stay,
                                    'numberOfDays' => $guest->checkInDetail->number_of_days,
                                ])
                            </div>
                        @break

                        @case(3)
                            @livewire('v2.front-desk.transactions.extend', [
                                'guestId' => $guest->id,
                                'guestCheckInDetailId' => $guest->checkInDetail->id,
                                'checkInDetailStaticHourStayed' => $guest->checkInDetail->static_hours_stayed,
                                'checkInDetailRoomId' => $guest->checkInDetail->room_id,
                                'checkInDetailRoomTypeId' => $guest->checkInDetail->room->type_id,
                                'checkInDetailRoomRateAmount' => $guest->checkInDetail->rate->amount,
                                'checkInDetailExpectedCheckOutAt' => $guest->checkInDetail->expected_check_out_at,
                            ])
                            {{-- @livewire('front-desk.transactions.extend-hours', [
                                'check_in_detail_id' => $guest->checkInDetail->id,
                                'guest_id' => $guest->id,
                            ]) --}}
                        @break

                        @case(4)
                            <div wire:key="e23q9knklncascowadihjowajioioj">
                                @livewire('v2.front-desk.transactions.damage-charges', [
                                    'guestId' => $guest->id,
                                    'checkInRoomId' => $guest->checkInDetail->room_id,
                                ])
                            </div>
                        @break

                        @case(5)
                            <div wire:key="9099adsjijdjasjdsajkjklklj">
                                @livewire('v2.front-desk.transactions.amenities', [
                                    'guestId' => $guest->id,
                                    'checkInRoomId' => $guest->checkInDetail->room_id,
                                ])
                            </div>
                        @break

                        @case(6)
                            <div wire:key="hwqjqnnenwqlkewqlkej">
                                @livewire('v2.front-desk.transactions.food-and-beverage', [
                                    'guestId' => $guest->id,
                                    'guestCheckInRoomId' => $guest->checkInDetail->room_id,
                                ])
                            </div>
                        @break

                        @case(7)
                            <div wire:key="dasmqeqiwejqndnajsdas">
                                @livewire('v2.front-desk.transactions.deposits', [
                                    'guestId' => $guest->id,
                                    'guestCheckInRoomId' => $guest->checkInDetail->room_id,
                                ])
                            </div>
                        @break
                    @endswitch
                </div>
            </div>
        @endif
    </div>
    @livewire('v2.pay-with-deposits')
</div>
