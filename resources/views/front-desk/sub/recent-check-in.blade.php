<div x-data>
    <div id="header">
        <div class="flex justify-center px-4 py-2 mb-3 bg-white border rounded-lg shadow-md">
            <h1 class="text-gray-600">
                Recent Check In
            </h1>
        </div>
        <ul role="list"
            class="space-y-3"
            x-animate>
            @foreach ($recent_check_in_list as $guest)
                <li wire:key="{{ $guest->qr_code }}"
                    class="px-6 py-4 overflow-hidden text-green-800 bg-green-100 border-2 border-green-600 rounded-md shadow">
                    <div class="flex justify-between w-full">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h1>
                                {{ $guest->name }}
                            </h1>
                        </div>
                        <h1>
                            {{ $guest->qr_code }}
                        </h1>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
