<div class="gap-4 sm:grid sm:grid-cols-1">
    <div class="sm:col-span-1">
        <x-card title="Amenities">
            <div class="w-full">
                <form class="gap-4 sm:grid sm:grid-cols-2">
                    @csrf
                    <x-native-select wire:model="form.requestable_item_id"
                        label="Select Type">
                        <option value="">Select</option>
                        @foreach ($requestable_items as $requestable_item)
                            <option value="{{ $requestable_item->id }}">
                                {{ $requestable_item->name }} -- ₱{{ $requestable_item->price }}
                            </option>
                        @endforeach
                    </x-native-select>
                    <x-input type="numeric"
                        wire:model.defer="form.quantity"
                        label="Quantity" />
                    <div class="col-span-2">
                        <x-input type="numeric"
                            wire:model.defer="form.additional_amount"
                            label="Additional Amount" />
                    </div>
                    <div class="col-span-2">
                        <x-checkbox id="right-label"
                            label="Paid"
                            wire:model.defer="form.paid" />
                    </div>
                </form>
            </div>
            <x-slot:footer>
                <div class="flex items-center space-x-3">
                    <x-button negative
                        wire:click="clearForm"
                        spinner="clearForm">Clear Form</x-button>
                    <x-button emerald
                        wire:click="saveRecord"
                        spinner="saveRecord">Save Record</x-button>
                </div>
            </x-slot:footer>
        </x-card>
    </div>
    <div class="sm:col-span-1">
        {{-- <div class="grid gap-1">
            <div class="flex items-center justify-between">
                <h1 class="text-center text-gray-600">
                    Requested Items
                </h1>
                <div>
                    <button type="button"
                        wire:click="toggleToggleRequestOrder"
                        class="flex items-center space-x-2 text-gray-600">
                        <span>{{ $requestOrder == 'ASC' ? 'Oldest' : 'Newest' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25" />
                        </svg>
                    </button>
                </div>
            </div>
            <div wire:key="history-list"
                x-animate>
                @forelse ($guest_request_items as $guest_request_item)
                    <div wire:key="{{ $guest_request_item->id }}"
                        class="p-2 mb-2 bg-white border rounded-lg">
                        <div class="flex justify-between w-full">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <h1>
                                    {{ $guest_request_item->requestable_item->name }}
                                </h1>
                                <h1>
                                    | QTY: {{ $guest_request_item->quantity }}
                                </h1>
                            </div>
                            <div>
                                <h1>
                                    Total : ₱ {{ $guest_request_item->amount }}
                                    {{ $guest_request_item->additional_amount ? ' + ₱ ' . $guest_request_item->additional_amount : '' }}
                                </h1>
                            </div>
                        </div>
                    </div>
                @empty
                    <div wire:key="empty"
                        class="p-2 mb-2 bg-white border rounded-lg">
                        <div class="flex justify-between w-full">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <h1>
                                    No changes yet
                                </h1>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div> --}}
        <x-card title="Damages Record">
            <div>
                <div class="flex flex-col ">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-primary-600">
                                        <tr>
                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-white uppercase sm:pl-6">
                                                Amenities
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Quantity
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Amount
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Additional Amount
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Total Amount
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Date Time
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($guest_request_items as $guest_request_item)
                                            <tr>
                                                <td
                                                    class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                    {{ $guest_request_item->requestable_item->name }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ $guest_request_item->quantity }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    ₱ {{ $guest_request_item->amount }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    ₱ {{ $guest_request_item->additional_amount ?? 0 }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    ₱
                                                    {{ $guest_request_item->amount + $guest_request_item->additional_amount }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ $guest_request_item->created_at->format('Y/m/d h:i:s A') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                    No record found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </x-card>
    </div>
</div>
