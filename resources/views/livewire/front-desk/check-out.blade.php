<div class="space-y-4">
    <div class="border border-gray-200 rounded-lg ">
        <x-card shadow="shadow-none"
            padding="p-2 md:p-2">
            <div class="flex space-x-3">
                <x-input placeholder="Search"
                    wire:model.defer="search"
                    icon="search" />
                <x-button label="Search QR Code"
                    wire:click="search('1')"
                    spinner="search('1')"
                    icon="search"
                    primary />
                <x-button label="Search Contact Number"
                    wire:click="search('3')"
                    spinner="search('3')"
                    icon="search"
                    primary />
                <x-button label="Search Room"
                    wire:click="search('2')"
                    spinner="search('2')"
                    icon="search"
                    primary />
            </div>
        </x-card>
    </div>
    <div class="border border-gray-200 rounded-lg ">
        <x-card shadow="shadow-none"
            title="Check Out">
            @if ($guest && $realSearch != '')
                <div>
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-2">
                            <dt class="text-sm font-medium text-gray-500">QR Code</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                {{ $guest->qr_code }}
                            </dd>
                        </div>
                        <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-2">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                {{ $guest->name }}
                            </dd>
                        </div>
                        <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-2">
                            <dt class="text-sm font-medium text-gray-500">
                                Contact Number
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                {{ $guest->contact_number }}
                            </dd>
                        </div>
                        <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-2">
                            <dt class="text-sm font-medium text-gray-500">
                                Check In At
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                {{ $guest->check_in_at }}
                            </dd>
                        </div>
                        <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-2">
                            <dt class="text-sm font-bold text-gray-700 ">Transaction | Bills</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-3 sm:mt-0">
                                <ul role="list"
                                    class="border border-gray-200 divide-y divide-gray-200 rounded-md">
                                    @foreach ($transactions as $transaction)
                                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex items-center flex-1 w-0">
                                                <span class="flex-1 w-0 ml-2 truncate">
                                                    {{ $transaction->transaction_type->name }} |
                                                    ₱{{ $transaction->payable_amount }} @if ($transaction->transaction_type_id == 1)
                                                        | ROOM # {{ $transaction->check_in_detail->room->number }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="flex-shrink-0 ml-4">
                                                @if ($transaction->paid_at)
                                                    @if ($transaction->transaction_type_id == 1 && $transaction->check_in_detail->check_out_at == null)
                                                        <x-button label="Check Out"
                                                            wire:click="checkOut({{ $transaction->id }})"
                                                            sm
                                                            primary />
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-6 h-6 text-green-600">
                                                            <path stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    @endif
                                                @else
                                                    <button type="button"
                                                        wire:click="pay({{ $transaction->id }})"
                                                        class="flex items-center space-x-2 font-medium text-green-600 hover:text-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                                        </svg>
                                                        <span> Pay</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </dd>
                        </div>
                        <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-2">
                            <dt class="text-sm font-bold text-gray-700 ">Damages</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-3 sm:mt-0">
                                <ul role="list"
                                    class="border border-gray-200 divide-y divide-gray-200 rounded-md">
                                    @forelse ($damages as $damage)
                                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex items-center flex-1 w-0">
                                                <span class="flex-1 w-0 ml-2 truncate">
                                                    {{ $damage->item }} | ₱{{ $damage->payable_amount }}
                                                </span>
                                            </div>
                                            <div class="flex-shrink-0 ml-4">
                                                @if ($damage->paid_at)
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="w-6 h-6 text-green-600">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @else
                                                    <button type="button"
                                                        wire:click="payDamage({{ $damage->id }})"
                                                        class="flex items-center space-x-2 font-medium text-green-600 hover:text-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                                        </svg>
                                                        <span> Pay</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </li>
                                    @empty
                                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex items-center flex-1 w-0">
                                                <span class="flex-1 w-0 ml-2 truncate">
                                                    No damage charges
                                                </span>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </dd>
                        </div>
                    </dl>
                </div>
                <x-slot:footer>
                    <div class="flex items-center justify-between">
                        @php
                            $total = $guest->transactions->where('paid_at', null)->sum('payable_amount') + $damages->where('paid_at', null)->sum('payable_amount');
                        @endphp
                        <h1 class="text-lg font-semibold">Balance :
                            ₱ {{ $total }}
                        </h1>
                        <x-button wire:click="totalyCheckOutGuest"
                            spinner="totalyCheckOutGuest"
                            label="Check Out Guest"
                            negative />
                    </div>
                </x-slot:footer>
            @else
            @endif
        </x-card>
    </div>
</div>
