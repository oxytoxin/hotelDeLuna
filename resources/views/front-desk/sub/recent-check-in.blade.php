<div x-data>
    <div id="header">
        <div class="px-4 py-2 shadow-md border rounded-lg flex justify-center bg-white mb-3">
            <h1 class="text-gray-600">
                Recent Check In
            </h1>
        </div>
        <ul role="list"
            class="space-y-3"
            x-animate>
            @foreach ($recent_check_in_list as $guest)
                <li wire:key="{{ $guest->qr_code }}"
                    class="overflow-hidden rounded-md bg-white px-6 py-4 shadow">
                    <div class="w-full flex justify-between">
                        <h1>
                            {{ $guest->name }}
                        </h1>
                        <h1>
                            {{ $guest->qr_code }}
                        </h1>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
