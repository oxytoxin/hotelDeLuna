<div x-data>
  <div class="flex items-center justify-between">
    <div class="flex space-x-1">
      <x-native-select wire:model="report_type">
        <option selected>Select Report</option>
        <option value="1">First shift AM 8: AM - 8 PM</option>
        <option value="2">2nd Shift 8 PM-8 AM</option>
      </x-native-select>
      @if ($report_type != null)
        <x-native-select wire:model="floor_id">
          <option selected>Select Floor</option>
          @foreach ($floors as $floor)
            <option value="{{ $floor->id }}">{{ $floor->number }}</option>
          @endforeach
        </x-native-select>
      @endif
    </div>
    <div class="flex space-x-1">
      {{-- <x-button wire:click="export" wire:loading.attr="disabled" positive class="text-white fill-white font-semibold">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
          <path fill="none" d="M0 0h24v24H0z" />
          <path
            d="M2.859 2.877l12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM4 4.735v14.53l10 1.429V3.306L4 4.735zM17 19h3V5h-3V3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4v-2zm-6.8-7l2.8 4h-2.4L9 13.714 7.4 16H5l2.8-4L5 8h2.4L9 10.286 10.6 8H13l-2.8 4z" />
        </svg>
      </x-button> --}}
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
  <div x-ref="printContainer" class="mt-10">
    <div class="show-on-print" style="display: none">
    </div>
    <table id="example" class="table-auto mt-2" style="width:100%">
      <thead class="font-normal">
        <tr>
          <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">FLOORS</th>
          <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">AMOUNT</th>
        </tr>
      </thead>
      <tbody class="">

        @foreach ($transactions as $transaction)
          <tr>
            <td class="border px-3 py-1">{{ $transaction->room->floor->number }} FLOOR</td>
            <td class="border px-3 py-1">&#8369;{{ number_format($transaction->payable_amount, 2) }}</td>
          </tr>
        @endforeach
        <tr class="col-span-2">
          <td class=" px-3 py-1 font-bold text-right text-gray-700">TOTAL:</td>
          </td>
          <td class="border px-3 py-1 font-bold text-gray-700">
            &#8369;{{ number_format($transactions->sum('payable_amount'), 2) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <script>
    function printOut(data) {
      var mywindow = window.open('', 'Sales Report', 'height=1000,width=1000');
      mywindow.document.write('<html><head>');
      mywindow.document.write('<title>Sales Report</title>');
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
