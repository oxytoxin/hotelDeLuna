<div x-data="{
    printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;

        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
}">
  <div class="flex justify-end items-center">

    <div class="flex space-x-1">
      {{-- <x-button wire:click="export" wire:loading.attr="disabled" positive class="text-white fill-white font-semibold">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
          <path fill="none" d="M0 0h24v24H0z" />
          <path
            d="M2.859 2.877l12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM4 4.735v14.53l10 1.429V3.306L4 4.735zM17 19h3V5h-3V3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4v-2zm-6.8-7l2.8 4h-2.4L9 13.714 7.4 16H5l2.8-4L5 8h2.4L9 10.286 10.6 8H13l-2.8 4z" />
        </svg>
      </x-button> --}}
      <x-button wire:key="sdsd" x-on:click="printDiv('print')" dark class="text-white fill-white font-semibold">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
          <path fill="none" d="M0 0h24v24H0z" />
          <path
            d="M6 19H3a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h3V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-3v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-2zm0-2v-1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v1h2V9H4v8h2zM8 4v3h8V4H8zm0 13v3h8v-3H8zm-3-7h3v2H5v-2z" />
        </svg>
      </x-button>
    </div>
  </div>
  <div class="">
    <div id="print" class="mt-5 flex flex-col">
      <div class="show-on-print" style="display: none">
        <h1 class="text-xl">Roomboy and their overdue rooms</h1>
      </div>


      <table id="example" class="table-auto mt-2" style="width:100%">
        <thead class="font-normal">
          <tr>
            <th width="110" class="border"></th>
            <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">OVERDUE ROOM</th>
            <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">EXPECTED TIME</th>
            <th class="border text-left px-2 text-sm font-semibold text-gray-500 py-2">TIME ENDED</th>
          </tr>
        </thead>
        <tbody class="">
          @foreach ($roomboys as $roomboy)
            <tr>
              <th colspan="4" class="text-left border text-gray-700 font-semibold px-3 uppercase py-2 bg-gray-50">
                {{ $roomboy->user->name }}
              </th>

            </tr>
            @foreach ($roomboy->cleanings as $item)
              <tr>
                <td class="border px-3 py-1"></td>
                <td class="border px-3 py-1">RM #{{ $item->room->number }} |
                  {{ ordinal($item->room->floor->number) }} Floor</td>
                <td class="border px-3 py-1">dfdfdf</td>
                <td class="border px-3 py-1">dfdfdf</td>
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
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
