<div>
  {{-- <div class="">
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
</div> --}}

  <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
    <h1 class="sr-only">Profiles</h1>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
      <!-- Left column -->
      <div class="grid grid-cols-1 gap-4 lg:col-span-2">
        <!-- Welcome panel -->
        <section aria-labelledby="profile-overview-title">
          <div
            class=" {{ \App\Models\Designation::where('room_boy_id', auth()->user()->room_boy->id)->exists() == false ? 'border-red-500' : 'border-white' }} overflow-hidden rounded-3xl lg:rounded-2xl border-4 relative  bg-gray-50   shadow-lg">
            <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
            <div class="bg-white p-6">
              <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex sm:space-x-5">
                  <div class="flex-shrink-0">
                    <div class="relative h-20 w-20 mx-auto">
                      <img src="{{ auth()->user()->profile_photo_url }}"
                        class="h-20 w-20  rounded-full border-4 flex-shrink-0 mx-auto border-green-500" alt="">
                      <div class="absolute bottom-0 right-0">
                        <x-button.circle href="{{ route('profile.show') }}" xs dark icon="camera" />
                      </div>
                    </div>
                  </div>
                  <div class="mt-4 lg:mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">

                    <p class="text-xl font-bold text-gray-700  uppercase sm:text-2xl">
                      {{ auth()->user()->name }}
                    </p>
                    <p class="text-sm font-medium text-gray-600">{{ auth()->user()->role->name }}
                    </p>
                  </div>
                </div>
                <div class="mt-5 flex justify-center sm:mt-0">
                  <div class="grid grid-cols-2 lg:grid-cols-1 gap-2">
                    <div class="flex text-gray-600 items-center space-x-1">

                      @if ($this->designation)
                        <h1 class="font-semibold">Floor :
                          {{ ordinal($this->designation->floor->number) }} Floor </h1>
                      @else
                        <h1 class="font-semibold">Floor : Not Assigned </h1>
                      @endif
                    </div>
                    <div>

                      <h1 class="text-gray-600">Cleaning :
                        @if (auth()->user()->room_boy->is_cleaning)
                          <span class="bg-green-600 px-4 rounded-full font-semibold text-white">YES</span>
                        @else
                          <span class="bg-red-600 px-4 rounded-full font-semibold text-white">NO</span>
                        @endif

                      </h1>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @if (\App\Models\Designation::where('room_boy_id', auth()->user()->room_boy->id)->exists() == false)
              <div
                class="absolute top-0 left-0 w-full h-full bg-gray-50 bg-opacity-90 flex justify-center items-center">
                <div class="flex items-center space-x-1 animate-pulse">
                  <svg class="w-7 h-7 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                    fill="currentColor">
                    <defs></defs>
                    <title>warning-square--filled</title>
                    <path
                      d="M26.0022,4H5.998A1.998,1.998,0,0,0,4,5.998V26.002A1.998,1.998,0,0,0,5.998,28H26.0022A1.9979,1.9979,0,0,0,28,26.002V5.998A1.9979,1.9979,0,0,0,26.0022,4ZM14.8752,8h2.25V18h-2.25ZM16,24a1.5,1.5,0,1,1,1.5-1.5A1.5,1.5,0,0,1,16,24Z">
                    </path>
                    <path id="inner-path" class="cls-1"
                      d="M14.8751,8h2.25V18h-2.25ZM16,24a1.5,1.5,0,1,1,1.5-1.5A1.5,1.5,0,0,1,16,24Z" style="fill:none">
                    </path>
                    <rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>" class="cls-1" width="32"
                      height="32" style="fill:none"></rect>
                  </svg>
                  <h1 class="text-red-500 font-bold text-xl">Please assign it to its designated floor.</h1>
                </div>
              </div>
            @endif

          </div>
        </section>

        <!-- Actions panel -->
        <section aria-labelledby="quick-links-title" class="bg-white">
          <div class="relative my-5">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex items-center justify-between">
              @if ($show_designation_only == true)
                <span class="bg-white pr-3 text-lg font-semibold uppercase text-green-700">Designated Floor</span>
              @else
                <span class="bg-white pr-3 text-lg font-semibold uppercase text-gray-700">All Floor</span>
              @endif
              <x-button rounded positive class="font-semibold" wire:click="$toggle('show_designation_only')"
                icon="switch-horizontal" label="SWITCH" />
            </div>
          </div>

          @if (auth()->user()->room_boy->is_cleaning)
            {{-- <div class="p-2 mb-2 space-y-1 bg-white border border-red-500 rounded-lg">
              <h1>Currently cleaning : ROOM # {{ auth()->user()->room_boy->room->number }} </h1>
              <div>
                <x-button wire:click="finish({{ auth()->user()->room_boy->room_id }})" label="Finish" negative />
              </div>
            </div> --}}

            <div class="l border-4 border-red-600   p-2 lg:px-8 rounded-xl">
              <div class="flex space-x-2 items-center relative  justify-between">
                <div class="rounded-lg inline-flex p-3 bg-red-600 shadow-lg">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-white" width="24"
                    height="24">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                      d="M17.618 5.968l1.453-1.453 1.414 1.414-1.453 1.453a9 9 0 1 1-1.414-1.414zM11 8v6h2V8h-2zM8 1h8v2H8V1z" />
                  </svg>
                </div>


                <div class="sdsdsd relative flex space-x-1 items-end">

                  @if (auth()->user()->room_boy->room->updated_at == null)
                  @else
                    @php
                      $cleaningTime = new Carbon\Carbon(
                          auth()
                              ->user()
                              ->room_boy->room->updated_at->addMinutes(15),
                      );
                      $timeToClean = new Carbon\Carbon(auth()->user()->room_boy->room->time_to_clean);
                      // dd(auth()->user()->room_boy->room->updated_at == null);
                    @endphp
                    <div class=" text-sm">
                      @if (!$cleaningTime->isPast())
                        <x-countdown :expires="$cleaningTime">
                          <div class="font-semibold text-red-800">
                            <span class="font-semibold text-red-800" x-text="timer.days">{{ $component->days() }}</span>
                            :
                            <span class="font-semibold text-red-800"
                              x-text="timer.hours">{{ $component->hours() }}</span>
                            :
                            <span class="font-semibold text-red-800"
                              x-text="timer.minutes">{{ $component->minutes() }}</span>
                            :
                            <span class="font-semibold text-red-800"
                              x-text="timer.seconds">{{ $component->seconds() }}</span>
                          </div>

                        </x-countdown>
                      @else
                      @endif
                    </div>
                  @endif
                  <x-button type="button" spinner="finish"
                    wire:click="finish({{ auth()->user()->room_boy->room_id }})" lg negative class="font-semibold mt-1"
                    label="FINISH" />
                </div>
              </div>
              <div class="div lg:flex  justify-between items-center">
                <div class="mt-4">
                  <h3 class="font-medium">
                    <div class="focus:outline-none  flex flex-col text-gray-700 uppercase">
                      <h1 class="text-sm"> Currently cleaning</h1>
                      <h1 class="font-semibold text-xl"> ROOM #
                        {{ auth()->user()->room_boy->room->number }}</h1>

                    </div>
                  </h3>
                </div>

                <div class="mt-3">
                  @if (!$timeToClean->isPast())
                    <x-countdown :expires="$timeToClean">
                      <span class="font-semibold text-green-800" x-text="timer.days">{{ $component->days() }}</span>
                      days
                      <span class="font-semibold text-green-800" x-text="timer.hours">{{ $component->hours() }}</span>
                      hours
                      <span class="font-semibold text-green-800"
                        x-text="timer.minutes">{{ $component->minutes() }}</span>
                      minutes
                      <span class="font-semibold text-green-800"
                        x-text="timer.seconds">{{ $component->seconds() }}</span>
                      seconds
                    </x-countdown>
                  @else
                  @endif
                </div>
              </div>
            </div>
          @endif

          <div class="grid lg:grid-cols-2 grid-cols-1 gap-4 mt-3" x-animate>

            @if ($this->designation)
              @foreach ($rooms->whereIn('room_status_id', 7) as $room)
                @php
                  $timeToClean = new Carbon\Carbon($room->time_to_clean);
                  
                @endphp
                @if ($room->room_status_id == 7)
                  <div class="border-4 {{ $loop->first ? 'border-red-600 ' : 'border-green-600 ' }} p-6 rounded-3xl">

                    <div class="flex space-x-2 items-center relative  justify-between">
                      <div
                        class="rounded-lg inline-flex p-3 {{ $loop->first ? 'bg-red-600' : 'bg-green-600' }} shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-white"
                          width="24" height="24">
                          <path fill="none" d="M0 0h24v24H0z" />
                          <path
                            d="M17.618 5.968l1.453-1.453 1.414 1.414-1.453 1.453a9 9 0 1 1-1.414-1.414zM11 8v6h2V8h-2zM8 1h8v2H8V1z" />
                        </svg>
                      </div>

                      <div class="sdsdsd relative">
                        @if ($loop->first)
                          <x-button spinner="startRoomCleaning({{ $room->id }})"
                            wire:click="startRoomCleaning({{ $room->id }})" lg dark class="font-semibold mt-1"
                            label="START" />
                        @endif
                      </div>
                    </div>
                    <div class="div">
                      <div class="mt-4">
                        <h3 class="font-medium">
                          <div class="focus:outline-none font-semibold underline text-gray-700 uppercase text-xl">
                            <!-- Extend touch target to entire panel -->

                            Room # {{ $room->number }}
                          </div>
                        </h3>
                        <div>
                          @if (!$timeToClean->isPast())
                            <x-countdown :expires="$timeToClean">
                              <span class="font-semibold text-green-800"
                                x-text="timer.days">{{ $component->days() }}</span> days
                              <span class="font-semibold text-green-800"
                                x-text="timer.hours">{{ $component->hours() }}</span>
                              hours
                              <span class="font-semibold text-green-800"
                                x-text="timer.minutes">{{ $component->minutes() }}</span>
                              minutes
                              <span class="font-semibold text-green-800"
                                x-text="timer.seconds">{{ $component->seconds() }}</span>
                              seconds
                            </x-countdown>
                          @else
                            <p class="text-sm text-gray-500 truncate">Time to clean :
                              <span class="text-red-500">{{ $timeToClean->diffForHumans() }}</span>
                            </p>
                          @endif

                        </div>
                      </div>
                    </div>
                  </div>
                @else
                  <div class="border-4 border-red-600  p-6 rounded-3xl">

                    <div class="flex space-x-2 items-center relative  justify-between">
                      <div class="rounded-lg inline-flex p-3 bg-red-600 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-white"
                          width="24" height="24">
                          <path fill="none" d="M0 0h24v24H0z" />
                          <path
                            d="M17.618 5.968l1.453-1.453 1.414 1.414-1.453 1.453a9 9 0 1 1-1.414-1.414zM11 8v6h2V8h-2zM8 1h8v2H8V1z" />
                        </svg>
                      </div>


                      <div class="sdsdsd relative flex space-x-1 items-end">

                        @if (auth()->user()->room_boy->room->updated_at == null)
                        @else
                          @php
                            $cleaningTime = new Carbon\Carbon(
                                auth()
                                    ->user()
                                    ->room_boy->room->updated_at->addMinutes(20),
                            );
                            // dd(auth()->user()->room_boy->room->updated_at == null);
                          @endphp
                          <div class=" text-sm">
                            @if (!$cleaningTime->isPast())
                              <x-countdown :expires="$cleaningTime">
                                <div class="font-semibold text-red-800">
                                  <span class="font-semibold text-red-800"
                                    x-text="timer.days">{{ $component->days() }}</span>
                                  :
                                  <span class="font-semibold text-red-800"
                                    x-text="timer.hours">{{ $component->hours() }}</span>
                                  :
                                  <span class="font-semibold text-red-800"
                                    x-text="timer.minutes">{{ $component->minutes() }}</span>
                                  :
                                  <span class="font-semibold text-red-800"
                                    x-text="timer.seconds">{{ $component->seconds() }}</span>
                                </div>

                              </x-countdown>
                            @else
                            @endif
                          </div>
                        @endif
                        <x-button type="button" spinner="finish"
                          wire:click="finish({{ auth()->user()->room_boy->room_id }})" lg negative
                          class="font-semibold mt-1" label="FINISH" />
                      </div>
                    </div>
                    <div class="div">
                      <div class="mt-4">
                        <h3 class="font-medium">
                          <div class="focus:outline-none  flex flex-col text-gray-700 uppercase">
                            <h1 class="text-sm"> Currently cleaning</h1>
                            <h1 class="font-semibold text-xl"> ROOM #
                              {{ auth()->user()->room_boy->room->number }}</h1>

                          </div>
                        </h3>


                        <div class="mt-3">
                          @if (!$timeToClean->isPast())
                            <x-countdown :expires="$timeToClean">
                              <span class="font-semibold text-green-800"
                                x-text="timer.days">{{ $component->days() }}</span>
                              days
                              <span class="font-semibold text-green-800"
                                x-text="timer.hours">{{ $component->hours() }}</span>
                              hours
                              <span class="font-semibold text-green-800"
                                x-text="timer.minutes">{{ $component->minutes() }}</span>
                              minutes
                              <span class="font-semibold text-green-800"
                                x-text="timer.seconds">{{ $component->seconds() }}</span>
                              seconds
                            </x-countdown>
                          @else
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
              @endforeach
            @endif
          </div>

        </section>
      </div>

      <!-- Right column -->
      <div class="grid grid-cols-1 gap-4">
        <!-- Announcements -->
        <section aria-labelledby="announcements-title">
          <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-6">
              <div class="flex justify-between border-b pb-1">
                <div class="flex items-center space-x-1">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-gray-700" width="24"
                    height="24">
                    <path fill="none" d="M0 0H24V24H0z" />
                    <path
                      d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12h2c0 4.418 3.582 8 8 8s8-3.582 8-8-3.582-8-8-8C9.25 4 6.824 5.387 5.385 7.5H8v2H2v-6h2V6c1.824-2.43 4.729-4 8-4zm1 5v4.585l3.243 3.243-1.415 1.415L11 12.413V7h2z" />
                  </svg>
                  <h2 class="font-semibold text-gray-700 uppercase" id="announcements-title">
                    CLEANING HISTORY</h2>
                </div>
                <button class="hover:fill-green-700 fill-gray-700">
                  @if ($filter == 'ASC')
                    <svg wire:click="$set('filter','DESC')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                      class="h-5 w-5">
                      <path fill="none" d="M0 0H24V24H0z" />
                      <path d="M19 3l4 5h-3v12h-2V8h-3l4-5zm-5 15v2H3v-2h11zm0-7v2H3v-2h11zm-2-7v2H3V4h9z" />
                    </svg>
                  @else
                    <svg wire:click="$set('filter','ASC')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                      class="h-5 w-5">
                      <path fill="none" d="M0 0H24V24H0z" />
                      <path d="M20 4v12h3l-4 5-4-5h3V4h2zm-8 14v2H3v-2h9zm2-7v2H3v-2h11zm0-7v2H3V4h11z" />
                    </svg>
                  @endif
                </button>
              </div>
              <div class="mt-6 flow-root">
                <div class="flow-root">
                  <ul role="list" class="-mb-8">
                    @forelse ($history as $cleaning)
                      <li>
                        <div class="relative pb-8">
                          <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"
                            aria-hidden="true"></span>
                          <div class="relative flex items-start space-x-3">
                            <div class="relative">
                              <div class="bg-green-500 h-10 w-10 rounded-full grid place-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-8 fill-white">
                                  <path fill="none" d="M0 0h24v24H0z" />
                                  <path
                                    d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zM7 12a5 5 0 0 0 10 0h-2a3 3 0 0 1-6 0H7z" />
                                </svg>
                              </div>

                              <span class="absolute -bottom-0.5 -right-1 rounded-xl bg-white px-0.5 py-px">
                                <!-- Heroicon name: mini/chat-bubble-left-ellipsis -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                  class="h-5 w-5 fill-gray-700">
                                  <path fill="none" d="M0 0h24v24H0z" />
                                  <path
                                    d="M17 19h2v-8h-6v8h2v-6h2v6zM3 19V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2H2v-2h1zm4-8v2h2v-2H7zm0 4v2h2v-2H7zm0-8v2h2V7H7z" />
                                </svg>
                              </span>
                            </div>
                            <div class="min-w-0 flex-1">
                              <div class="flex space-x-1 text-sm">
                                <h1>{{ \Carbon\Carbon::parse($cleaning->finish_at)->diffForHumans() }}
                                </h1>
                                @if ($cleaning->delayed == true)
                                  <h1>|</h1>
                                  <span class="px-2 text-sm bg-red-500 text-white rounded-full">Delayed</span>
                                @else
                                @endif
                              </div>
                              <div class="mt-1 text-sm font-semibold text-gray-700">
                                <p>Room #{{ $cleaning->room->number }} |
                                  {{ ordinal($cleaning->room->floor->number) }} Floor
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                    @empty
                    @endforelse
                  </ul>
                </div>
              </div>

            </div>
          </div>
        </section>

        <!-- Recent Hires -->
        {{-- <section aria-labelledby="recent-hires-title">
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <h2 class="text-base font-medium text-gray-900" id="recent-hires-title">Recent
                                Hires</h2>
                            <div class="mt-6 flow-root">
                                <ul role="list" class="-my-5 divide-y divide-gray-200">
                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full"
                                                    src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                    alt="">
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-medium text-gray-900">Leonard
                                                    Krasner</p>
                                                <p class="truncate text-sm text-gray-500">@leonardkrasner</p>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">View</a>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full"
                                                    src="https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                    alt="">
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-medium text-gray-900">Floyd
                                                    Miles</p>
                                                <p class="truncate text-sm text-gray-500">@floydmiles</p>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">View</a>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full"
                                                    src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                    alt="">
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-medium text-gray-900">Emily
                                                    Selman</p>
                                                <p class="truncate text-sm text-gray-500">@emilyselman</p>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">View</a>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full"
                                                    src="https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                    alt="">
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-medium text-gray-900">Kristin
                                                    Watson</p>
                                                <p class="truncate text-sm text-gray-500">@kristinwatson</p>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">View</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-6">
                                <a href="#"
                                    class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">View
                                    all</a>
                            </div>
                        </div>
                    </div>
                </section> --}}
      </div>
    </div>
  </div>
</div>
