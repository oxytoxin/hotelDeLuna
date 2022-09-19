<div>
    <div class="">
        <div class="p-2 mb-2 space-y-1 bg-white border rounded-lg">
            <h1>Name : {{ auth()->user()->name }} </h1>
            @if ($this->designation)
                <h1>Floor : {{ ordinal($this->designation->floor->number) }} Floor </h1>
            @else
                <h1>Floor : Not Assigned </h1>
            @endif
            <h1>Cleaning : {{ auth()->user()->room_boy->is_cleaning ? 'YES' : 'NO' }} </h1>
        </div>
        @if (auth()->user()->room_boy->is_cleaning)
            <div class="p-2 mb-2 space-y-1 bg-white border border-red-500 rounded-lg">
                <h1>Currently cleaning : ROOM # {{ auth()->user()->room_boy->room->number }} </h1>
                <div>
                    <x-button wire:click="finish({{ auth()->user()->room_boy->room_id }})"
                        label="Finish"
                        negative />
                </div>
            </div>
        @endif
    </div>
    @if ($this->designation)
        <ul role="list"
            class="grid grid-cols-1 gap-6 py-5 border-t sm:grid-cols-4 lg:grid-cols-4">
            @forelse ($rooms->where('room_status_id',7) as $room)
                <li class="col-span-1 bg-white border divide-y divide-gray-200 rounded-lg shadow border-primary-700">
                    <div class="flex items-center justify-between w-full p-3 space-x-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-sm font-medium text-gray-900 truncate">
                                    Room # {{ $room->number }}
                                </h3>
                            </div>
                            @php
                                $timeToClean = new Carbon\Carbon($room->time_to_clean);
                                
                            @endphp
                            @if (!$timeToClean->isPast())
                                <x-countdown :expires="$timeToClean" />
                            @else
                                <p class="text-sm text-gray-500 truncate">Time to clean :
                                    <span class="text-red-500">{{ $timeToClean->diffForHumans() }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="flex -mt-px divide-x divide-gray-200">
                            <div class="flex flex-1 w-0 -ml-px">
                                <button type="button"
                                    wire:click="startRoomCleaning({{ $room->id }})"
                                    class="relative inline-flex items-center justify-center flex-1 w-0 py-4 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                    <span class="ml-3">
                                        Start
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="flex justify-center w-full">
                    <div class="flex items-center justify-center w-full p-3 space-x-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="font-medium text-gray-900 truncate ">
                                    No rooms to clean
                                </h3>
                            </div>
                        </div>
                    </div>
                </li>
            @endforelse
        </ul>
    @endif
</div>
