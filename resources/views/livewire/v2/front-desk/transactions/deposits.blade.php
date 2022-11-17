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
                <div class="mt-5 rounded-lg bg-gray-100 p-4">
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
            <div class="mt-3 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
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
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                            Deduction
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                            Retrieved At
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                            Claimable
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
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
                                            <td class="py-3.5 pl-4 pr-3 text-xs text-gray-900 sm:pl-6 lg:pl-8">
                                                ₱{{ $deposit->deducted ?? '0' }}
                                            </td>
                                            <td class="py-3.5 pl-4 pr-3 text-xs text-gray-900 sm:pl-6 lg:pl-8">
                                                @if ($deposit->claimed_at)
                                                    {{ Carbon\Carbon::parse($deposit->paid_at)->format('M d, Y h:i:s A') }}
                                                @else
                                                    'Not yet'
                                                @endif
                                            </td>
                                            <td class="py-3.5 pl-4 pr-3 text-xs text-gray-900 sm:pl-6 lg:pl-8">
                                                ₱{{ $deposit->amount - $deposit->deducted }}
                                            </td>
                                            <td class="py-2 pl-4 pr-3 text-xs text-gray-900 sm:pl-6 lg:pl-8">
                                                <div class="flex gap-2">
                                                    @if (!$deposit->claimed_at)
                                                        <x-my.button-warning label="Deduct"
                                                            py="py-1"
                                                            wire:click="showDeductionModal({{ $deposit->id }})" />
                                                        <x-my.button-success label="Claim"
                                                            py="py-1"
                                                            x-on:click="$dispatch('confirm',{
                                                            title : 'Are you sure?',
                                                            message : 'Are you sure you want to proceed? Guest has PHP {{ $deposit->amount - $deposit->deducted }} left to claim.',
                                                            confirmButtonText : 'Confirm',
                                                            cancelButtonText : 'Cancel',
                                                            confirmMethod : 'claimDeposit',
                                                            confirmParams : {{ $deposit->id }}
                                                        })" />
                                                    @else
                                                        <span> Claimed</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
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
