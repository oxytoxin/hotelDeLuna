<div>
    <div>
        @php
            $headers = ['Room Number', 'Status', 'Alert For Checkout', 'Time To Clean', ''];
        @endphp
        <div class="mt-5">
            <div class="flex flex-col">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <div class="flex justify-between px-2 py-3 bg-white border-b border-gray-200 sm:px-6">
                                <div class="flex space-x-2">
                                    <x-input placeholder="Search"
                                        wire:model.debounce.500ms="search"
                                        icon="search" />
                                    <x-native-select wire:model='status_filter'
                                        placeholder="Room Status">
                                        <option value="">All</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </x-native-select>
                                </div>
                                <div>
                                </div>
                            </div>
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-primary-600">
                                    <tr>
                                        @foreach ($headers as $header)
                                            <th scope="col"
                                                class="py-3 pr-3 text-xs font-medium tracking-wide text-left text-white uppercase sm:pl-4">
                                                {{ $header }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($rooms as $room)
                                        <tr @class([
                                            'text-green-600' => $room->room_status_id == 1,
                                            'text-red-600' => $room->room_status_id == 7,
                                        ])>
                                            <td class="py-4 pl-4 pr-3 text-sm font-medium whitespace-nowrap sm:pl-6">
                                                ROOM # {{ $room->number }} | {{ ordinal($room->floor->number) }} Floor
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                {{ $room->room_status->name }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                <div>
                                                    @if ($room->room_status_id == 2 && count($room->check_in_details))
                                                        @php
                                                            $expires = new Carbon\Carbon($room->check_in_details[0]->expected_check_out_at);
                                                        @endphp
                                                        @if ($expires->isPast())
                                                            <span class="text-red-500">
                                                                Time Out :{{ $expires->diffForHumans() }}
                                                            </span>
                                                        @else
                                                            <x-countdown :expires="$expires">
                                                                <div class="flex space-x-2"
                                                                    x-bind:class="timer.hours == '00' ? 'text-red-600' :
                                                                        'text-green-600'">
                                                                    <div class="flex space-x-1">
                                                                        <span
                                                                            x-text="timer.days">{{ $component->days() }}</span>
                                                                        <span> days -</span>
                                                                    </div>
                                                                    <div class="flex space-x-1">
                                                                        <span
                                                                            x-text="timer.hours">{{ $component->hours() }}</span>
                                                                        <span> hours -</span>
                                                                    </div>
                                                                    <div class="flex space-x-1">
                                                                        <span
                                                                            x-text="timer.minutes">{{ $component->minutes() }}</span>
                                                                        <span> minutes -</span>
                                                                    </div>
                                                                    <div class="flex space-x-1">
                                                                        <span
                                                                            x-text="timer.seconds">{{ $component->seconds() }}</span>
                                                                        <span>seconds</span>
                                                                    </div>
                                                                </div>
                                                            </x-countdown>
                                                        @endif
                                                    @else
                                                        --
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                @if ($room->time_to_clean)
                                                    @php
                                                        $time_to_clean = new Carbon\Carbon($room->time_to_clean);
                                                    @endphp
                                                    @if ($time_to_clean->isPast())
                                                        <span class="text-red-500">
                                                            {{ $time_to_clean->diffForHumans() }}
                                                        </span>
                                                    @else
                                                        <div class="relative flex space-x-2">
                                                            <x-countdown :expires="$time_to_clean">
                                                                <span x-cloak
                                                                    x-show="timer.hours == '00'"
                                                                    class="absolute p-2 text-white bg-red-600 rounded-r-lg rounded-tl-lg -top-5 -right-10 animate-bounce">
                                                                    About to due
                                                                </span>
                                                                <div class="flex space-x-2 ">
                                                                    <div class="flex space-x-1">
                                                                        <span
                                                                            x-text="timer.hours">{{ $component->hours() }}</span>
                                                                        <span> hours -</span>
                                                                    </div>
                                                                    <div class="flex space-x-1">
                                                                        <span
                                                                            x-text="timer.minutes">{{ $component->minutes() }}</span>
                                                                        <span> minutes -</span>
                                                                    </div>
                                                                    <div class="flex space-x-1">
                                                                        <span
                                                                            x-text="timer.seconds">{{ $component->seconds() }}</span>
                                                                        <span>seconds</span>
                                                                    </div>
                                                                </div>
                                                            </x-countdown>
                                                            @if ($room->room_status_id == 8)
                                                                <span title="Room is currently being cleaned">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none"
                                                                        viewBox="0 0 24 24"
                                                                        stroke-width="1.5"
                                                                        stroke="currentColor"
                                                                        class="w-4 h-4 text-green-600 animate-spin">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    </svg>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @else
                                                    --
                                                @endif

                                            </td>
                                            <td
                                                class="relative py-3 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7"
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                No Room Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="py-2">
                            {{ $rooms->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
