<div class="flex flex-col ">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <div class="flex justify-between px-2 py-3 bg-white border-b border-gray-200 sm:px-6">
                    <div class="flex items-center space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                        <h1 class="text-xl">Damage Charges</h1>
                    </div>
                    <div wire:key="addButton">
                        @if ($loadTransactions == true)
                            <x-button label="Add"
                                wire:click="$set('addDamageModal',true)" />
                        @endif
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="divide-y divide-gray-200 bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                Item
                            </th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Amount
                            </th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Occured At
                            </th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Room
                            </th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Paid At
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($guest_damages as $guest_damage)
                            <tr>
                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                    {{ $guest_damage->item }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    &#8369; {{ $guest_damage->payable_amount }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $guest_damage->occured_at }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    Room # {{ $guest_damage->room->number }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    @if ($guest_damage->paid_at)
                                        {{ $guest_damage->paid_at }}
                                    @else
                                        <button type="button"
                                            wire:click="payDamage({{ $guest_damage->id }})"
                                            class="flex items-center space-x-2 font-medium text-green-600 hover:text-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                            </svg>
                                            <span> Pay</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="py-4 pl-4 pr-3 text-sm font-medium text-center text-gray-900 whitespace-nowrap sm:pl-6">
                                    No Damages Found
                                </td>
                            </tr>
                        @endforelse
                        @if ($loadTransactions == true)
                            <tr>
                                <td class="py-4 pl-4 pr-3 text-sm font-bold text-gray-900 whitespace-nowrap sm:pl-6">
                                </td>
                                <td class="px-3 py-4 text-sm font-bold text-gray-900 whitespace-nowrap">
                                    Total : &#8369; {{ $guest_damages->sum('payable_amount') }}
                                </td>
                                <td class="py-4 pl-4 pr-3 text-sm font-bold text-gray-900 whitespace-nowrap sm:pl-6">
                                </td>
                                <td class="px-3 py-4 text-sm font-bold text-gray-900 whitespace-nowrap">
                                    Balance : &#8369;
                                    {{ $guest_damages->where('paid_at', null)->sum('payable_amount') }}
                                </td>
                                <td class="py-4 pl-4 pr-3 text-sm font-bold text-gray-900 whitespace-nowrap sm:pl-6">
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
