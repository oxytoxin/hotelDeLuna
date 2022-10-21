<div>
  <div class="flex justify-between items-center">
    <div class="flex space-x-1 items-center">
      <x-native-select wire:model="report_type">
        <option selected>Select Report</option>
        <option value="1">Number of guest per day</option>
        <option value="2">Total New Guest</option>
      </x-native-select>
      @if ($report_type != 2)
        <input type="date" wire:model="date" class="rounded-lg border-gray-300 h-10 text-gray-600" name=""
          id="">
        @error('date')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
        <x-button id="dsdsd" wire:click="generate" dark label="GENERATE" spinner="generate" class="font-semibold" />
      @endif
    </div>
    <div class="flex space-x-1">
      <x-button wire:click="export" wire:loading.attr="disabled" positive class="text-white fill-white font-semibold">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
          <path fill="none" d="M0 0h24v24H0z" />
          <path
            d="M2.859 2.877l12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM4 4.735v14.53l10 1.429V3.306L4 4.735zM17 19h3V5h-3V3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4v-2zm-6.8-7l2.8 4h-2.4L9 13.714 7.4 16H5l2.8-4L5 8h2.4L9 10.286 10.6 8H13l-2.8 4z" />
        </svg>
      </x-button>
      <x-button wire:key="sdsd" onclick="printReport()" dark class="text-white fill-white font-semibold">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
          <path fill="none" d="M0 0h24v24H0z" />
          <path
            d="M6 19H3a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h3V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-3v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-2zm0-2v-1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v1h2V9H4v8h2zM8 4v3h8V4H8zm0 13v3h8v-3H8zm-3-7h3v2H5v-2z" />
        </svg>
      </x-button>
    </div>
  </div>
  <div class="mt-10">
    @switch($report_type)
      @case(1)
        <div id="resultsPrint" class="s">

          <div class="mt-8 flex flex-col">
            <div class="mb-3 flex text-lg font-semibold text-gray-700 justify-end">TOTAL GUEST: {{ $guests->count() }}</div>
          </div>
          <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle  lg:px-8">
              <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col"
                        class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-700 sm:pl-6">
                        Guest Name</th>
                      <th scope="col"
                        class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-700 sm:pl-6">
                        Contact Number</th>

                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($guests as $guest)
                      <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                          {{ $guest->name }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $guest->contact_number }}</td>

                      </tr>
                    @endforeach

                    <!-- More people... -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    @break

    @case(2)
      <div id="resultsPrint" class="s">

        <div class="mt-8 flex flex-col">
          <div class="mb-3 flex text-lg font-semibold text-gray-700 justify-end">TOTAL GUEST: {{ $guests->count() }}</div>
        </div>
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle  lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
              <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col"
                      class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-700 sm:pl-6">
                      Guest Name</th>
                    <th scope="col"
                      class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-700 sm:pl-6">
                      Contact Number</th>

                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  @foreach ($guests as $guest)
                    <tr>
                      <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                        {{ $guest->fullname }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Front-end Developer</td>

                    </tr>
                  @endforeach

                  <!-- More people... -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  @break

  @default
@endswitch
</div>
</div>
@push('scripts')
  <script>
    function printReport() {
      var prtContent = document.getElementById("resultsPrint");
      var WinPrint = window.open();
      WinPrint.document.write(prtContent.innerHTML);
      WinPrint.document.close();
      WinPrint.focus();
      WinPrint.print();
      WinPrint.close();
    }
  </script>
@endpush
