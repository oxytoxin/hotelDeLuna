<div class="grid gap-4">
    <div class="grid gap-3">
        <x-card padding="px-2 py-3 md:px-4 "
            cardClasses="bg-green-600 ">
            <h1 class="text-xl font-semibold text-white">
                Priority Rooms
            </h1>
        </x-card>
        @php
            $priority_rooms = $rooms->where('priority', 1)->where('room_status_id', 1);
        @endphp
        <ul role="list"
            class="grid grid-cols-1 gap-6 sm:grid-cols-4 lg:grid-cols-4">
            @foreach ($priority_rooms as $room)
                <li class="col-span-1 bg-white divide-y divide-gray-200 rounded-lg shadow">
                    <div class="flex items-center justify-between w-full p-3 space-x-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-sm font-bold text-gray-900 truncate">
                                    ROOM # {{ $room->room_number }}
                                </h3>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 truncate">
                                {{ ordinal($room->floor->number) }} Floor
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="flex-shrink-0 w-8 h-8 text-green-600">
                            <path fill-rule="evenodd"
                                d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 00-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 00.75-.75v-1.5h1.5A.75.75 0 009 19.5V18h1.5a.75.75 0 00.53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1015.75 1.5zm0 3a.75.75 0 000 1.5A2.25 2.25 0 0118 8.25a.75.75 0 001.5 0 3.75 3.75 0 00-3.75-3.75z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </li>
            @endforeach
        </ul>
        <div>
            @if (count($priority_rooms) == 0)
                <x-card padding="px-2 py-3 md:px-4 "
                    cardClasses="bg-green-100 ">
                    <h1 class="text-xl font-semibold text-center text-green-600">
                        Priority Room is Empty
                    </h1>
                </x-card>
            @endif
        </div>
    </div>
    <hr>
    <div class="grid gap-3">
        <x-card padding="px-2 py-3 md:px-4 "
            cardClasses="bg-red-600">
            <h1 class="text-xl font-semibold text-white">
                Available Rooms (Cleaned Room)
            </h1>
        </x-card>
        @php
            $available_rooms = $rooms->where('priority', false)->where('room_status_id', 9);
        @endphp
        <ul role="list"
            class="grid grid-cols-1 gap-6 sm:grid-cols-4 lg:grid-cols-4">
            @foreach ($available_rooms as $room)
                <li class="col-span-1 bg-white divide-y divide-gray-200 rounded-lg shadow">
                    <div class="flex items-center justify-between w-full p-3 space-x-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-sm font-bold text-gray-900 truncate">
                                    ROOM # {{ $room->room_number }}
                                </h3>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 truncate">
                                {{ ordinal($room->floor->number) }} Floor
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="flex-shrink-0 w-8 h-8 text-green-600">
                            <path fill-rule="evenodd"
                                d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 00-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 00.75-.75v-1.5h1.5A.75.75 0 009 19.5V18h1.5a.75.75 0 00.53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1015.75 1.5zm0 3a.75.75 0 000 1.5A2.25 2.25 0 0118 8.25a.75.75 0 001.5 0 3.75 3.75 0 00-3.75-3.75z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex -mt-px divide-x divide-gray-200">
                            <div class="flex flex-1 w-0">
                                <button type="button"
                                    wire:click="setAsPriority({{ $room->id }})"
                                    class="relative inline-flex items-center justify-center flex-1 w-0 py-4 -mr-px text-sm font-medium text-green-600 border border-transparent rounded-bl-lg hover:text-green-500 hover:underline">
                                    <span class="ml-3 ">
                                        Move to Priority
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                        class="w-6 h-6 ">
                                        <path fill-rule="evenodd"
                                            d="M3.75 12a.75.75 0 01.75-.75h13.19l-5.47-5.47a.75.75 0 011.06-1.06l6.75 6.75a.75.75 0 010 1.06l-6.75 6.75a.75.75 0 11-1.06-1.06l5.47-5.47H4.5a.75.75 0 01-.75-.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div>
            @if (count($available_rooms) == 0)
                <x-card padding="px-2 py-3 md:px-4 "
                    cardClasses="bg-red-100 ">
                    <h1 class="text-xl font-semibold text-center text-red-600">
                        Available Room is Empty
                    </h1>
                </x-card>
            @endif
        </div>
    </div>
</div>
