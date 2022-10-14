<div class="gap-4 sm:grid sm:grid-cols-2">
    @if ($branch_extension_resetting_time != null)
        <div class="grid grid-cols-2 col-span-2 gap-4">
            <div class="col-span-1">
                <x-card title="Extend">
                    <form class="grid grid-cols-1 gap-3">
                        @csrf
                        <x-native-select label="Select Hour"
                            wire:model="form.extension_id">
                            <option value="">Select</option>
                            @foreach ($available_hours_for_extension_with_in_this_branch as $extention)
                                <option value="{{ $extention->id }}">
                                    {{ $extention->hours }} {{ Str::plural('hour', $extention->hours) }}
                                </option>
                            @endforeach
                        </x-native-select>
                        <x-input label="Amount"
                            disabled
                            wire:model="form.amount_to_be_paid" />
                    </form>
                    <x-slot:footer>
                        <div class="flex items-center space-x-3">
                            <x-button label="Clear" />
                            <x-button primary
                                wire:click="save"
                                spinner="save"
                                label="Save" />
                        </div>
                    </x-slot:footer>
                </x-card>
            </div>
            <div class="col-span-1">
                <x-card>
                    <div class="text-sm text-gray-700">
                        <div>
                            Extended hours :
                            <span class="text-red-600">{{ $extension_history->sum('hours') }} hrs</span>
                        </div>
                        <div>
                            Checked in hours : <span class="text-red-600">{{ $check_in_detail->static_hours_stayed }}
                                hrs</span>
                        </div>
                        Total : <span
                            class="text-red-600">{{ $extension_history->sum('hours') + $check_in_detail->static_hours_stayed }}
                            hrs
                        </span>
                    </div>
                </x-card>
            </div>
        </div>
        <div class="col-span-2 ">
            <x-card title="Extend History">
                <div>
                    <div class="flex flex-col ">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">
                                                    Details
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                                    Amount
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                                    Date
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($extension_history as $extension)
                                                <tr>
                                                    <td
                                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                        Extend for {{ $extension->hours }} hrs
                                                    </td>
                                                    <td
                                                        class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                        ₱ {{ $extension->amount }}
                                                    </td>
                                                    <td
                                                        class="py-4 pl-2 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                                        {{ $extension->created_at->format('Y/m/d h:i:s A') }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3"
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
    @else
        <div class="p-4 border border-red-500 rounded-md bg-red-50 sm:col-span-2">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: mini/x-circle -->
                    <svg class="w-5 h-5 text-red-400"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Extension resetting time is not set in your Admin Account
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul role="list"
                            class="pl-5 space-y-1 list-disc">
                            <li>
                                Login to your Admin Account
                            </li>
                            <li>
                                Go to Settings > Extension Resetting Time > click SET
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
