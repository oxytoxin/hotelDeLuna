<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="border-b border-gray-200 bg-white ">
            <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                <div class="ml-4 mt-4">
                    <h3 class="text-xl font-bold leading-6 text-gray-700">RATES</h3>
                    <p class="mt-1 text-sm text-gray-500">A list of all rates
                        </p>
                </div>
                <div class="ml-4 mt-4 flex-shrink-0">
                    <div class="flex justify-between space-x-1 items-center">
                        <div class="flex border items-center px-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                class="fill-gray-500" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z" />
                            </svg>
                            <input type="text" wire:model="search_rate"
                                placeholder="Search rate..."
                                class="border-0 focus:outline focus:ring-0">
                        </div>
                        <x-button wire:click="$set('create_modal', true)" class="font-semibold"
                            positive md label="+" />
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 flex flex-col">
          <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
              <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full">
                  <thead class="bg-white">
                    <tr>
                      <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-700 sm:pl-6">HOURS</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">AMOUNT</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">ROOM TYPE</th>
                      <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                  @foreach ($types as $type)
                  <tr class="border-t border-gray-200">
                    <th colspan="5" scope="colgroup" class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-green-700 sm:px-6">{{$type->name}}</th>
                  </tr>
    
                 @foreach ($type->rates as $rate)
                 <tr class="border-t border-gray-300">
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-700 sm:pl-6">{{$rate->staying_hour->number}}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">&#8369;{{number_format($rate->amount,2)}}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{$type->name}}</td>
                  <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <x-button wire:click="editRate({{$rate->id}})" class="font-semibold" icon="pencil-alt" positive sm label="Edit" />
                  </td>
                </tr>
                 @endforeach
                  @endforeach
      
                    <!-- More people... -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div wire:key="create_modal" class="z-0">
        <x-modal.card  title="Add New Rate " blur wire:model.defer="create_modal">
          <div class="gap-3 sm:grid sm:grid-cols-2">
            <x-native-select label="Select Hours"
                wire:model.defer="hours_id">
                <option value=""
                    disabled>Select Hours</option>
                @foreach ($hours as $hour)
                    <option value="{{ $hour->id }}">{{ $hour->number }}</option>
                @endforeach
            </x-native-select>
            <x-native-select label="Select Room Type"
                wire:model.defer="type_id">
                <option value=""
                    disabled>Select type</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </x-native-select>
            <x-input label="Amount"
                placeholder="Enter amount"
                type="number"
                wire:model.defer="rate" />
        </div>
            
          
            <x-slot:footer>
                <div class="flex w-full justify-end items-center space-x-2">
                    <x-button positive wire:click="saveRate">Save</x-button>
                    <x-button wire:click="$set('create_modal', false)" default>Cancel</x-button>
                </div>
            </x-slot:footer>
        </x-modal.card>
    </div>
      <div wire:key="edit_modal" class="z-0">
        <x-modal.card  title="Edit Rate " blur wire:model.defer="edit_modal">
          <div class="gap-3 sm:grid sm:grid-cols-2">
            <x-native-select label="Select Hours"
                wire:model.defer="hours_id">
                <option value=""
                    disabled>Select Hours</option>
                @foreach ($hours as $hour)
                    <option value="{{ $hour->id }}">{{ $hour->number }}</option>
                @endforeach
            </x-native-select>
            <x-native-select label="Select Room Type"
                wire:model.defer="type_id">
                <option value=""
                    disabled>Select type</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </x-native-select>
            <x-input label="Amount"
                placeholder="Enter amount"
                type="number"
                wire:model.defer="rate" />
        </div>
            
          
            <x-slot:footer>
                <div class="flex w-full justify-end items-center space-x-2">
                    <x-button positive wire:click="updateRate">Save</x-button>
                    <x-button wire:click="$set('edit_modal', false)" default>Cancel</x-button>
                </div>
            </x-slot:footer>
        </x-modal.card>
    </div>

</div>
