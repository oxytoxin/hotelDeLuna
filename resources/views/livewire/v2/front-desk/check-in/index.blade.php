<div>
    <div class="grid grid-cols-12 gap-5">
        <div class="col-span-8">
            <div>
                <div class="sm:flex sm:items-center sm:justify-between">
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
                                class="inline-flex items-center justify-center px-4 py-2 mt-1 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                                Search
                            </button>
                        @else
                            <button id="clearSearchButton"
                                type="button"
                                wire:click="clearSearch"
                                class="inline-flex items-center justify-center px-4 py-2 mt-1 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto">
                                Clear Search
                            </button>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col mt-4">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-primary-600">
                                        <tr>
                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-white uppercase sm:pl-6">
                                                QR Code
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Name
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Contact Number
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Room
                                            </th>
                                            <th scope="col"
                                                class="relative py-3 pl-3 pr-4 sm:pr-6">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200"
                                        wire:loading.class="opacity-60">
                                        @forelse ($guests as $guest)
                                            <tr wire:key="{{ $guest->id }}">
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
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    ROOM # {{ $guest->checkInDetail->room->number }}
                                                </td>
                                                <td
                                                    class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                    <button type="button"
                                                        wire:key="edit{{ $guest->id }}"
                                                        wire:click="viewGuest({{ $guest->id }})"
                                                        class="inline-flex items-center px-4 py-1 text-sm font-semibold text-white transition bg-yellow-500 rounded-full group hover:bg-yellow-600">
                                                        View
                                                        <svg class="mt-0.5 ml-2 -mr-1 stroke-white stroke-2"
                                                            fill="none"
                                                            width="10"
                                                            height="10"
                                                            viewBox="0 0 10 10"
                                                            aria-hidden="true">
                                                            <path class="transition opacity-0 group-hover:opacity-100"
                                                                d="M0 5h7"></path>
                                                            <path class="transition group-hover:translate-x-[3px]"
                                                                d="M1 1l4 4-4 4"></path>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"
                                                    class="py-4 pl-4 pr-3 text-sm font-medium text-center text-gray-900 whitespace-nowrap sm:pl-6">
                                                    No data found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        {{ $guests->links() }}
                    </div>
                </div>
            </div>

        </div>
        <div class="grid col-span-4 p-2 mb-10 space-y-5 border-l">
            <div>
                <h1 class="text-gray-600">
                    Recent Check In
                </h1>
                <ul role="list"
                    class="h-[380px] divide-y divide-green-200 overflow-y-auto rounded-lg bg-green-100 px-4 py-2">
                    @forelse ($recentlyCheckedInGuests as $recentGuest)
                        <li class="flex py-4">
                            <img class="w-10 h-10 rounded-full ring-2 ring-green-600"
                                src="https://ui-avatars.com/api/?name={{ $recentGuest->name }}&color=7F9CF5&background=EBF4FF"
                                alt="">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-900">
                                    {{ $recentGuest->name }} <span class="text-xs text-gray-400">
                                        ({{ Carbon\Carbon::parse($recentGuest->check_in_at)->diffForHumans() }})
                                    </span>
                                </p>
                                <p class="text-sm text-green-500">
                                    QR CODE : {{ $recentGuest->qr_code }}
                                </p>
                            </div>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
            <div>
                <h1 class="text-gray-600">
                    Terminated Guests
                </h1>
                <ul role="list"
                    class="h-[380px] divide-y divide-gray-200 overflow-y-auto rounded-lg bg-red-100 px-4 py-2">
                    @forelse ($terminatedGuests as $terminatedGuest)
                        <li class="flex py-4">
                            <img class="w-10 h-10 rounded-full ring-2 ring-green-600"
                                src="https://ui-avatars.com/api/?name={{ $terminatedGuest->name }}&color=7F9CF5&background=EBF4FF"
                                alt="">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-900">
                                    {{ $terminatedGuest->name }} <span class="text-xs text-gray-400">
                                        ({{ Carbon\Carbon::parse($terminatedGuest->check_in_at)->diffForHumans() }})
                                    </span>
                                </p>
                                <p class="text-sm text-green-500">
                                    QR CODE : {{ $terminatedGuest->qr_code }}
                                </p>
                            </div>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div wire:key="modals">
        <x-my.modal title="Check In Information"
            :showOn="['show-modal']"
            :closeOn="['close-modal']">
            <div class="overflow-hidden">
                @if ($viewGuest)
                    <div class="grid space-y-4">
                        <div class="p-2 bg-yellow-100 border border-yellow-300 rounded-lg sm:p-0">
                            <dl class="sm:divide-y sm:divide-yellow-200">
                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-3 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">QR Code</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        {{ $viewGuest->qr_code }}
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-3 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        {{ $viewGuest->name }}
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-3 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        {{ $viewGuest->contact_number }}
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-3 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Room Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        Room # {{ $viewGuest->checkInDetail->room->number }}
                                    </dd>
                                </div>

                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-3 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Hours</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        {{ $viewGuest->checkInDetail->rate->staying_hour->number }}
                                        {{ Str::plural('hour', $viewGuest->checkInDetail->rate->staying_hour->number) }}
                                    </dd>
                                </div>

                            </dl>
                        </div>
                        <div>
                            <dl
                                class="p-4 text-sm bg-green-100 border border-green-400 divide-y divide-green-200 rounded-lg lg:col-span-5 lg:mt-0">
                                @foreach ($viewGuest->transactions as $transaction)
                                    <div class="flex items-center justify-between py-4">
                                        <dt class="text-gray-600">
                                            {{ $transaction->remarks }}
                                        </dt>
                                        <dd class="font-medium text-gray-900">
                                            ₱ {{ $transaction->payable_amount }}
                                        </dd>
                                    </div>
                                @endforeach
                                <div class="flex items-center justify-between pt-4">
                                    <dt class="font-medium text-gray-900">Total Amount</dt>
                                    <dd class="text-lg font-medium text-primary-600">
                                        ₱ {{ $guestTotalAmountToPay }}
                                    </dd>
                                </div>
                                <div x-data="{ guestExcessAmount: $wire.entangle('guestExcessAmount') }"
                                    class="grid grid-cols-1 gap-3 pt-2 mt-2">
                                    <x-my.input type="number"
                                        label="Amount Paid"
                                        wire:model.debounce.500ms="guestGivenAmount"
                                        numberOnly
                                        placeholder="Enter amount" />
                                    <div x-show="guestExcessAmount > 0"
                                        x-collapse
                                        class="grid grid-cols-1 gap-3">
                                        <x-my.input type="number"
                                            label="Excess Amount"
                                            disabled
                                            wire:model.defer="guestExcessAmount"
                                            numberOnly />
                                        <div class="flex items-center space-x-3">
                                            <input id="deposit"
                                                aria-describedby="comments-description"
                                                name="deposit"
                                                type="checkbox"
                                                wire:model.defer="saveToDeposit"
                                                class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500">
                                            <span>
                                                Save excess amount as deposit
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </dl>
                        </div>
                    </div>
                @endif
            </div>
            <x-slot name="footer">
                <div class="flex space-x-3">
                    <x-my.button-danger label="Cancel"
                        x-on:click="close()" />
                    <x-my.button-success label="Check In"
                        x-on:click="$dispatch('confirm',{
                            title : 'Are you sure?',
                            message : 'This will check in the guest.',
                            confirmButtonText : 'Continue', 
                            cancelButtonText : 'No', 
                            confirmMethod : 'confirmCheckIn',
                      })" />
                </div>
            </x-slot>
        </x-my.modal>
    </div>
</div>
