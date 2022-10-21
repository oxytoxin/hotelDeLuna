<div x-data>
  <div class="flex justify-between items-center">
    <div class="flex space-x-1 items-center">
      <x-native-select wire:model="report_type">
        <option selected>Select Report</option>
        <option value="1">Number of guest per day</option>
        <option value="2">Total New Guest</option>
        <option value="3">Total Extended Guest</option>
      </x-native-select>
      @if ($report_type != 2)
        <input type="date" wire:model="date" class="rounded-lg border-gray-300 h-10 text-gray-600" name=""
          id="">
        @error('date')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
        @if ($date != null)
          <x-button id="dsdsd" wire:click="generate" dark label="GENERATE" spinner="generate"
            class="font-semibold" />
        @endif

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
      <x-button wire:key="sdsd" @click="printOut($refs.printContainer.outerHTML);" dark
        class="text-white fill-white font-semibold">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
          <path fill="none" d="M0 0h24v24H0z" />
          <path
            d="M6 19H3a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h3V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-3v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-2zm0-2v-1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v1h2V9H4v8h2zM8 4v3h8V4H8zm0 13v3h8v-3H8zm-3-7h3v2H5v-2z" />
        </svg>
      </x-button>
    </div>
  </div>
  <div class="mt-10 ">
    @switch($report_type)
      @case(1)
        <div x-ref="printContainer" id="print" class="mb-10">
          <h1>TOTAL GUEST: {{ $guests->count() }}</h1>
          <table id="example" class="table-auto mt-2" style="width:100%">
            <thead class="font-normal">
              <tr>
                <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">GUEST NAME</th>
                <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">CONTACT NUMBER</th>
              </tr>
            </thead>
            <tbody class="">
              @foreach ($guests as $guest)
                <tr>
                  <td class="border px-3 py-1"> {{ $guest->name }}</td>
                  <td class="border px-3 py-1"> {{ $guest->contact_number }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @break

      @case(2)
        <div x-ref="printContainer" id="print" class="mb-10">
          <h1>TOTAL GUEST: {{ $guests->count() }}</h1>
          <table id="example" class="table-auto mt-2" style="width:100%">
            <thead class="font-normal">
              <tr>
                <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">GUEST NAME</th>
                <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">CONTACT NUMBER</th>
              </tr>
            </thead>
            <tbody class="">
              @foreach ($guests as $guest)
                <tr>
                  <td class="border px-3 py-1"> {{ $guest->name }}</td>
                  <td class="border px-3 py-1"> {{ $guest->contact_number }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @break

      @case(3)
        <div x-ref="printContainer" id="print" class="mb-10">
          <h1>TOTAL GUEST: {{ $guests->count() }}</h1>
          <table id="example" class="table-auto mt-2" style="width:100%">
            <thead class="font-normal">
              <tr>
                <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">GUEST NAME</th>
                <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">CONTACT NUMBER</th>
              </tr>
            </thead>
            <tbody class="">
              @foreach ($guests as $guest)
                <tr>
                  <td class="border px-3 py-1"> {{ $guest->name }}</td>
                  <td class="border px-3 py-1"> {{ $guest->contact_number }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @break

      @default
    @endswitch
  </div>
  <script>
    function printOut(data) {
      var mywindow = window.open('', 'Report On Guest', 'height=1000,width=1000');
      mywindow.document.write('<html><head>');
      mywindow.document.write('<title>Report On Guest</title>');
      mywindow.document.write(`<link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}" />`);
      mywindow.document.write('</head><body >');
      mywindow.document.write(data);
      mywindow.document.write('</body></html>');

      mywindow.document.close();
      mywindow.focus();
      setTimeout(() => {
        mywindow.print();
        return true;
      }, 1000);


    }
  </script>
</div>
