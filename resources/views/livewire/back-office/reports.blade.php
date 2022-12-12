<div>
  <div class="p-6">
    <x-native-select label="Select Report" wire:model="selected_report" class="w-64">
      <option selected hidden>--------</option>
      <option value="1">Occupied Room</option>
      <option value="2">Guest</option>
      <option value="3">Overdue Rooms</option>
      <option value="4">Roomboys</option>
      <option value="5">Sales</option>
      <option value="6">Number Of Stay</option>
      <option value="7">Time Interval</option>
      <option value="8">Transfer</option>
      <option value="9">Extend</option>
    </x-native-select>
  </div>

  <div class="mt-2">
    @switch($selected_report)
      @case(1)
        <div x-animate>
          <livewire:back-office.occupied-room />
        </div>
      @break

      @case(2)
        <div x-animate>
          <livewire:back-office.guest-report />
        </div>
      @break

      @case(3)
        <div x-animate></div>
        <livewire:back-office.overdue />
      </div>
    @break

    @case(4)
      <div x-animate>
        <livewire:back-office.roomboy-report />
      </div>
    @break

    @case(6)
      <div x-animate>
        <livewire:back-office.number-of-stay />
      </div>
    @break

    @case(7)
      <div x-animate>
        <livewire:back-office.time-interval />
      </div>
    @break

    @case(8)
      <div x-animate>
        <livewire:back-office.transfer />
      </div>
    @break

    @case(9)
      <div x-animate></div>
      <livewire:back-office.extend />
    </div>
  @break

  @default
@endswitch
</div>
<script>
  function printOut(data) {
    var mywindow = window.open('', 'Occupied Rooms Report', 'height=1000,width=1000');
    mywindow.document.write('<html><head>');
    mywindow.document.write('<title>Occupied Rooms Report</title>');
    mywindow.document.write(`<link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}" />`);
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus();
    setTimeout(() => {
      mywindow.print();
      return true;
    }, 1500);


  }
</script>
</div>
