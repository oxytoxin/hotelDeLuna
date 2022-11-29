<div>
    <x-my.modal title="Select Deposits"
        :showOn="['show-deposits-modal']"
        :closeOn="['close-deposits-modal']">
        <div>
            <div class="mb-2"
                x-animate>
                @if ($enoughDeposits)
                    <div class="p-4 border border-green-400 rounded-md bg-green-50">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: mini/information-circle -->
                                <svg class="w-5 h-5 text-green-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex-1 ml-3 md:flex md:justify-between">
                                <p class="text-sm text-green-700">
                                    Selected deposit(s) is enough to pay for the transaction.
                                </p>
                                <p class="mt-3 text-sm md:mt-0 md:ml-6">

                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <x-errors />

            </div>

            <div class="flex flex-col">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            Select
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            Amount</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Remarks/Description</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($deposits as $deposit)
                                        <tr wire:key="tr{{ $deposit->id }}"
                                            @class(['bg-green-100 ' => in_array($deposit->id, $selectedDeposits)])>
                                            <td
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                @if ($deposit->claimed_at == null && !$loop->first && $enoughDeposits == false)
                                                    <input wire:key="{{ $deposit->id }}"
                                                        value="{{ $deposit->id }}"
                                                        wire:model="selectedDeposits"
                                                        type="checkbox"
                                                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                @endif
                                            </td>
                                            <td
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                {{ $deposit->amount - $deposit->deducted }}
                                            </td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $deposit->remarks }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-slot:footer>
            <div class="flex space-x-3"
                x-animate
                wire:key="buttons">
                @if ($selectedDeposits)
                    <div id="clear">
                        <x-my.button-danger label="Clear Selected"
                            wire:click="clearSelected" />
                    </div>
                @endif
                <x-my.button-success wire:click="save"
                    label="Save" />
            </div>
        </x-slot:footer>
    </x-my.modal>
</div>
