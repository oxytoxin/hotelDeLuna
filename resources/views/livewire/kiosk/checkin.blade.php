<div x-data="{ steps: @entangle('step') }" class="font-rubik">
    <div x-show="steps==1" x-cloak class="step">
        <div class=" mt-5 mx-10 flex justify-between">
            <h1 class="font-black text-3xl font-rubik text-gray-300">PLEASE SELECT ROOM TYPE: |</h1>
            <x-cancel-transaction />
        </div>
        <div class=" mx-10  flex justify-between space-x-10">
            <div class="flex-1">
                <div class="grid xl:grid-cols-5 lg:grid-cols-4  gap-5 h-[33rem] overflow-y-auto rounded-3xl ">

                    @foreach ($roomtypes as $roomtype)
                        <button wire:click="selectRoomType({{ $roomtype->id }})" class="relative">
                            <div class="absolute inset-0     opacity-80 rounded-r-3xl rounded-bl-3xl blur">
                            </div>
                            <div class="bg-white rounded-3xl p-3 relative  py-4 h-48">
                                <div
                                    class="absolute {{ $get_room['type_id'] == $roomtype->id ? 'bg-red-500 ' : 'bg-green-500 ' }} border border-green-700 right-2 top-2 h-10 w-10 rounded-full shadow-lg grid place-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        class="h-5 w-6 fill-white">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M20 20a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9H1l10.327-9.388a1 1 0 0 1 1.346 0L23 11h-3v9zM9 10v6h6v-6H9zm2 2h2v2h-2v-2z" />
                                    </svg>
                                </div>
                                <div class="relative grid place-content-center h-full">
                                    <h1 class="font-black  text-3xl text-center uppercase text-green-700">
                                        {{ $roomtype->name }}</h1>
                                </div>
                            </div>
                        </button>
                    @endforeach

                    {{-- @dump($get_room) --}}
                </div>

            </div>
            
            <div class="absolute bottom-5 right-20">
                @if ($get_room['type_id'] != '')
                    <button wire:click="$set('step',2)"
                        class="flex bg-white py-3  font-semibold text-gray-600 hover:text-gray-700 hover:fill-gray-700 space-x-1 rounded-md px-3">
                        <span>NEXT</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-gray-600">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm0 9H8v2h4v3l4-4-4-4v3z" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </div>
    <div x-show="steps==2" x-cloak class="step relative h-[33rem]">
        <div class="mx-10 mt-5 font-rubik">
            <div class="flex justify-between items-center ">
                <h1 class="font-black text-3xl font-rubik text-gray-300">PLEASE SELECT YOUR ROOM |</h1>

                <div class="font-rubik flex space-x-1 justify-between">
                    <x-cancel-transaction />
                    <button wire:click="$set('step', 1)"
                        class="bg-white rounded font-semibold py-2 text-gray-600 flex space-x-1 px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-gray-600">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm0 9V8l-4 4 4 4v-3h4v-2h-4z" />
                        </svg>
                        <span>Previous</span>
                    </button>
                </div>
            </div>

            <div class="grid mt-5 xl:grid-cols-4 lg:grid-cols-4 xl:gap-10 lg:gap-5" x-data="{ manage: @entangle('manageRoomPanel') }">
                @foreach ($rooms as $key => $room)
                    <button wire:key="{{ $key }}" class="relative"  wire:click="selectRoom({{$room->id}})">
                        <div class="absolute inset-0 bg-gray-400 opacity-80 rounded-r-3xl rounded-bl-3xl blur"></div>
                        <div class="bg-white relative xl:h-72 lg:h-60 rounded-3xl ">
                            <div
                                class="absolute w-14 h-20 shadow-xl rounded-r-3xl grid place-content-center top-0 bg-green-500 left-0">
                                {{-- <span
                                    class="font-bold text-lg uppercase
                                 font-rubik text-white">{{ ordinal($room->floor->number) }}</span> --}}
                            </div>
                            <div class="relative grid place-content-center h-full">
                                <h1 class="font-black text-5xl text-center text-gray-600">ROOM #{{ $room->number }}
                                </h1>
                            </div>
                        </div>


                    </button>
                @endforeach
                <div x-show="manage"  x-cloak class="relative z-10" role="dialog" aria-modal="true">

                    <div x-show="manage" x-cloak x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-500 bg-opacity-40 transition-opacity"></div>

                    <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">

                        <div wire:loading.remove wire:target="room_key" x-show="manage" x-cloak
                            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            x-on:click.away="manage = false"
                            class="mx-auto h-[30rem]  font-rubik max-w-3xl transform divide-y divide-gray-500 divide-opacity-10 overflow-hidden rounded-xl bg-white bg-opacity-80 shadow-2xl ring-1 ring-black ring-opacity-5 backdrop-blur backdrop-filter transition-all">
                            <div class="relative p-6 h-full">
                                <div class="transaction flex flex-col ">
                                    <div class="bg-white grid place-content-center h-14 w-14 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-green-600">
                                            <path fill="none" d="M0 0h24v24H0z" />
                                            <path
                                                d="M17 19h2v-8h-6v8h2v-6h2v6zM3 19V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2H2v-2h1zm4-8v2h2v-2H7zm0 4v2h2v-2H7zm0-8v2h2V7H7z" />
                                        </svg>
                                    </div>
                                    @php
                                        $room = \App\Models\Room::where('id', $get_room['room_id'])->with('floor')->first();
                                        $type = \App\Models\Type::where('id', $get_room['type_id'])->first();
                                    @endphp
                                    <div class="texttts mt-5">
                                        {{-- <h1 class="text-3xl text-gray-600 underline font-rubik font-black">ROOM #{{$room->number ?? 'none'}} | {{ordinal($room->floor->number ?? 1)}} FLOOR</h1> --}}
                                    </div>
                                    <div class="texttts ">
                                        <h1 class="text-lg text-green-700 font-semibold flex-auto font-rubik">{{$type['name'] ?? 'None'}}</h1>
                                    </div>
                                   
                                    
                                </div>
                                
                                <div class="mt-20 w-full font-rubik">
                                    <h1 class="text-lg text-gray-600 font-rubik font-black">SELECT YOUR ROOM RATE</h1>
                                    <div class="flex  w-full">
                                        <div class="mt-3 relative flex space-x-4 ">
                                            @foreach ($rates as $item)
                                                    <button wire:click="selectRate({{$item->id}})"
                                                        class="{{$get_room['rate_id'] == $item->id ? 'bg-green-500 text-white' : 'bg-white text-gray-600'}} border h-14 w-14 p-1 rounded-xl grid place-content-center">
                                                        <span
                                                            class="uppercase text-sm font-semibold text-center ">{{ $item->staying_hour->number }}</span>
                                                    </button>
                                                @endforeach
                                        </div>
                                        
                                    </div>
                                    @error('get_room.rate_id') <span class="error mt-2 animate-pulse text-red-600 text-sm">Rate is required to proceed.</span> @enderror
                                </div>
                                <div class="absolute bottom-6 right-6">
                                    <div class="flex space-x-2">
                                        {{-- <div x-on:click="manage = false"
                                            class="bg-white hover:bg-gray-200 cursor-pointer py-2 px-3 rounded-md shadow">
                                            <span class=" font-semibold text-red-500 text-sm">DONE</span>
                                        </div> --}}
                                        <x-button wire:click="confirmRate" right-icon="arrow-circle-right" spinner="confirmRate" md class="font-bold" primary label="NEXT" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-show="steps==3" x-cloak class="relative mx-10">
        <div class="flex mt-2 font-rubik items-center justify-between">
            <h1 class="font-black xl:text-3xl lg:text-2xl font-rubik text-gray-300">PLEASE CONFIRM YOUR CHECK-IN
                INFORMATION |</h1>
            <div class="flex justify-between space-x-1">
                <x-cancel-transaction />
                <button wire:click="$set('step', 2)"
                    class="bg-white rounded font-semibold py-2 text-gray-600 flex space-x-1 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-gray-600">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm0 9V8l-4 4 4 4v-3h4v-2h-4z" />
                    </svg>
                    <span>PREVIOUS</span>
                </button>
            </div>
        </div>
        <div class="mt-5 flex xl:mx-40 lg:mx-10 justify-between relative space-x-6 h-[33rem]">
            <div class="bg-white font-rubik bg-opacity-70 rounded-3xl p-2 shadow-xl flex-1">
                <div class="bg-white relative p-4 h-full rounded-3xl">
                    <h1 class="font-bold text-lg text-gray-600">CHECK-IN DETAILS</h1>
                    <dl class="text-sm mt-3    space-y-1">
                        <?php $subtotal = 0; ?>
                        @php
                        $room = \App\Models\Room::where('id', $get_room['room_id'])
                            ->with('floor')
                            ->first();
                        $rate = \App\Models\Rate::where('id', $get_room['rate_id'])->first();
                        $type = \App\Models\Type::where('id', $get_room['type_id'])->first();
                    @endphp
                           
                            <div  class="flex py-1 items-center justify-between ">
                                <dt class="flex flex-col">
                                    <h1 class="underline text-green-600 text-lg font-bold uppercase">
                                        {{ $type->name ?? '' }}</h1>
                                    {{-- <h1 class="leading-3">RM #{{ $room->number ?? 'null' }}  |
                                        {{ ordinal($room->floor->number ?? 1) }} FLOOR</h1> --}}
                                </dt>
                                <dd class="text-gray-600 font-semibold text-lg">
                                    &#8369;{{ number_format($rate->amount ?? 0, 2) }}</dd>
                            </div>
                            <span class="hidden">{{ $subtotal += $rate->amount ?? 0 }}</span>
                     

                    </dl>
                    <dl class="text-sm mt-10    space-y-1">

                        <div class="flex py-1 items-center justify-between ">
                            <dt class="flex flex-col">
                                <div class="flex space-x-1">
                                    <h1 class="underline text-green-600 text-lg font-bold uppercase">CHECK-IN DEPOSIT
                                    </h1>
                                   
                                </div>
                                <h1 class="leading-3">ROOM KEY & TV REMOTE</h1>
                            </dt>
                            <dd class="text-gray-600 font-semibold text-lg">&#8369;{{ number_format(200,2) }}
                            </dd>
                        </div>

                    </dl>
                    <div class="absolute bottom-7 w-full left-0">
                        <div class="w-full grid place-content-center">
                            @if ($customer_name != null && $customer_number != null)
                                <button wire:click="confirmCheckin"
                                    class="p-2 px-5 border-2 border-green-500 text-lg rounded-full font-semibold bg-gray-600 text-white">
                                    <span>CONFIRM INFORMATION</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="bg-white bg-opacity-70 flex flex-col justify-between rounded-3xl py-8 relative px-5 shadow-xl w-96">
                <div class="isolate bg-white -space-y-px rounded-2xl shadow-lg">
                    <div
                        class="relative border border-gray-300 rounded-2xl rounded-b-none px-3 py-2 focus-within:z-10 focus-within:ring-1 focus-within:ring-gray-600 focus-within:border-gray-600">
                        <label for="name" class="block text-xs font-medium text-gray-900">Complete Name</label>
                        <input type="text" wire:model.lazy="customer_name"
                            class="block w-full h-10 text-lg border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0"
                            placeholder="JUAN DELA CRUZ">
                        @error('customer_name')
                            <span class="error text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div
                        class="relative border border-gray-300 rounded-2xl rounded-t-none px-3 py-2 focus-within:z-10 focus-within:ring-1 focus-within:ring-gray-600 focus-within:border-gray-600">
                        <label for="job-title" class="block text-xs font-medium text-gray-900">Contact Number</label>
                        <input type="number" wire:model="customer_number"
                            class="block w-full h-10 text-lg border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 "
                            placeholder="09*********">
                        @error('customer_number')
                            <span class="error text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col">
                    <div class="bg-white shadow rounded-xl p-3">
                        <dl class="text-sm font-medium text-gray-500  space-y-2">
                            <div class="flex py-3 justify-between font-semibold">
                                <dt>Subtotal</dt>
                                <dd class="text-gray-600">&#8369;{{ number_format($subtotal + 200, 2) }}</dd>
                            </div>

                            <div
                                class="flex items-center justify-between font-bold border-t border-gray-200 text-gray-700 pt-6">
                                <dt class="text-base font-">Total</dt>
                                <dd class="text-base">&#8369;{{ number_format($subtotal +  200, 2) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div x-show="steps==4" x-cloak class="relative">
        <div class="mx-40  mt-10">
            <h1 class="text-4xl font-black text-white">THANK YOU FOR STAYING IN OUR HOTEL |</h1>
            <div class=" bg-white rounded-3xl bg-opacity-50 relative grid place-content-center mt-5 h-[33rem]">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $qr_code }}"
                    class=" h-96" alt="">
                <div class="absolute bottom-5 text-center w-full left-0 ">
                    <p class="italic  text-red-600 text-sm ">Note: Show your printed QR-CODE to our front-desk to
                        validate.</p>
                </div>
                <div class="absolute right-0 bottom-0">
                    <button
                        class="p-4 px-6 bg-gray-600 text-white fill-white flex items-center space-x-1 rounded-br-3xl border-t-4 border-l-4 border-yellow-300 font-semibold">
                        <span>PRINT QR</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M7 17h10v5H7v-5zm12 3v-5H5v5H3a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-2zM5 10v2h3v-2H5zm2-8h10a1 1 0 0 1 1 1v3H6V3a1 1 0 0 1 1-1z" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
