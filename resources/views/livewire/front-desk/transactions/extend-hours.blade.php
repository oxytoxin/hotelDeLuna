<div x-intersect.once="$wire.visible">
    @if ($tabIsVisible)
        @if ($branch_extension_resetting_time != null)
            <div class="grid gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <x-card title="Extend">
                            <form class="grid grid-cols-2 gap-3">
                                @csrf
                                <x-native-select label="Select Hour"
                                    wire:model="form.extension_id">
                                    <option value="">Select</option>
                                    @foreach ($available_hours_for_extension_with_in_this_branch as $extention)
                                        <option value="{{ $extention->id }}">
                                            {{ $extention->hours }} {{ Str::plural('hour', $extention->hours) }}
                                        </option>
                                    @endforeach
                                </x-native-select>
                                <x-input label="Amount"
                                    disabled
                                    wire:model="form.amount_to_be_paid" />
                            </form>
                            <x-slot:footer>
                                <div class="flex items-center space-x-3">
                                    <x-button negative
                                        label="Clear" />
                                    <x-button emerald
                                        wire:click="save"
                                        spinner="save"
                                        label="Save" />
                                </div>
                            </x-slot:footer>
                        </x-card>
                    </div>
                </div>
                <div wire:key="salkjhfdq98ehrlkahfznkcvneiuhf9q328">
                    <x-card title="Transactions">
                        <x-transactions :headers="['Details', 'Amount', 'Paid At', 'Date']">
                            <x-slot:body>
                                @forelse ($transactions as $key => $transaction)
                                    <tr wire:key="{{ $key . $transaction->id }}">
                                        <x-transactions.cell>
                                            {{ $transaction->remarks }}
                                        </x-transactions.cell>
                                        <x-transactions.cell>
                                            {{ $transaction->payable_amount }}
                                        </x-transactions.cell>
                                        <x-transactions.cell>
                                            @if ($transaction->paid_at)
                                                {{ Carbon\Carbon::parse($transaction->paid_at)->format('M d, Y h:i:s A') }}
                                            @else
                                                <button type="button"
                                                    wire:click="payTransaction({{ $transaction->id }})"
                                                    class="text-green-600 hover:text-green-900">
                                                    <span> Pay </span>
                                                </button>
                                            @endif
                                        </x-transactions.cell>
                                        <x-transactions.cell>
                                            {{ $transaction->created_at }}
                                        </x-transactions.cell>
                                    </tr>
                                @empty
                                    <tr>
                                        <x-transactions.cell colspan="4">
                                            No transactions found
                                        </x-transactions.cell>
                                    </tr>
                                @endforelse
                            </x-slot:body>
                        </x-transactions>
                    </x-card>
                </div>
            </div>
        @else
            <div class="p-4 border border-red-500 rounded-md bg-red-50 sm:col-span-2">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: mini/x-circle -->
                        <svg class="w-5 h-5 text-red-400"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Extension resetting time is not set in your Admin Account
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul role="list"
                                class="pl-5 space-y-1 list-disc">
                                <li>
                                    Login to your Admin Account
                                </li>
                                <li>
                                    Go to Settings > Extension Resetting Time > click SET
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
