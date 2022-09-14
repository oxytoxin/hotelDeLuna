<div>
    <div>
        @php
            $headers = ['Hours', 'Amount', 'Room Type', ''];
        @endphp
        <div class="mt-5">
            <div class="flex flex-col">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <div class="flex justify-between px-2 py-3 bg-white border-b border-gray-200 sm:px-6">
                                <div>
                                </div>
                                <div>
                                    <x-button primary
                                        wire:click="$set('showModal', true)"
                                        label="Add Rate" />
                                </div>
                            </div>
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach ($headers as $header)
                                            <th scope="col"
                                                class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">
                                                {{ $header }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($rates as $rate)
                                        <tr>
                                            <td
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                {{ $rate->staying_hour->number }}
                                            </td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $rate->amount }}
                                            </td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $rate->type->name }}
                                            </td>
                                            <td
                                                class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                <button wire:key="{{ $rate->id }}"
                                                    wire:click="edit({{ $rate->id }})"
                                                    wire:loading.class="cursor-progress"
                                                    wire:loading.attr="disabled"
                                                    wire:target="edit({{ $rate->id }})"
                                                    class="uppercase text-primary-600 hover:text-primary-900">Edit</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                No Rates Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="py-2">
                            {{ $rates->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:key="modal-panel">
        <x-modal.card title="{{ $this->getModeTitle() }}"
            wire:model.defer="showModal">
            <form>
                @csrf
                <div class="sm:grid sm:grid-cols-2 gap-3">
                    <x-native-select label="Select Hours"
                        wire:model.defer="staying_hour_id">
                        <option value=""
                            disabled>Select Hours</option>
                        @foreach ($hours as $hour)
                            <option value="{{ $hour->id }}">{{ $hour->number }}</option>
                        @endforeach
                    </x-native-select>
                    <x-native-select label="Select Room Type"
                        wire:model.defer="room_type_id">
                        <option value=""
                            disabled>Select type</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </x-native-select>
                    <x-input label="Amount"
                        placeholder="Enter amount"
                        type="number"
                        wire:model.defer="amount" />
                </div>
            </form>
            <x-slot:footer>
                <x-button wire:click="save"
                    spinner="save"
                    primary>
                    Save
                </x-button>
            </x-slot:footer>
        </x-modal.card>
    </div>
</div>
