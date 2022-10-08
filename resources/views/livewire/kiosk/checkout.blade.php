<div x-data="{ scan: @entangle('scannerpanel') }" class="font-rubik">
  <div class="mx-40 flex mt-5 h-[32rem]">
    <div class="flex-1 relative">
      <h1 class="text-2xl text-white font-black">CHECK-OUT DETAILS |</h1>
      <div class="div mt-2">

        <dl class="text-sm px-10 font-medium text-gray-500 space-y-3 border-t border-gray-200 pt-6">
          @forelse ($transactions as $transaction)
            @switch($transaction->transaction_type_id)
              @case(1)
                <div class="flex justify-between">
                  <dt class="">
                    <div class="flex flex-col">
                      <div class="uppercase text-white border-b font-bold">
                        {{ $transaction->check_in_detail->rate->type->name }}</div>
                      {{-- <div class="text-gray-300"> RM #{{$transaction->check_in_detail->room->number}} | {{ordinal($transaction->check_in_detail->room->floor->number)}} FLOOR</div> --}}
                    </div>
                  </dt>
                  <dd class="text-lg font-bold text-white">&#8369;{{ number_format($transaction->payable_amount, 2) }}</dd>
                </div>
              @break

              @case(3)
                <div class="flex pt-7 justify-between">
                  <dt class="">
                    <div class="flex flex-col">
                      <div class="uppercase text-white border-b font-bold">KITCHEN ORDERS</div>
                      <div class="text-gray-300">{{ $transaction->orders->count() }} Meals</div>
                    </div>
                  </dt>
                  <dd class="text-lg font-bold text-white">&#8369;{{ number_format($transaction->payable_amount, 2) }}</dd>
                </div>
              @break

              @default
            @endswitch
            @empty
            @endforelse



          </dl>
          <div class="flex pt-7 px-10 justify-between">
            <dt class="">
              <div class="flex items-center space-x-2">
                <div class="flex flex-col">
                  <div class="uppercase text-white border-b font-bold">CHECK-IN DEPOSITS</div>
                  <div class="text-gray-300">Room Key & TV Remote </div>
                </div>
                @if ($transactions->where('transaction_type_id', 2)->count() > 1)
                  <div class="text-white"> x {{ $transactions->where('transaction_type_id', 2)->count() }}</div>
                @endif
                <div class="text-white"></div>
              </div>
            </dt>
            <dd class="text-lg font-bold text-white">
              &#8369;{{ number_format($transactions->where('transaction_type_id', 2)->sum('payable_amount'), 2) }}</dd>
          </div>
          <div class="absolute border-b bottom-5 w-full left-0">
            <div class="flex w-full  px-10 items-center justify-between">
              <dt class="">
                <div class="flex items-center space-x-2">
                  <h1 class="text-2xl text-white font-bold">TOTAL</h1>
                </div>
              </dt>
              <dd class="text-2xl font-bold text-white">
                &#8369;{{ number_format($transactions->sum('payable_amount'), 2) }}
              </dd>
            </div>
          </div>

        </div>
      </div>
      <div class="bg-white bg-opacity-30 p-5 py-8 w-96 shadow-2xl rounded-3xl">
        <div class="grid place-content-center">
          <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=jdjshjshdjshd" alt="">
        </div>
        <div class="flex-none p-6 text-center">
          <h2 class="mt-3 font-bold uppercase text-white">{{ $guests['name'] ?? '' }}</h2>
        </div>
        <div class="flex flex-auto flex-col justify-between p-6">
          <dl class="grid grid-cols-1 gap-x-6 gap-y-3 text-sm text-white">
            <dt class="col-end-1 font-semibold text-gray-900">Phone</dt>
            <dd>{{ $guests['contact_number'] ?? '***********' }}</dd>
            <dt class="col-end-1 font-semibold text-gray-900">QR_CODE</dt>
            <dd class="truncate"><a href="https://example.com"
                class="text-white ">{{ $guests['qr_code'] ?? '***********' }}</a></dd>

          </dl>
        </div>
      </div>
    </div>

    <div x-show="scan" x-cloak class="relative z-10" role="dialog" aria-modal="true">
      <!--
                                                                                                              Background backdrop, show/hide based on modal state.
                                                                                                          
                                                                                                              Entering: "ease-out duration-300"
                                                                                                                From: "opacity-0"
                                                                                                                To: "opacity-100"
                                                                                                              Leaving: "ease-in duration-200"
                                                                                                                From: "opacity-100"
                                                                                                                To: "opacity-0"
                                                                                                            -->
      <div x-show="scan" x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-90 transition-opacity"></div>

      <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
        <!--
                                                                                                                Command palette, show/hide based on modal state.
                                                                                                          
                                                                                                                Entering: "ease-out duration-300"
                                                                                                                  From: "opacity-0 scale-95"
                                                                                                                  To: "opacity-100 scale-100"
                                                                                                                Leaving: "ease-in duration-200"
                                                                                                                  From: "opacity-100 scale-100"
                                                                                                                  To: "opacity-0 scale-95"
                                                                                                              -->
        <div x-show="scan" x-cloak x-transition:enter="ease-out duration-300"
          x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-95"
          class="mx-auto max-w-2xl h-[35rem]  relative transform divide-y divide-gray-100 overflow-hidden transition-all">
          <div class="relative  h-full">

            <div class="absolute top-0 right-0 bottom-0 left-0 flex justify-center items-center">
              <div class="flex flex-col justify-center items-center  bg-opacity-70  w-full mx-10 rounded-2xl">
                <input type="number" autofocus wire:model="scanner"
                  class="w-full shadow-xl bg-gray-100 rounded-2xl h-20 text-3xl font-bold text-center">
                <div class="mt-5">
                  <x-button label="SEARCH" wire:click="searchCode" dark lg class="font-bold" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="grid place-content-center mt-2">
          <x-button href="{{ route('kiosk.transaction') }}" md icon="arrow-circle-left" label="BACK" white
            class="font-semibold" />
        </div>

      </div>
    </div>

  </div>
