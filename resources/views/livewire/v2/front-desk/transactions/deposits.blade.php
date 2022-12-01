<div x-data="{ formOpen: false }"
    x-on:close-form.window="formOpen=false">
    <div>
        <div class="px-4 pt-4 sm:px-6 lg:px-8"
            x-animate>
            <div class="flex items-center justify-center">
                <div class="sm:flex-auto">
                    <h1 class="text-lg font-semibold text-gray-900">
                        Deposits
                    </h1>
                </div>
                <div>
                    <x-my.button-primary py="py-1"
                        x-on:click="formOpen = !formOpen"
                        label="Add New" />
                </div>
            </div>
            <div x-cloak
                x-show="formOpen"
                x-collapse>
                <div class="p-4 mt-5 bg-gray-100 rounded-lg">
                    <div>
                        <div class="grid grid-cols-1 gap-4">
                            <x-my.input label="Deposit Amount"
                                wire:model.defer="depositAmount"
                                numberOnly
                                type="number" />
                            <x-my.input.textarea label="Description / Remarks"
                                type="number"
                                wire:model.defer="depositRemarks" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="flex items-center space-x-3">
                            <x-my.button-secondary label="Return" />
                            <x-my.button-success
                                x-on:click="$dispatch('confirm',{
                                title : 'Are you sure?',
                                message : 'Are you sure you want to proceed?',
                                confirmButtonText : 'Confirm',
                                cancelButtonText : 'Cancel',
                                confirmMethod : 'confirmSaveRecord',
                            })"
                                label="Save Record" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col mt-3">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-primary-600">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6 lg:pl-8">
                                            Details
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                            Amount
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                            Deposit At
                                        </th>

                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($deposits as $key=>$deposit)
                                        <tr wire:key="{{ $key . $deposit->id }}">
                                            <td class="py-3.5 pl-4 pr-3 text-xs text-gray-900 sm:pl-6 lg:pl-8">
                                                {{ $deposit->remarks }}
                                            </td>
                                            <td class="py-3.5 pl-4 pr-3 text-xs text-gray-900 sm:pl-6 lg:pl-8">
                                                {{ $deposit->amount }}
                                            </td>
                                            <td class="py-3.5 pl-4 pr-3 text-xs text-gray-900 sm:pl-6 lg:pl-8">
                                                {{ $deposit->created_at->format('M d, Y h:i:s A') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3"
                                                class="py-3.5 pl-4 pr-3 text-center text-xs text-gray-900 sm:pl-6 lg:pl-8">
                                                No data available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-2 mt-2">
                <dl class="pt-6 space-y-6 text-sm font-medium text-gray-500 border-gray-200">
                    <div class="flex justify-between">
                        <dt>
                            Total Deposits
                        </dt>
                        <dd class="text-gray-900">
                            ₱ {{ $guest->total_deposits }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>
                            Total Deducations
                        </dt>
                        <dd class="text-gray-900">
                            ₱ {{ $guest->total_deposits - $guest->deposit_balance }}
                        </dd>
                    </div>
                    <div class="flex items-center justify-between pt-6 text-gray-900 border-t border-gray-200">
                        <dt class="text-base">
                            Total Balance
                        </dt>
                        <dd class="text-base">
                            ₱ {{ $guest->deposit_balance }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    <x-my.modal title="Deposit Deduction"
        :showOn="['show-deduction-modal']"
        :closeOn="['close-deduction-modal']">
        <div>
            <x-my.input label="Amount"
                wire:model.defer="deductionAmount"
                numberOnly
                type="number" />
        </div>
        <x-slot name="footer">
            <div class="flex items-center space-x-3">
                <x-my.button-secondary label="Cancel"
                    x-on:click="close()" />
                <x-my.button-success label="Save"
                    wire:click="saveDeduction" />
            </div>
        </x-slot>
    </x-my.modal>
</div>
