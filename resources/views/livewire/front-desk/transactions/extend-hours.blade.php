<div class="gap-4 sm:grid sm:grid-cols-2">
    @if ($branch_extension_resetting_time != null)
        <div class="sm:col-span-1">
            <x-card shadow="sm"
                title="Extend Hours"
                cardClasses="border border-gray-300">
                <form class="grid grid-cols-1 gap-3">
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
                        <x-button label="Clear" />
                        <x-button primary
                            wire:click="save"
                            spinner="save"
                            label="Save" />
                    </div>
                </x-slot:footer>
            </x-card>
        </div>
        <div class="sm:col-span-1">
            <div class="grid gap-1">
                <div class="flex items-center justify-between">
                    <h1 class="text-center text-gray-600">
                        Room Change History
                    </h1>
                    <div wire:key="{{ $history_order }}-button">
                        <button wire:click="historyOrderToggle"
                            type="button"
                            class="flex items-center space-x-2 text-gray-600">
                            <span>{{ $history_order == 'ASC' ? 'Oldest' : 'Newest' }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div wire:key="history-list"
                    x-animate>
                    @forelse ($extension_history as $extension)
                        <div wire:key="{{ $extension->id }}"
                            class="p-2 mb-2 bg-white border rounded-lg">
                            <div class="flex justify-between w-full">
                                <div class="flex items-center space-x-2 text-gray-600">
                                    <h1>
                                        {{ $extension->hours }} Hours
                                    </h1>
                                    <h1>
                                        -
                                    </h1>
                                    <h1>
                                        ₱ {{ $extension->amount }}
                                    </h1>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div wire:key="empty"
                            class="p-2 mb-2 bg-white border rounded-lg">
                            <div class="flex justify-between w-full">
                                <div class="flex items-center space-x-2 text-gray-600">
                                    <h1>
                                        No record fount
                                    </h1>
                                </div>
                            </div>
                        </div>
                    @endforelse

                </div>
                <div>
                    <div>
                        Extended Hours :
                        {{ $extension_history->sum('hours') }} Hours
                    </div>
                    <div>
                        Checked in Hours : {{ $check_in_detail->rate->staying_hour->number }} Hours
                    </div>
                    Total : {{ $extension_history->sum('hours') + $check_in_detail->rate->staying_hour->number }} Hours
                </div>
            </div>
        </div>
    @else
        <div class="rounded-md bg-red-50 p-4 sm:col-span-2 border border-red-500">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: mini/x-circle -->
                    <svg class="h-5 w-5 text-red-400"
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
                            class="list-disc space-y-1 pl-5">
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
</div>
