    {{-- <div id="hh" x-data="{ steps: @entangle('step'), manage: @entangle('manageRoomPanel') }" class="font-rubik">

        <div x-show="steps==1" x-cloak class="step">
            <div class=" mt-5 mx-10 flex justify-between">
                <h1 class="font-black text-3xl font-rubik text-white">PLEASE SELECT ROOM TYPE: |</h1>
                <x-cancel-transaction wire:click="cancelTransaction" />
            </div>
            <div class=" mx-10  flex justify-between space-x-10">
                <div class="flex-1">
                    <div class="grid xl:grid-cols-5 lg:grid-cols-4  gap-5 h-[33rem] overflow-y-auto rounded-3xl ">

                        @foreach ($roomtypes as $roomtype)
                            <button wire:click="selectRoomType({{ $roomtype->id }})" class="relative">
                                <div class="absolute inset-0     opacity-80 rounded-r-3xl rounded-bl-3xl blur">
                                </div>
                                <div
                                    class="bg-white {{ $get_room['type_id'] == $roomtype->id ? 'bg-opacity-100 text-gray-700' : 'bg-opacity-50 text-white ' }} rounded-3xl p-3 relative  py-4 h-48">
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
                                        <h1 class="font-black  text-3xl text-center uppercase ">
                                            {{ $roomtype->name }}</h1>
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>

                </div>

                <div class="fixed bottom-5 -left-10 grid place-content-center right-0">
                    @if ($get_room['type_id'] != '')
                        <x-button wire:click="$set('step',2)" label="NEXT" xl positive
                            class="font-bold text-xl mx-auto " right-icon="arrow-circle-right" />
                    @endif
                </div>
            </div>
        </div>
        <div x-show="steps==2" x-cloak class="step relative h-[33rem]">
            <div class="mx-10 mt-5 font-rubik">
                <div class="flex justify-between items-center ">
                    <h1 class="font-black text-3xl font-rubik text-white">PLEASE SELECT YOUR ROOM |</h1>

                    <div class="font-rubik flex space-x-1 justify-between">
                        <x-cancel-transaction wire:click="cancelTransaction" />
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
                <div class="div">
                    <div class="my-5 space-x-3  flex">
                        @foreach ($floors as $key => $floor)
                            @if ($floor->rooms->where('room_status_id', 1)->where('type_id', $type_key)->count() > 0)
                                <button wire:click="$set('floor_id', {{ $floor->id }})"
                                    class="{{ $floor_id == $floor->id ? 'bg-green-500 text-white border-white' : '' }} bg-white border-4 border-green-500 text-gray-700 hover:bg-green-500 hover:border-white hover:text-white p-2 px-4 shadow-lg rounded-full">
                                    <span class="text-2xl font-bold  uppercase">{{ ordinal($floor->number) }}
                                        FLOOR</span>
                                </button>
                            @endif
                        @endforeach
                    </div>
                    <div class="grid mt-5 xl:grid-cols-5 lg:grid-cols-4 xl:gap-10 lg:gap-5">
                        @forelse ($rooms as $key =>  $room)
                            <button wire:key="{{ $key }}" class="relative"
                                wire:click="selectRoom({{ $room->id }})">
                                <div class="absolute inset-0 bg-gray-400 opacity-80 rounded-3xl  blur">
                                </div>
                                <div class="bg-white  relative xl:h-64 lg:h-60 rounded-3xl ">
                                    <div
                                        class="absolute w-20 h-14 shadow-xl rounded-xl grid place-content-center top-0 bg-green-500 left-0">
                                        <span
                                            class="font-bold text-lg uppercase
                font-rubik text-white">{{ ordinal($room->floor->number) }}</span>
                                    </div>
                                    <div class="relative grid place-content-center h-full">
                                        <h1 class="font-black text-4xl text-center text-gray-600">ROOM
                                            #{{ $room->number }}
                                        </h1>

                                    </div>
                                </div>
                            @empty
                                <div
                                    class="xl:col-span-5 h-auto mt-20 lg:col-span-4 flex flex-col justify-center items-center">
                                    <x-svg.no-result class="h-40" />
                                    <h1 class="text-white">No Room available...</h1>
                                </div>
                        @endforelse
                    </div>
                </div>


            </div>
        </div>
        <div x-show="steps==3" x-cloak class="relative mx-10">
            <div class="flex mt-2 font-rubik items-center justify-between">
                <h1 class="font-black xl:text-3xl lg:text-2xl font-rubik text-gray-300">PLEASE CONFIRM YOUR CHECK-IN
                    INFORMATION |</h1>
                <div class="flex justify-between space-x-1">
                    <x-cancel-transaction wire:click="cancelTransaction" />
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

                            <div class="flex py-1 items-center justify-between ">
                                <dt class="flex flex-col">
                                    <h1 class="underline text-green-600 text-lg font-bold uppercase">
                                        {{ $type->name ?? '' }}</h1>
                                    <h1 class="leading-3">RM #{{ $room->number ?? 'null' }} |
                                        {{ ordinal($room->floor->number ?? 1) }} FLOOR</h1>
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
                                        <h1 class="underline text-green-600 text-lg font-bold uppercase">CHECK-IN
                                            DEPOSIT
                                        </h1>

                                    </div>
                                    <h1 class="leading-3">ROOM KEY & TV REMOTE</h1>
                                </dt>
                                <dd class="text-gray-600 font-semibold text-lg">&#8369;{{ number_format(200, 2) }}
                                </dd>
                            </div>

                        </dl>
                        <div class="absolute bottom-7 w-full left-0">
                            <div class="w-full grid place-content-center">
                                @if ($customer_name != null)
                                    <button wire:click="confirmCheckin"
                                        class="p-2 px-5 border-2 border-gray-700 text-lg rounded-full font-semibold bg-green-600 text-white">
                                        <span>CONFIRM INFORMATION</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white bg-opacity-70 flex flex-col justify-between rounded-3xl py-8 relative px-5 shadow-xl w-96">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute h-64 top-0 -right-40 transform scale-x-[-1]"
                        viewBox="0 0 463.99206 466.77877" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path
                            d="M88.49769,448.81027c-2.06592,.12937-3.20768-2.43737-1.64468-3.93333l.1555-.61819c-.02047-.04951-.04105-.09897-.06178-.14839-2.08924-4.9818-6.87922,4.28984-8.95069,9.27903-1.83859,4.42817-6.47012-.37337-7.04649,4.30868-.25838,2.0668-.14213,4.17236,.31648,6.20047-4.30807-9.41059-6.57515-19.68661-6.57515-30.02077,0-2.59652,.14213-5.19301,.43275-7.78295,.239-2.11854,.56839-4.2241,.99471-6.31034,2.30575-11.2772,7.29852-22.01825,14.50012-30.98962,3.46197-1.89248,6.34906-4.85065,8.09295-8.39652,.62649-1.27891-3.94789-2.60741-3.71537-4.00896-.39398,.05168,3.57972-5.99588,3.87688-6.36402-.54906-.83317-1.53178-1.24733-2.13144-2.06034-2.98232-4.04341-7.0912-3.33741-9.23621,2.15727-4.58224,2.31266-4.62659,6.14806-1.81495,9.83683,1.78878,2.34682,2.03456,5.52233,3.60408,8.03478-.16151,.20671-.32944,.40695-.4909,.61366-2.96106,3.79788-5.52208,7.88002-7.68104,12.16859,.61017-4.76621-.29067-10.50822-1.82641-14.20959-1.74819-4.21732-5.02491-7.76915-7.91045-11.41501-3.46601-4.37924-10.57337-2.46806-11.18401,3.08332-.00591,.05375-.01166,.10745-.01731,.1612,.4286,.24178,.84849,.49867,1.25864,.76992,2.33949,1.54723,1.53096,5.17386-1.24107,5.60174l-.06277,.00967c.15503,1.54366,5.46945,10.10703,5.85695,11.61197-3.70179,14.31579-.7595,12.4973,10.65186,12.73153,.25191,.12916,.49738,.25832,.74929,.38109-1.15617,3.25525-2.07982,6.59447-2.76441,9.97891-.61359,2.99043-1.03991,6.01317-1.27885,9.04888-.29715,3.83006-.27129,7.67959,.05168,11.50323l-.01939-.13562c-.82024-4.21115-3.10671-8.14462-6.4266-10.87028-4.94561-4.06264-11.93282-5.55869-17.26826-8.82425-2.56833-1.57196-5.85945,.45945-5.41121,3.43708l.02182,.14261c.79443,.32289,1.56947,.69755,2.31871,1.11733,.4286,.24184,.84848,.49867,1.25864,.76992,2.33949,1.54729,1.53096,5.17392-1.24107,5.6018l-.06282,.00965c-.0452,.00646-.08397,.01295-.12911,.01944,1.36282,3.23581,11.17287,.4987,13.54973,3.0887,2.31463,12.49713,4.34484,19.42335,14.97904,15.78406h.00648c1.16259,5.06378,2.86128,10.01127,5.0444,14.72621h18.02019c.06463-.20022,.12274-.40692,.18089-.60717-1.6664,.10341-3.34571,.00649-4.98629-.29702,1.33701-1.64059,2.67396-3.29409,4.01097-4.93462,.03229-.0323,.05816-.0646,.08397-.09689,.67817-.8396,1.36282-1.67283,2.04099-2.51246l.00036-.00102c.04245-2.57755-.26652-5.14662-.87876-7.63984l-.00057-.00035Z"
                            fill="#f2f2f2" />
                        <path
                            d="M233.41986,25.88011c-1.65616,6.97284,7,6,3,19,0,7.46237-9.53763,7-17,7h-29c-5.01717,.31695-15.73673-1.0271-15-6l4-10c1.48068-5.6197-5.12003-5.99504-5.02496-11.80575,.10192-6.22936,6.08804-12.03925,8.02496-16.19425,1.92642-4.13248,5.30576-7.75983,14-7,2.97589,.26008,12.02322-.75415,14.92782-.05627h.00002c5.21009,1.25182,10.12152,3.52068,14.45216,6.67626h0c2.28003,2.27002,4.13,4.95997,5.44,7.95002,1.22998,2.79999,1.97998,5.87,2.15002,9.08997v.03003c.01996,.44,.02997,.87,.02997,1.31Z"
                            fill="#2f2e41" />
                        <g>
                            <polygon
                                points="178.96621 442.98553 188.53679 443.21138 193.87159 400.21436 179.74782 399.88012 178.96621 442.98553"
                                fill="#ffb6b6" />
                            <path
                                d="M211.80165,462.95264h0c0,1.61678-1.14736,2.92746-2.56272,2.92746h-18.99679s-1.86944-7.51466-9.49144-10.74863l-.52605,10.74863h-9.79978l1.18735-17.2833s-2.62149-9.24663,2.82279-13.97324c5.44434-4.72661,1.03463-4.06863,1.03463-4.06863l2.1417-10.69706,14.80852,1.74139,.10888,16.79188,7.18647,16.6675,10.54081,5.20699c.93818,.46343,1.54551,1.51939,1.54551,2.68698l.00012,.00003Z"
                                fill="#2f2e41" />
                        </g>
                        <g>
                            <polygon
                                points="125.31752 395.47407 132.36636 401.95179 164.71734 373.13133 154.31564 363.57115 125.31752 395.47407"
                                fill="#ffb6b6" />
                            <path
                                d="M136.8518,432.13211h0c-1.0656,1.21592-2.79235,1.44543-3.85679,.51258l-14.28682-12.52057s3.54689-6.88363-.05388-14.33937l-7.47993,7.73695-7.37007-6.45893,12.2842-12.2156s4.12282-8.68186,11.33253-8.64832c7.20975,.03358,3.4597-2.37797,3.4597-2.37797l8.66101-6.63331,9.98924,11.06977-10.98545,12.70035-5.58068,17.27157,4.49551,10.86333c.40013,.96688,.16091,2.16131-.60863,3.03941l.00007,.0001Z"
                                fill="#2f2e41" />
                        </g>
                        <path d="M180.41986,145.88011s2,15-10,27l41,16,30-11s-11-23-6-30l-55-2Z" fill="#ffb6b6" />
                        <path
                            d="M222.41986,53.88011l-29.5,2.5h-.00002c-13.07943,8.71964-20.79749,23.51716-20.4631,39.23312l.11195,5.26186c.18784,8.82865,1.07141,17.62368,2.50206,26.33767,1.20713,7.35254,7.34911,32.66735-5.65089,45.66735l68-10s-6-16,2.21777-34.79584c5.16664-11.81724,2.79946-25.64206,1.43511-38.46703l-2.15288-20.23712-16.5-15.5Z"
                            fill="#f9a826" />
                        <g>
                            <path
                                d="M339.75449,94.40466c-2.07003,.90807-3.76333,2.2084-4.90247,3.63589l-20.26615,7.40501,3.8057,9.54037,20.14824-8.53884c1.82178,.12863,3.92527-.23662,5.9953-1.14469,4.72897-2.07449,7.49235-6.19573,6.17221-9.20506-1.32014-3.00933-6.22386-3.76717-10.95282-1.69268h-.00001Z"
                                fill="#ffb6b6" />
                            <path
                                d="M229.41986,67.38011s6.20472-6,15.60236-1,39.39764,45,39.39764,45l43-13,5.2874,13-54.2874,21-49-45.52362v-19.47638Z"
                                fill="#f9a826" />
                        </g>
                        <circle cx="210.59142" cy="27.19304" r="20.83084" fill="#ffb6b6" />
                        <path
                            d="M236.41986,23.88011c-.78998,1.14001-4.98382-3.03076-11.42383-3.49072-1.64001-.12-5.33618,5.41071-9.57617,5.49072-2.81,.04999-4.53998,.02997-8,0-4.08997-.04004-5.20996-.12-6-1-1.52997-1.71002-.26996-4.75-1-5-.60999-.21002-2.19,1.66998-3,4-1.70001,4.89001,4.40002,11.70001,5,18,.64001,6.78998-5.65997-6.22003-5,0,.73999,7,3.39001,6.46997,3.35999,9-.00995,.38-.12,.70996-.35999,1-.20996,.26001-.41998,.35999-4,1-4.27997,.76996-6.42999,1.14996-7,1-1.46997-.38-2.96002-2.48999-4-4-1.72003-2.47003-.5,.01996,0-3,.48004-2.92004,1.98004-3.29999,2-6,.02002-3.40002-2.34998-4.42999-4-8-3.04999-6.60004-.07001-14.23999,1-17,.51389-1.3236,1.44601-2.99879,3.0796-5.76657,1.31144-2.22197,3.052-4.17932,5.17476-5.64591,3.18156-2.19811,6.87685-3.70425,10.87238-4.30104,2.1885-.32688,4.41977-.15522,6.57131,.36174l5.57333,1.33912c2.34266,.56287,4.55104,1.58304,6.49826,3.00191h0c1.81493,.00604,3.38873,1.17908,4.01102,2.884,.06512,.17842,.12438,.28235,.17315,.2671,10.04618-3.14035,10.03943,6.16082,9.92927,11.97116-.01127,.59469,.01006,1.12097,.08694,1.54847v.03003c.20001,1.14996,.25,1.98999,.02997,2.31Z"
                            fill="#2f2e41" />
                        <path
                            d="M238.41986,166.88011s-11,23-68,3c-7.85809-.45677-12.4227,77.74292-2,117,10.12549,38.13757,8.5,123.5,8.5,123.5l18-1,14.5-115.5-3.5-54.5,10,68-72,62,11,17,96-67s10-120-12.5-152.5Z"
                            fill="#2f2e41" />
                        <path
                            d="M0,465.58877c0,.66003,.53003,1.19,1.19006,1.19H362.48004c.65997,0,1.19-.52997,1.19-1.19,0-.65997-.53003-1.19-1.19-1.19H1.19006c-.66003,0-1.19006,.53003-1.19006,1.19Z"
                            fill="#ccc" />
                        <g>
                            <path
                                d="M391.60895,209.43227l21.06582-9.979c-8.64027,12.0581-16.08538,30.89015-20.07126,45.87552-6.74864-13.95894-17.62768-31.03873-28.39626-41.24113l22.26426,5.72768c-13.71913-67.23708-65.32031-115.50667-124.41081-115.50667l-.83648-2.42862c61.72156,0,116.37705,47.60048,130.38474,117.55221Z"
                                fill="#3f3d56" />
                            <path
                                d="M320.65093,311.88011h133.10247c5.64551,0,10.23865-4.59315,10.23865-10.23865,0-5.64551-4.59315-10.23865-10.23865-10.23865h-133.10247c-5.64551,0-10.23865,4.59315-10.23865,10.23865,0,5.64551,4.59315,10.23865,10.23865,10.23865Z"
                                fill="#f9a826" />
                        </g>
                        <g>
                            <path
                                d="M282.75449,94.40466c-2.07003,.90807-3.76333,2.2084-4.90247,3.63589l-20.26615,7.40501,3.8057,9.54037,20.14824-8.53884c1.82178,.12863,3.92527-.23662,5.9953-1.14469,4.72897-2.07449,7.49235-6.19573,6.17221-9.20506-1.32014-3.00933-6.22386-3.76717-10.95282-1.69268h-.00001Z"
                                fill="#ffb6b6" />
                            <path
                                d="M172.41986,75.69853c0-7.87084,8.31635-13.05394,15.32139-9.46513,.09333,.04782,.18699,.09672,.28097,.14672,9.39764,5,39.39764,45,39.39764,45l43-13,5.2874,13-54.2874,21-45.55944-42.32716c-2.19401-2.03835-3.44056-4.89797-3.44056-7.89273v-6.4617Z"
                                fill="#f9a826" />
                        </g>
                        <g>
                            <path
                                d="M384.71882,361.5586c-7.91992,0-14.36328-6.44336-14.36328-14.36377,0-7.91992,6.44336-14.36328,14.36328-14.36328,7.92041,0,14.36377,6.44336,14.36377,14.36328,0,7.92041-6.44336,14.36377-14.36377,14.36377Zm0-26.72705c-6.81689,0-12.36328,5.54639-12.36328,12.36328,0,6.81738,5.54639,12.36377,12.36328,12.36377,6.81738,0,12.36377-5.54639,12.36377-12.36377,0-6.81689-5.54639-12.36328-12.36377-12.36328Z"
                                fill="#3f3d56" />
                            <path
                                d="M381.83986,353.81534c-.27246,0-.54395-.11084-.74121-.32861-.37109-.40967-.33984-1.04199,.07031-1.4126l5.54883-5.02441-5.02344-5.54883c-.37109-.40918-.33887-1.0415,.07031-1.41211s1.04199-.33936,1.41211,.07031l5.69434,6.29004c.37109,.40918,.33984,1.0415-.07031,1.41211l-6.29004,5.69531c-.19141,.17334-.43164,.25879-.6709,.25879Z"
                                fill="#3f3d56" />
                        </g>
                        <path
                            d="M182.26774,18.23408c-4.68517-1.30478-7.42551-6.16058-6.12074-10.84575,1.30478-4.68517,6.16058-7.42551,10.84575-6.12074,4.68517,1.30478,8.10427,9.34774,3.29299,10.05825-5.71995,.84469-3.33284,8.21302-8.018,6.90824Z"
                            fill="#2f2e41" />
                    </svg>
                    <div class="isolate bg-white -space-y-px rounded-2xl shadow-lg">
                        <div
                            class="relative border border-gray-300 rounded-2xl rounded-b-none px-3 py-2 focus-within:z-10 focus-within:ring-1 focus-within:ring-gray-600 focus-within:border-gray-600">
                            <label for="name" class="block text-xs font-medium text-gray-900">Complete
                                Name</label>
                            <input type="text" wire:model="customer_name"
                                class="block w-full h-10 text-lg border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0"
                                placeholder="Enter your name here.">
                            @error('customer_name')
                                <span class="error text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div
                            class="relative border border-gray-300 rounded-2xl rounded-t-none px-3 py-2 focus-within:z-10 focus-within:ring-1 focus-within:ring-gray-600 focus-within:border-gray-600">
                            <label for="job-title" class="block text-xs font-medium text-gray-900">Contact Number
                                (Optional)</label>
                            <div class="flex">
                                <div
                                    class="flex items-center justify-center w-12 h-10 text-gray-600 border-r border-gray-300">
                                    <span class="text-lg font-medium">09</span>
                                </div>
                                <input type="number" wire:model="customer_number"
                                    class="block w-full h-10 text-lg pl-2 border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 "
                                    placeholder="">
                            </div>
                        </div>
                    </div>
                    @php
                        $prompt;
                        if ($customer_name != null || $customer_number != null) {
                            $prompt = true;
                        } else {
                            $prompt = false;
                        }
                    @endphp
                    @if (!$prompt)
                        <div class="bg-white text-gray-700 p-2 rounded-lg border-2 border-red-600 animate-pulse">
                            <span>Please fill out the form in order to complete your transactions. ...</span>
                        </div>
                    @endif
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
                                    <dd class="text-base">&#8369;{{ number_format($subtotal + 200, 2) }}</dd>
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
                    <div class="flex flex-col items-center justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $qr_code }}"
                            class=" h-96" alt="">
                        <span class="text-xl font-bold text-white">{{ $qr_code }}</span>
                    </div>
                    <div class="absolute bottom-5 text-center w-full left-0 ">
                        <p class="italic  text-white text-sm ">Note: Show your printed QR-CODE to our front-desk to
                            validate.</p>
                    </div>
                    <div class="absolute right-0 bottom-0">
                        <a href="{{ route('kiosk.transaction') }}"
                            class="p-4 px-6 bg-gray-600 text-white fill-white flex items-center space-x-1 rounded-br-3xl border-t-4 border-l-4 border-yellow-300 font-semibold">
                            <span>OK</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M7 17h10v5H7v-5zm12 3v-5H5v5H3a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-2zM5 10v2h3v-2H5zm2-8h10a1 1 0 0 1 1 1v3H6V3a1 1 0 0 1 1-1z" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div x-show="manage" x-cloak class="relative z-10" role="dialog" aria-modal="true">

            <div x-show="manage" x-cloak x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-40 transition-opacity">
            </div>

            <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">

                <div wire:loading.remove wire:target="room_key" x-show="manage" x-cloak
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="mx-auto h-[30rem]  font-rubik max-w-3xl transform divide-y divide-gray-500 divide-opacity-10 overflow-hidden rounded-xl bg-white bg-opacity-80 shadow-2xl ring-1 ring-black ring-opacity-5 backdrop-blur backdrop-filter transition-all">
                    <div class="relative p-6 h-full">
                        <div class="transaction flex flex-col ">
                            <div class="flex justify-between items-start">
                                <div class="bg-white grid place-content-center h-14 w-14 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        class="h-6 w-6 fill-green-600">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M17 19h2v-8h-6v8h2v-6h2v6zM3 19V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2H2v-2h1zm4-8v2h2v-2H7zm0 4v2h2v-2H7zm0-8v2h2V7H7z" />
                                    </svg>
                                </div>
                                <button wire:click="closeManageRoomPanel" class="hover:fill-red-600 fill-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-7 w-7">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                                    </svg>
                                </button>
                            </div>
                            @php
                                $room = \App\Models\Room::where('id', $get_room['room_id'])
                                    ->with('floor')
                                    ->first();
                                $type = \App\Models\Type::where('id', $get_room['type_id'])->first();
                            @endphp
                            <div class="texttts mt-5">
                                <h1 class="text-3xl text-gray-600 underline font-rubik font-black">ROOM
                                    #{{ $room->number ?? 'none' }} | {{ ordinal($room->floor->number ?? 1) }}
                                    FLOOR</h1>
                            </div>
                            <div class="texttts ">
                                <h1 class="text-lg text-green-700 font-semibold flex-auto font-rubik">
                                    {{ $type['name'] ?? 'None' }}</h1>
                            </div>


                        </div>

                        <div class="mt-20 w-full font-rubik">
                            <h1 class="text-lg text-gray-600 font-rubik font-black">SELECT HOUR </h1>
                            <div class="flex  w-full">
                                <div class="mt-3 relative flex space-x-4 ">
                                    @foreach ($rates as $item)
                                        <button wire:click="selectRate({{ $item->id }})"
                                            class="{{ $get_room['rate_id'] == $item->id ? 'bg-green-500 text-white' : 'bg-white text-gray-600' }} border h-14 w-20 p-1 rounded-xl flex flex-col justify-center items-center">
                                            <span
                                                class="uppercase text-lg  font-semibold text-center ">{{ $item->staying_hour->number }}</span>
                                            <span
                                                class="uppercase   text-center ">&#8369;{{ number_format($item->amount, 2) }}</span>
                                        </button>
                                    @endforeach
                                </div>

                            </div>
                            @error('get_room.rate_id')
                                <span class="error mt-2 animate-pulse text-red-600 text-sm">Rate is required to
                                    proceed.</span>
                            @enderror
                        </div>
                        <div class="absolute bottom-6 right-6">
                            <div class="flex space-x-2">

                                <x-button wire:click="confirmRate" right-icon="arrow-circle-right" xl
                                    class="font-bold" primary label="NEXT" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="font-rubik" x-data="{ confirm: @entangle('confirmModal'), manage: @entangle('manageRoomPanel') }">
      @switch($step)
        @case(1)
          <div class=" mt-5 mx-10 flex justify-between">
            <h1 class="font-black text-3xl font-rubik text-white">PLEASE SELECT ROOM TYPE: |</h1>
            <x-cancel-transaction wire:click="cancelTransaction" />
          </div>
          <div class=" mx-10  flex justify-between space-x-10">
            <div class="flex-1">
              <div class="grid xl:grid-cols-5 lg:grid-cols-4  gap-5 h-[33rem] overflow-y-auto rounded-3xl ">

                @foreach ($roomtypes as $roomtype)
                  <button wire:click="selectRoomType({{ $roomtype->id }})" class="relative">
                    <div class="absolute inset-0     opacity-80 rounded-r-3xl rounded-bl-3xl blur">
                    </div>
                    <div
                      class="bg-white {{ $get_room['type_id'] == $roomtype->id ? 'bg-opacity-100 text-gray-700' : 'bg-opacity-50 text-white ' }} rounded-3xl p-3 relative  py-4 h-48">
                      <div
                        class="absolute {{ $get_room['type_id'] == $roomtype->id ? 'bg-red-500 text-white' : 'bg-green-500 ' }} border border-green-700 right-2 top-2 h-10 w-10 rounded-full shadow-lg grid place-content-center">

                        <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                          <path
                            d="M3 6.25C3 4.45507 4.45507 3 6.25 3H17.75C19.5449 3 21 4.45507 21 6.25V17.75C21 19.5449 19.5449 21 17.75 21H12.7141C13.5116 20.1503 14 19.0072 14 17.75V14.75C14 12.1266 11.8734 10 9.25 10H6.25C4.99279 10 3.84965 10.4884 3 11.2859V6.25ZM3 14.75V17.75C3 19.5449 4.45507 21 6.25 21H9.25C11.0449 21 12.5 19.5449 12.5 17.75V14.75C12.5 12.9551 11.0449 11.5 9.25 11.5H6.25C4.45507 11.5 3 12.9551 3 14.75Z"
                            fill="currentColor"></path>
                        </svg>
                      </div>
                      <div class="relative grid place-content-center h-full">
                        <h1 class="font-black  text-3xl text-center uppercase ">
                          {{ $roomtype->name }}</h1>
                      </div>
                    </div>
                  </button>
                @endforeach
              </div>

            </div>

            <div class="fixed bottom-5 -left-10 grid place-content-center right-0">
              @if ($get_room['type_id'] != '')
                <x-button wire:click="$set('step',2)" label="NEXT" xl positive class="font-bold text-xl mx-auto "
                  right-icon="arrow-circle-right" />
              @endif
            </div>
          </div>
        @break

        @case(2)
          <div class="mx-10 mt-5 font-rubik">
            <div class="flex justify-between items-center ">
              <h1 class="font-black text-3xl font-rubik text-white">PLEASE SELECT YOUR ROOM |</h1>

              <div class="font-rubik flex space-x-1 justify-between">
                <x-cancel-transaction wire:click="cancelTransaction" />
                <button wire:click="previousTransaction"
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
            <div class="div">
              <div class="my-5 space-x-3  flex">
                @foreach ($floors as $key => $floor)
                  @if ($floor->rooms->where('room_status_id', 1)->where('type_id', $type_key)->count() > 0)
                    <button wire:click="$set('floor_id', {{ $floor->id }})"
                      class="{{ $floor_id == $floor->id ? 'bg-green-500 text-white border-white' : '' }} bg-white border-4 border-green-500 text-gray-700 hover:bg-green-500 hover:border-white hover:text-white p-2 px-4 shadow-lg rounded-full">
                      <span class="text-2xl font-bold  uppercase">{{ ordinal($floor->number) }}
                        FLOOR</span>
                    </button>
                  @endif
                @endforeach
              </div>
              <div class="grid mt-5 xl:grid-cols-5 lg:grid-cols-4 xl:gap-10 lg:gap-5">
                @forelse ($rooms as $key =>  $room)
                  <button wire:key="{{ $key }}" class="relative" wire:click="selectRoom({{ $room->id }})">
                    <div class="absolute inset-0 bg-gray-400 opacity-80 rounded-3xl  blur">
                    </div>
                    <div class="bg-white  relative xl:h-64 lg:h-60 rounded-3xl ">
                      <div
                        class="absolute w-20 h-14 shadow-xl rounded-xl grid place-content-center top-0 bg-green-500 left-0">
                        <span
                          class="font-bold text-lg uppercase
                font-rubik text-white">{{ ordinal($room->floor->number) }}</span>
                      </div>
                      <div class="relative grid place-content-center h-full">
                        <h1 class="font-black text-4xl text-center text-gray-600">ROOM
                          #{{ $room->number }}
                        </h1>

                      </div>
                    </div>
                  @empty
                    <div class="xl:col-span-5 h-auto mt-20 lg:col-span-4 flex flex-col justify-center items-center">
                      <x-svg.no-result class="h-40" />
                      <h1 class="text-white">No Room available...</h1>
                    </div>
                @endforelse
              </div>
            </div>


          </div>
        @break

        @case(3)
          <div class="relative mx-10">
            <div class="flex mt-2 font-rubik items-center justify-between">
              <h1 class="font-black xl:text-3xl lg:text-2xl font-rubik text-gray-300">PLEASE CONFIRM YOUR CHECK-IN
                INFORMATION |</h1>
              <div class="flex justify-between space-x-1">
                <x-cancel-transaction wire:click="cancelTransaction" />
                <button wire:click="previousTransaction"
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

                    <div class="flex py-1 items-center justify-between ">
                      <dt class="flex flex-col">
                        <h1 class="underline text-green-600 text-lg font-bold uppercase">
                          {{ $type->name ?? '' }}</h1>
                        <h1 class="leading-3">RM #{{ $room->number ?? 'null' }} |
                          {{ ordinal($room->floor->number ?? 1) }} FLOOR</h1>
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
                          <h1 class="underline text-green-600 text-lg font-bold uppercase">CHECK-IN
                            DEPOSIT
                          </h1>

                        </div>
                        <h1 class="leading-3">ROOM KEY & TV REMOTE</h1>
                      </dt>
                      <dd class="text-gray-600 font-semibold text-lg">&#8369;{{ number_format(200, 2) }}
                      </dd>
                    </div>

                  </dl>
                  @php
                    $prompt;
                    if ($customer_name != null || $customer_number != null) {
                        $prompt = true;
                    } else {
                        $prompt = false;
                    }
                  @endphp
                  @if (!$prompt)
                    <div class="bg-white mt-20 mx-20 text-gray-700 p-2 rounded-lg border-2 border-red-600 animate-pulse">
                      <span>Please fill out the form in order to complete your transactions...</span>
                    </div>
                  @endif
                  <div class="absolute bottom-7 w-full left-0">
                    <div class="w-full grid place-content-center">
                      @if ($customer_name != null)
                        <button wire:click="confirmCheckin"
                          class="p-2 px-5 border-2 border-gray-700 text-lg rounded-full font-semibold bg-green-600 text-white">
                          <span>CONFIRM INFORMATION</span>
                        </button>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="bg-white bg-opacity-70 flex flex-col justify-between rounded-3xl py-8 relative px-5 shadow-xl w-96">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute h-64 top-0 -right-40 transform scale-x-[-1]"
                  viewBox="0 0 463.99206 466.77877" xmlns:xlink="http://www.w3.org/1999/xlink">
                  <path
                    d="M88.49769,448.81027c-2.06592,.12937-3.20768-2.43737-1.64468-3.93333l.1555-.61819c-.02047-.04951-.04105-.09897-.06178-.14839-2.08924-4.9818-6.87922,4.28984-8.95069,9.27903-1.83859,4.42817-6.47012-.37337-7.04649,4.30868-.25838,2.0668-.14213,4.17236,.31648,6.20047-4.30807-9.41059-6.57515-19.68661-6.57515-30.02077,0-2.59652,.14213-5.19301,.43275-7.78295,.239-2.11854,.56839-4.2241,.99471-6.31034,2.30575-11.2772,7.29852-22.01825,14.50012-30.98962,3.46197-1.89248,6.34906-4.85065,8.09295-8.39652,.62649-1.27891-3.94789-2.60741-3.71537-4.00896-.39398,.05168,3.57972-5.99588,3.87688-6.36402-.54906-.83317-1.53178-1.24733-2.13144-2.06034-2.98232-4.04341-7.0912-3.33741-9.23621,2.15727-4.58224,2.31266-4.62659,6.14806-1.81495,9.83683,1.78878,2.34682,2.03456,5.52233,3.60408,8.03478-.16151,.20671-.32944,.40695-.4909,.61366-2.96106,3.79788-5.52208,7.88002-7.68104,12.16859,.61017-4.76621-.29067-10.50822-1.82641-14.20959-1.74819-4.21732-5.02491-7.76915-7.91045-11.41501-3.46601-4.37924-10.57337-2.46806-11.18401,3.08332-.00591,.05375-.01166,.10745-.01731,.1612,.4286,.24178,.84849,.49867,1.25864,.76992,2.33949,1.54723,1.53096,5.17386-1.24107,5.60174l-.06277,.00967c.15503,1.54366,5.46945,10.10703,5.85695,11.61197-3.70179,14.31579-.7595,12.4973,10.65186,12.73153,.25191,.12916,.49738,.25832,.74929,.38109-1.15617,3.25525-2.07982,6.59447-2.76441,9.97891-.61359,2.99043-1.03991,6.01317-1.27885,9.04888-.29715,3.83006-.27129,7.67959,.05168,11.50323l-.01939-.13562c-.82024-4.21115-3.10671-8.14462-6.4266-10.87028-4.94561-4.06264-11.93282-5.55869-17.26826-8.82425-2.56833-1.57196-5.85945,.45945-5.41121,3.43708l.02182,.14261c.79443,.32289,1.56947,.69755,2.31871,1.11733,.4286,.24184,.84848,.49867,1.25864,.76992,2.33949,1.54729,1.53096,5.17392-1.24107,5.6018l-.06282,.00965c-.0452,.00646-.08397,.01295-.12911,.01944,1.36282,3.23581,11.17287,.4987,13.54973,3.0887,2.31463,12.49713,4.34484,19.42335,14.97904,15.78406h.00648c1.16259,5.06378,2.86128,10.01127,5.0444,14.72621h18.02019c.06463-.20022,.12274-.40692,.18089-.60717-1.6664,.10341-3.34571,.00649-4.98629-.29702,1.33701-1.64059,2.67396-3.29409,4.01097-4.93462,.03229-.0323,.05816-.0646,.08397-.09689,.67817-.8396,1.36282-1.67283,2.04099-2.51246l.00036-.00102c.04245-2.57755-.26652-5.14662-.87876-7.63984l-.00057-.00035Z"
                    fill="#f2f2f2" />
                  <path
                    d="M233.41986,25.88011c-1.65616,6.97284,7,6,3,19,0,7.46237-9.53763,7-17,7h-29c-5.01717,.31695-15.73673-1.0271-15-6l4-10c1.48068-5.6197-5.12003-5.99504-5.02496-11.80575,.10192-6.22936,6.08804-12.03925,8.02496-16.19425,1.92642-4.13248,5.30576-7.75983,14-7,2.97589,.26008,12.02322-.75415,14.92782-.05627h.00002c5.21009,1.25182,10.12152,3.52068,14.45216,6.67626h0c2.28003,2.27002,4.13,4.95997,5.44,7.95002,1.22998,2.79999,1.97998,5.87,2.15002,9.08997v.03003c.01996,.44,.02997,.87,.02997,1.31Z"
                    fill="#2f2e41" />
                  <g>
                    <polygon
                      points="178.96621 442.98553 188.53679 443.21138 193.87159 400.21436 179.74782 399.88012 178.96621 442.98553"
                      fill="#ffb6b6" />
                    <path
                      d="M211.80165,462.95264h0c0,1.61678-1.14736,2.92746-2.56272,2.92746h-18.99679s-1.86944-7.51466-9.49144-10.74863l-.52605,10.74863h-9.79978l1.18735-17.2833s-2.62149-9.24663,2.82279-13.97324c5.44434-4.72661,1.03463-4.06863,1.03463-4.06863l2.1417-10.69706,14.80852,1.74139,.10888,16.79188,7.18647,16.6675,10.54081,5.20699c.93818,.46343,1.54551,1.51939,1.54551,2.68698l.00012,.00003Z"
                      fill="#2f2e41" />
                  </g>
                  <g>
                    <polygon
                      points="125.31752 395.47407 132.36636 401.95179 164.71734 373.13133 154.31564 363.57115 125.31752 395.47407"
                      fill="#ffb6b6" />
                    <path
                      d="M136.8518,432.13211h0c-1.0656,1.21592-2.79235,1.44543-3.85679,.51258l-14.28682-12.52057s3.54689-6.88363-.05388-14.33937l-7.47993,7.73695-7.37007-6.45893,12.2842-12.2156s4.12282-8.68186,11.33253-8.64832c7.20975,.03358,3.4597-2.37797,3.4597-2.37797l8.66101-6.63331,9.98924,11.06977-10.98545,12.70035-5.58068,17.27157,4.49551,10.86333c.40013,.96688,.16091,2.16131-.60863,3.03941l.00007,.0001Z"
                      fill="#2f2e41" />
                  </g>
                  <path d="M180.41986,145.88011s2,15-10,27l41,16,30-11s-11-23-6-30l-55-2Z" fill="#ffb6b6" />
                  <path
                    d="M222.41986,53.88011l-29.5,2.5h-.00002c-13.07943,8.71964-20.79749,23.51716-20.4631,39.23312l.11195,5.26186c.18784,8.82865,1.07141,17.62368,2.50206,26.33767,1.20713,7.35254,7.34911,32.66735-5.65089,45.66735l68-10s-6-16,2.21777-34.79584c5.16664-11.81724,2.79946-25.64206,1.43511-38.46703l-2.15288-20.23712-16.5-15.5Z"
                    fill="#f9a826" />
                  <g>
                    <path
                      d="M339.75449,94.40466c-2.07003,.90807-3.76333,2.2084-4.90247,3.63589l-20.26615,7.40501,3.8057,9.54037,20.14824-8.53884c1.82178,.12863,3.92527-.23662,5.9953-1.14469,4.72897-2.07449,7.49235-6.19573,6.17221-9.20506-1.32014-3.00933-6.22386-3.76717-10.95282-1.69268h-.00001Z"
                      fill="#ffb6b6" />
                    <path
                      d="M229.41986,67.38011s6.20472-6,15.60236-1,39.39764,45,39.39764,45l43-13,5.2874,13-54.2874,21-49-45.52362v-19.47638Z"
                      fill="#f9a826" />
                  </g>
                  <circle cx="210.59142" cy="27.19304" r="20.83084" fill="#ffb6b6" />
                  <path
                    d="M236.41986,23.88011c-.78998,1.14001-4.98382-3.03076-11.42383-3.49072-1.64001-.12-5.33618,5.41071-9.57617,5.49072-2.81,.04999-4.53998,.02997-8,0-4.08997-.04004-5.20996-.12-6-1-1.52997-1.71002-.26996-4.75-1-5-.60999-.21002-2.19,1.66998-3,4-1.70001,4.89001,4.40002,11.70001,5,18,.64001,6.78998-5.65997-6.22003-5,0,.73999,7,3.39001,6.46997,3.35999,9-.00995,.38-.12,.70996-.35999,1-.20996,.26001-.41998,.35999-4,1-4.27997,.76996-6.42999,1.14996-7,1-1.46997-.38-2.96002-2.48999-4-4-1.72003-2.47003-.5,.01996,0-3,.48004-2.92004,1.98004-3.29999,2-6,.02002-3.40002-2.34998-4.42999-4-8-3.04999-6.60004-.07001-14.23999,1-17,.51389-1.3236,1.44601-2.99879,3.0796-5.76657,1.31144-2.22197,3.052-4.17932,5.17476-5.64591,3.18156-2.19811,6.87685-3.70425,10.87238-4.30104,2.1885-.32688,4.41977-.15522,6.57131,.36174l5.57333,1.33912c2.34266,.56287,4.55104,1.58304,6.49826,3.00191h0c1.81493,.00604,3.38873,1.17908,4.01102,2.884,.06512,.17842,.12438,.28235,.17315,.2671,10.04618-3.14035,10.03943,6.16082,9.92927,11.97116-.01127,.59469,.01006,1.12097,.08694,1.54847v.03003c.20001,1.14996,.25,1.98999,.02997,2.31Z"
                    fill="#2f2e41" />
                  <path
                    d="M238.41986,166.88011s-11,23-68,3c-7.85809-.45677-12.4227,77.74292-2,117,10.12549,38.13757,8.5,123.5,8.5,123.5l18-1,14.5-115.5-3.5-54.5,10,68-72,62,11,17,96-67s10-120-12.5-152.5Z"
                    fill="#2f2e41" />
                  <path
                    d="M0,465.58877c0,.66003,.53003,1.19,1.19006,1.19H362.48004c.65997,0,1.19-.52997,1.19-1.19,0-.65997-.53003-1.19-1.19-1.19H1.19006c-.66003,0-1.19006,.53003-1.19006,1.19Z"
                    fill="#ccc" />
                  <g>
                    <path
                      d="M391.60895,209.43227l21.06582-9.979c-8.64027,12.0581-16.08538,30.89015-20.07126,45.87552-6.74864-13.95894-17.62768-31.03873-28.39626-41.24113l22.26426,5.72768c-13.71913-67.23708-65.32031-115.50667-124.41081-115.50667l-.83648-2.42862c61.72156,0,116.37705,47.60048,130.38474,117.55221Z"
                      fill="#3f3d56" />
                    <path
                      d="M320.65093,311.88011h133.10247c5.64551,0,10.23865-4.59315,10.23865-10.23865,0-5.64551-4.59315-10.23865-10.23865-10.23865h-133.10247c-5.64551,0-10.23865,4.59315-10.23865,10.23865,0,5.64551,4.59315,10.23865,10.23865,10.23865Z"
                      fill="#f9a826" />
                  </g>
                  <g>
                    <path
                      d="M282.75449,94.40466c-2.07003,.90807-3.76333,2.2084-4.90247,3.63589l-20.26615,7.40501,3.8057,9.54037,20.14824-8.53884c1.82178,.12863,3.92527-.23662,5.9953-1.14469,4.72897-2.07449,7.49235-6.19573,6.17221-9.20506-1.32014-3.00933-6.22386-3.76717-10.95282-1.69268h-.00001Z"
                      fill="#ffb6b6" />
                    <path
                      d="M172.41986,75.69853c0-7.87084,8.31635-13.05394,15.32139-9.46513,.09333,.04782,.18699,.09672,.28097,.14672,9.39764,5,39.39764,45,39.39764,45l43-13,5.2874,13-54.2874,21-45.55944-42.32716c-2.19401-2.03835-3.44056-4.89797-3.44056-7.89273v-6.4617Z"
                      fill="#f9a826" />
                  </g>
                  <g>
                    <path
                      d="M384.71882,361.5586c-7.91992,0-14.36328-6.44336-14.36328-14.36377,0-7.91992,6.44336-14.36328,14.36328-14.36328,7.92041,0,14.36377,6.44336,14.36377,14.36328,0,7.92041-6.44336,14.36377-14.36377,14.36377Zm0-26.72705c-6.81689,0-12.36328,5.54639-12.36328,12.36328,0,6.81738,5.54639,12.36377,12.36328,12.36377,6.81738,0,12.36377-5.54639,12.36377-12.36377,0-6.81689-5.54639-12.36328-12.36377-12.36328Z"
                      fill="#3f3d56" />
                    <path
                      d="M381.83986,353.81534c-.27246,0-.54395-.11084-.74121-.32861-.37109-.40967-.33984-1.04199,.07031-1.4126l5.54883-5.02441-5.02344-5.54883c-.37109-.40918-.33887-1.0415,.07031-1.41211s1.04199-.33936,1.41211,.07031l5.69434,6.29004c.37109,.40918,.33984,1.0415-.07031,1.41211l-6.29004,5.69531c-.19141,.17334-.43164,.25879-.6709,.25879Z"
                      fill="#3f3d56" />
                  </g>
                  <path
                    d="M182.26774,18.23408c-4.68517-1.30478-7.42551-6.16058-6.12074-10.84575,1.30478-4.68517,6.16058-7.42551,10.84575-6.12074,4.68517,1.30478,8.10427,9.34774,3.29299,10.05825-5.71995,.84469-3.33284,8.21302-8.018,6.90824Z"
                    fill="#2f2e41" />
                </svg>
                <div class="isolate bg-white -space-y-px rounded-2xl shadow-lg">
                  <div
                    class="relative border border-gray-300 rounded-2xl rounded-b-none px-3 py-2 focus-within:z-10 focus-within:ring-1 focus-within:ring-gray-600 focus-within:border-gray-600">
                    <label for="name" class="block text-xs font-medium text-gray-900">Complete
                      Name</label>
                    <input type="text" wire:model="customer_name"
                      class="block w-full h-10 text-lg border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0"
                      placeholder="Enter your name here.">
                    @error('customer_name')
                      <span class="error text-sm text-red-500">{{ $message }}</span>
                    @enderror
                  </div>
                  <div
                    class="relative border border-gray-300 rounded-2xl rounded-t-none px-3 py-2 focus-within:z-10 focus-within:ring-1 focus-within:ring-gray-600 focus-within:border-gray-600">
                    <label for="job-title" class="block text-xs font-medium text-gray-900">Contact Number
                      (Optional)</label>
                    <div class="flex">
                      <div class="flex items-center justify-center w-12 h-10 text-gray-600 border-r border-gray-300">
                        <span class="text-lg font-medium">09</span>
                      </div>
                      <input type="number" wire:model="customer_number"
                        class="block w-full h-10 text-lg pl-2 border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 "
                        placeholder="">

                    </div>
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

                      <div class="flex items-center justify-between font-bold border-t border-gray-200 text-gray-700 pt-6">
                        <dt class="text-base font-">Total</dt>
                        <dd class="text-base">&#8369;{{ number_format($subtotal + 200, 2) }}</dd>
                      </div>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @break

        @case(4)
          <div class="mx-40  mt-10">
            <h1 class="text-4xl font-black text-white">THANK YOU FOR STAYING IN OUR HOTEL |</h1>
            <div class=" bg-white rounded-3xl bg-opacity-50 relative grid place-content-center mt-5 h-[33rem]">
              <div class="flex flex-col items-center justify-center">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $qr_code }}"
                  class=" h-96" alt="">
                <span class="text-xl font-bold text-white">{{ $qr_code }}</span>
              </div>
              <div class="absolute bottom-5 text-center w-full left-0 ">
                <p class="italic  text-white text-sm ">Note: Show your printed QR-CODE to our front-desk to
                  validate.</p>
              </div>
              <div class="absolute right-0 bottom-0">
                <a href="{{ route('kiosk.transaction') }}"
                  class="p-4 px-6 bg-gray-600 text-white fill-white flex items-center space-x-1 rounded-br-3xl border-t-4 border-l-4 border-yellow-300 font-semibold">
                  <span>OK</span>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                      d="M7 17h10v5H7v-5zm12 3v-5H5v5H3a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-2zM5 10v2h3v-2H5zm2-8h10a1 1 0 0 1 1 1v3H6V3a1 1 0 0 1 1-1z" />
                  </svg>
                </a>
              </div>
            </div>

          </div>
        @break

        @default
      @endswitch

      <div wire:key="manage" id="manage" x-show="manage" x-cloak class="relative z-10" role="dialog"
        aria-modal="true">

        <div x-show="manage" x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
          class="fixed inset-0 bg-gray-500 bg-opacity-40 transition-opacity">
        </div>

        <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">

          <div wire:loading.remove wire:target="room_key" x-show="manage" x-cloak
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            class="mx-auto h-[30rem]  font-rubik max-w-3xl transform divide-y divide-gray-500 divide-opacity-10 overflow-hidden rounded-xl bg-white bg-opacity-80 shadow-2xl ring-1 ring-black ring-opacity-5 backdrop-blur backdrop-filter transition-all">
            <div class="relative p-6 h-full">
              <div class="transaction flex flex-col ">
                <div class="flex justify-between items-start">
                  <div class="bg-white grid place-content-center h-14 w-14 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-green-600">
                      <path fill="none" d="M0 0h24v24H0z" />
                      <path
                        d="M17 19h2v-8h-6v8h2v-6h2v6zM3 19V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v5h2v10h1v2H2v-2h1zm4-8v2h2v-2H7zm0 4v2h2v-2H7zm0-8v2h2V7H7z" />
                    </svg>
                  </div>
                  <button wire:click="closeManageRoomPanel" class="hover:fill-red-600 fill-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-7 w-7">
                      <path fill="none" d="M0 0h24v24H0z" />
                      <path
                        d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                    </svg>
                  </button>
                </div>
                @php
                  $room = \App\Models\Room::where('id', $get_room['room_id'])
                      ->with('floor')
                      ->first();
                  $type = \App\Models\Type::where('id', $get_room['type_id'])->first();
                @endphp
                <div class="texttts mt-5">
                  <h1 class="text-3xl text-gray-600 underline font-rubik font-black">ROOM
                    #{{ $room->number ?? 'none' }} | {{ ordinal($room->floor->number ?? 1) }}
                    FLOOR</h1>
                </div>
                <div class="texttts ">
                  <h1 class="text-lg text-green-700 font-semibold flex-auto font-rubik">
                    {{ $type['name'] ?? 'None' }}</h1>
                </div>


              </div>

              <div class="mt-20 w-full font-rubik">
                <h1 class="text-lg text-gray-600 font-rubik font-black">SELECT HOUR </h1>
                <div class="flex  w-full">
                  <div class="mt-3 relative flex space-x-4 ">
                    @foreach ($rates as $item)
                      <button wire:click="selectRate({{ $item->id }})"
                        class="{{ $get_room['rate_id'] == $item->id ? 'bg-green-500 text-white' : 'bg-white text-gray-600' }} border h-14 w-20 p-1 rounded-xl flex flex-col justify-center items-center">
                        <span
                          class="uppercase text-lg  font-semibold text-center ">{{ $item->staying_hour->number }}</span>
                        <span class="uppercase   text-center ">&#8369;{{ number_format($item->amount, 2) }}</span>
                      </button>
                    @endforeach
                  </div>

                </div>
                @error('get_room.rate_id')
                  <span class="error mt-2 animate-pulse text-red-600 text-sm">Rate is required to
                    proceed.</span>
                @enderror
              </div>
              <div class="absolute bottom-6 right-6">
                <div class="flex space-x-2">

                  <x-button wire:click="confirmRate" right-icon="arrow-circle-right" xl class="font-bold" primary
                    label="NEXT" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="confirm" wire:key="confirm" x-show="confirm" x-cloak class="relative z-10"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!--
          Background backdrop, show/hide based on modal state.
      
          Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div x-show="confirm" x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
          x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
        </div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!--
              Modal panel, show/hide based on modal state.
      
              Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div x-show="confirm" x-cloak x-transition:enter="ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
              x-transition:leave="ease-in duration-200"
              x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
              x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md sm:p-6">
              <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button type="button"
                  class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  <span class="sr-only">Close</span>
                  <!-- Heroicon name: outline/x-mark -->
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              <div class="sm:flex sm:items-start">
                <div
                  class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <!-- Heroicon name: outline/exclamation-triangle -->
                  <svg x-on:click="confirm = false" class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 10.5v3.75m-9.303 3.376C1.83 19.126 2.914 21 4.645 21h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 4.88c-.866-1.501-3.032-1.501-3.898 0L2.697 17.626zM12 17.25h.007v.008H12v-.008z" />
                  </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Cancel Transaction</h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500">Are you sure you want to cancel your transaction? All of your
                      entry data will be deleted and this page will redirect to the selection of transaction.</p>
                  </div>
                </div>
              </div>
              <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button type="button" wire:click="confirmCancelTransaction"
                  class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Yes,
                  Cancel</button>
                <button type="button" x-on:click="confirm = false"
                  class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
