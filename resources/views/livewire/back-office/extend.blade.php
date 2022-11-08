<div x-data>
  <div class="flex justify-between items-center">
    <div class="flex space-x-1 items-center">
      <div>
        <div class="">
          <input type="date" wire:model="date"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            placeholder="you@example.com">
        </div>
      </div>
      @if ($date)
        <x-native-select wire:model="shift">
          <option>Select Shift</option>
          <option value="1">1st Shift (8:00am - 8:00pm)</option>
          <option value="2">2nd Shift (8:00pm - 8:00am)</option>
        </x-native-select>
      @endif
    </div>
    <div class="flex space-x-1">
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
  <div class="">
    <div x-ref="printContainer" class="mt-5 flex flex-col">
      <div class="show-on-print" style="display: none">
        <h1 class="text-xl">Roomboy and their overdue roomss</h1>
      </div>


      <table id="example" class="table-auto mt-2" style="width:100%">
        <thead class="font-normal">
          <tr>
            <th width="110" class="border text-left px-2 text-sm font-semibold text-gray-700 py-2"></th>
            <th class="border text-left px-2 text-sm font-semibold uppercase text-gray-700 py-2">Extension Hour</th>
            <th class="border text-left px-2 text-sm font-semibold uppercase text-gray-700 py-2">Date & TIME</th>
            <th class="border text-left px-2 text-sm font-semibold text-gray-700 py-2">FRONT DESK IN-CHARGE</th>

          </tr>
        </thead>
        @php
          $guests = App\Models\Guest::whereIn('id', $stays)->get();
          //   dd($guests);
        @endphp
        <tbody class="">
          @foreach ($guests as $guest)
            <tr>
              <td colspan="5" class="border px-2 bg-gray-50 py-2 text-sm text-gray-700">ROOM
                #{{ $guest->checkInDetail->room->number }}</td>
            </tr>
            @foreach ($guest->stayExtensions as $extension)
              <tr>
                <td class="border px-2 py-2 text-sm text-gray-700"></td>
                <td class="border px-2 py-2 text-sm text-gray-700">{{ $extension->hours }} HOURS</td>
                <td class="border px-2 py-2 text-sm text-gray-700">{{ $extension->created_at->format('m/d/Y') }}</td>
                <td class="border px-2 py-2 text-sm text-gray-700">{{ $extension->front_desk_name }}</td>

              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
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
