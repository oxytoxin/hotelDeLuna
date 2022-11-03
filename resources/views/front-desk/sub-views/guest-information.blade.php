{{-- <div class="space-y-5">
    <div wire:key="{{ $guest->id }}-guest-information"
        class="m-1 overflow-hidden bg-white border border-gray-300 shadow sm:rounded-lg">
        <div class="px-4 py-3 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Guest Information</h3>
        </div>
        <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Qr Code</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $guest?->qr_code }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Full name</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $guest?->name }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $guest?->contact_number }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Check in at
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $guest?->check_in_at }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
    <div wire:key="{{ $guest->id }}-check-in-detials">
        <div class="flex items-center px-3 mb-2 space-x-3">
            <button class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span> Extend</span>
            </button>
            <span class="text-gray-400">|</span>
            <button class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                </svg>
                <span> Change Room</span>
            </button>
        </div>
        <div class="m-1 overflow-hidden bg-white border border-gray-300 shadow sm:rounded-lg">
            <div class="px-4 py-3 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Check In Details</h3>
            </div>
            <div class="px-4 py-5 border-t border-gray-200 sm:px-6">

                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Room</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            ROOM #
                            {{ $check_in_detail->room->number }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Time Remaining
                        </dt>
                        <div wire:key="{{ $check_in_detail->expected_check_out_at . $check_in_detail->id . $guest->id }}"
                            class="mt-1 text-sm text-gray-900">
                            <x-countdown :expires="Carbon\Carbon::parse($check_in_detail->expected_check_out_at)" />
                        </div>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div> --}}

<div wire:key="{{ $this->guest->id }}-information"
    x-show="currentTab == 0"
    class="overflow-hidden bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">
            Guest Information and Check In Details
        </h3>
    </div>
    <div class="px-4 py-5 border-t border-gray-200 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200">
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Guest Name
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    {{ $this->guest->name }}
                </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Contact Number
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    {{ $this->guest->contact_number }}
                </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Room Number
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    Room #{{ $this->guest->transactions[0]->check_in_detail->room->number }}
                </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Check In Time
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    {{ $this->guest->transactions[0]->check_in_detail->static_hours_stayed }} Hrs
                </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Check In At
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    {{ Carbon\Carbon::parse($this->guest->check_in_at)->format('M d, Y h:i A') }}
                </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Expected Check Out
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    {{ Carbon\Carbon::parse($this->guest->transactions[0]->check_in_detail->expected_check_out_at)->format('M d, Y h:i A') }}
                </dd>
            </div>
        </dl>
    </div>
</div>
