{{-- <div class="gap-4 sm:grid sm:grid-cols-2">
    <div class="sm:col-span-2">
        <x-card title="Change Room">
            <form class="gap-4 sm:grid-cols-2 sm:grid">
                @csrf
                <x-native-select label="Item"
                    wire:model="form.item_id">
                    <option value="">Select</option>
                    @foreach ($hotel_items as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </x-native-select>
                <x-input label="Amount"
                    wire:model.defer="form.amount"
                    disabled />
                <x-input label="Additional Amount"
                    wire:model.defer="form.additional_amount"
                    hint="Optional"
                    type="numeric" />
                <x-input label="Occured At"
                    wire:model.defe="form.occured_at"
                    type="datetime-local" />
                <x-checkbox id="right-label"
                    label="Paid"
                    wire:model.defer="form.paid" />
            </form>
            <x-slot:footer>
                <div class="flex items-center space-x-3">
                    <x-button negative
                        wire:click="clear_form">Clear Form</x-button>
                    <x-button wire:click="save"
                        spinner="save"
                        emerald>Save</x-button>
                </div>
            </x-slot:footer>
        </x-card>
    </div>
    <div class="sm:col-span-2">
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
                                                Item
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Amount
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Additional Charge
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Total
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3 text-xs font-medium tracking-wide text-left text-white uppercase">
                                                Date Time
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($damages as $damage)
                                            <tr>
                                                <td
                                                    class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                    {{ $damage->hotel_item->name }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    ₱ {{ $damage->amount }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    ₱ {{ $damage->additional_amount ?? 0 }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    ₱ {{ $damage->amount + $damage->additional_amount }}
                                                </td>
                                                <td
                                                    class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                    {{ $damage->created_at->format('Y/m/d h:i:s A') }}
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
</div> --}}
<div class="grid gap-4"
    x-data
    x-intersect.once="$wire.componentIsLoaded">
    <form wire:submit.prevent="save">
        <x-card title="Damages">
            @csrf
            <div class="grid-cols-2 sm:grid sm:gap-3">
                <x-native-select label="Select"
                    wire:model="form.hotel_item_id">
                    <option value="">Select</option>
                    @foreach ($hotel_items as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </x-native-select>
                <x-input label="Amount"
                    wire:model.defer="form.price"
                    disabled />
                <x-input label="Additional Amount"
                    wire:model.defer="form.additional_charge"
                    hint="Optional"
                    type="numeric" />
                <x-input label="Occured At"
                    wire:model.defer="form.occured_at"
                    type="date" />
            </div>
            <x-slot:footer>
                <div class="flex space-x-3">
                    <x-button label="Clean Form"
                        negative />
                    <x-button label="Save"
                        type="submit"
                        spinner="save"
                        positive />
                </div>
            </x-slot:footer>
        </x-card>
    </form>
    <div wire:key="salkjhfdq98ehrlkahfznkcvneiuhf9q328">
        <x-card title="Transactions">
            <x-transactions :headers="['Details', 'Amount', 'Paid At', 'Date']">
                <x-slot:body>
                    @forelse ($transactions as $key => $transaction)
                        <tr wire:key="{{ $key . $transaction->id }}">
                            <x-transactions.cell>
                                {{ $transaction->remarks }}
                            </x-transactions.cell>
                            <x-transactions.cell>
                                {{ $transaction->payable_amount }}
                            </x-transactions.cell>
                            <x-transactions.cell>
                                @if ($transaction->paid_at)
                                    {{ Carbon\Carbon::parse($transaction->paid_at)->format('M d, Y h:i:s A') }}
                                @else
                                    <button type="button"
                                        wire:click="payTransaction({{ $transaction->id }})"
                                        class="text-green-600 hover:text-green-900">
                                        <span> Pay </span>
                                    </button>
                                @endif
                            </x-transactions.cell>
                            <x-transactions.cell>
                                {{ $transaction->created_at }}
                            </x-transactions.cell>
                        </tr>
                    @empty
                        <tr>
                            <x-transactions.cell colspan="4">
                                No transactions found
                            </x-transactions.cell>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-transactions>
        </x-card>
    </div>
</div>
