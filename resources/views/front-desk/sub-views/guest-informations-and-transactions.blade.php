<div class="space-y-5">
    <div wire:key="{{ $guest->id }}-guest-information">
        <x-card title="Guest Information">
            <div class="">
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
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Expected Check Out
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $guest?->transactions->where('transaction_type_id', 1)->first()->check_in_detail->expected_check_out_at }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Initial Check In
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $guest?->transactions->where('transaction_type_id', 1)->first()->check_in_detail->static_hours_stayed }}
                            hrs
                        </dd>
                    </div>
                </dl>
            </div>
        </x-card>
    </div>
</div>
