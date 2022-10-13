<div>
    <div>
        <x-modal.card title="CHECK IN"
            max-width="4xl"
            wire:model.defer="showModal">
            <div>
                @if ($guest)
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
                                <dt class="text-sm font-bold text-gray-900">Transaction | Bills</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-3 sm:mt-0">
                                    <ul role="list"
                                        class="border border-gray-200 divide-y divide-gray-200 rounded-md">
                                        @foreach ($transactions as $transaction)
                                            <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                <div class="flex items-center justify-between flex-1 w-0">
                                                    <span class="flex-1 w-0 ml-2 truncate">
                                                        {{ $transaction->transaction_type->name }} |
                                                        @if ($transaction->transaction_type_id == 1)
                                                            ROOM # {{ $transaction->check_in_detail->room->number }}
                                                            ({{ $transaction->check_in_detail->room->type->name }})
                                                            for
                                                            {{ $transaction->check_in_detail->static_hours_stayed }} hrs
                                                        @endif
                                                        @if ($transaction->transaction_type_id == 2)
                                                            Initial Deposit for Remote and Room Key
                                                        @endif
                                                    </span>
                                                    <div>
                                                        <span> ₱{{ $transaction->payable_amount }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </dd>
                            </div>
                        </dl>
                        <div class="flex items-center mt-5 space-x-4">
                            <h1 class="flex items-center space-x-2 font-semibold text-gray-800">
                                <span> Total Amount: </span>
                                @if ($discounted_amount > 0)
                                    <span class="text-red-500">
                                        (Checked in room amount -
                                        ₱ {{ $discounted_amount }})</span>
                                @endif
                                <span> ₱{{ $guest->transactions->sum('payable_amount') - $discounted_amount }}</span>
                            </h1>
                        </div>
                        {{-- <div class="mt-4">
                            <div class="grid grid-cols-4 gap-4">
                                @foreach ($discounts as $discount)
                                    <button
                                        wire:click="selectDiscount({{ $discount->id }},'{{ $discount->amount }}','{{ $discount->is_percentage }}')"
                                        class="relative col-span-1 py-2 px-3.5 border border-gray-300 shadow rounded-lg hover:bg-gray-50">
                                        <div class="grid justify-start space-y-2 text-xs">
                                            <h1>
                                                {{ $discount->name }}
                                            </h1>
                                            <h1 class="text-red-500">
                                                -
                                                @if ($discount->is_percentage == false)
                                                    ₱
                                                @endif
                                                {{ $discount->amount }}
                                                @if ($discount->is_percentage)
                                                    %
                                                @endif
                                            </h1>
                                        </div>
                                        <div class="absolute top-1 right-1">
                                            @php
                                                $array = [
                                                    'id' => $discount->id,
                                                    'amount' => $discount->amount,
                                                    'is_percentage' => $discount->is_percentage,
                                                ];
                                            @endphp
                                            @if (in_array($array, $selectedDiscounts))
                                                <span class="text-xs text-green-600"> Applied</span>
                                            @endif
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div> --}}
                    </div>
                @endif
            </div>
            <x-slot:footer>
                <x-button wire:click="confirmCheckIn"
                    positive
                    spinner="confirmCheckIn">
                    Pay and Check In
                </x-button>
            </x-slot:footer>
        </x-modal.card>
    </div>
</div>
