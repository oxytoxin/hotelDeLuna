<div>
  <div class="grid gap-2">
    <h1 class="text-lg text-gray-700">
      Occupied Rooms
    </h1>
    <x-my.table>
      <x-slot name="header">
        <x-my.table.head name="Number" />
        <x-my.table.head name="Floor" />
        <x-my.table.head name="Remaining Time" />
        <x-my.table.head name="" />
      </x-slot>
      @forelse ($roomsToCheckOut as $toCheckOutRoom)
        <tr>
          <x-my.table.cell>
            Room # {{ $toCheckOutRoom->number }}
          </x-my.table.cell>
          <x-my.table.cell>
            {{ ordinal($toCheckOutRoom->floor->number) }} Floor
          </x-my.table.cell>
          <x-my.table.cell>
            @php
              $expires = new Carbon\Carbon($toCheckOutRoom->check_in_details->first()->expected_check_out_at);
              //   dd($toCheckOutRoom->check_in_details->first());
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
                    <span x-text="timer.days">{{ $component->days() }}</span>
                    <span> days -</span>
                  </div>
                  <div class="flex space-x-1">
                    <span x-text="timer.hours">{{ $component->hours() }}</span>
                    <span> hours -</span>
                  </div>
                  <div class="flex space-x-1">
                    <span x-text="timer.minutes">{{ $component->minutes() }}</span>
                    <span> minutes -</span>
                  </div>
                  <div class="flex space-x-1">
                    <span x-text="timer.seconds">{{ $component->seconds() }}</span>
                    <span>seconds</span>
                  </div>
                </div>
              </x-countdown>
            @endif
          </x-my.table.cell>
          <x-my.table.cell>
            <div class="flex justify-end px-2">

            </div>
          </x-my.table.cell>
        </tr>
      @empty
        <x-my.table.empty span="4" />
      @endforelse
    </x-my.table>
  </div>

  <div class="mt-5 grid gap-2">
    <h1 class="text-lg text-gray-700">
      Uncleaned Rooms
    </h1>
    <x-my.table>
      <x-slot name="header">
        <x-my.table.head name="Number" />
        <x-my.table.head name="Floor" />
        <x-my.table.head name="Time To Clean" />
        <x-my.table.head name="" />
      </x-slot>
      @forelse ($uncleanedAndCleaningRooms as $unCleanedRoom)
        <tr>
          <x-my.table.cell>
            Room # {{ $unCleanedRoom->number }}
          </x-my.table.cell>
          <x-my.table.cell>
            {{ ordinal($unCleanedRoom->floor->number) }} Floor
          </x-my.table.cell>
          <x-my.table.cell>
            @php
              $expires = new Carbon\Carbon($unCleanedRoom->tim_to_clean);
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
                    <span x-text="timer.days">{{ $component->days() }}</span>
                    <span> days -</span>
                  </div>
                  <div class="flex space-x-1">
                    <span x-text="timer.hours">{{ $component->hours() }}</span>
                    <span> hours -</span>
                  </div>
                  <div class="flex space-x-1">
                    <span x-text="timer.minutes">{{ $component->minutes() }}</span>
                    <span> minutes -</span>
                  </div>
                  <div class="flex space-x-1">
                    <span x-text="timer.seconds">{{ $component->seconds() }}</span>
                    <span>seconds</span>
                  </div>
                </div>
              </x-countdown>
            @endif
          </x-my.table.cell>
          <x-my.table.cell>
            <div class="flex justify-end px-2">
              @if ($unCleanedRoom->room_status_id == 8)
                <span class="animate-pulse text-red-600">
                  Cleaning ...
                </span>
              @endif
            </div>
          </x-my.table.cell>
        </tr>
      @empty
        <x-my.table.empty span="4" />
      @endforelse
    </x-my.table>
  </div>

</div>
