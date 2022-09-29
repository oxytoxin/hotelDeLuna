<div>
    <div>
        <div class="flex flex-col p-2 ">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-10 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">
                                        Transaction Type
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                        Amount
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                        Paid At
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            {{ $transaction->transaction_type->name }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $transaction->payable_amount }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            @if ($transaction->paid_at)
                                                {{ $transaction->paid_at }}
                                            @else
                                                <button type="button"
                                                    class="text-green-600 hover:text-green-900">
                                                    <span> Pay </span>
                                                </button>
                                            @endif
                                        </td>
                                        <td
                                            class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                            <div class="flex justify-end">
                                                <button
                                                    class="flex items-center space-x-1 text-gray-600 hover:text-gray-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                                    </svg>

                                                    <span> Details</span>
                                                </button>
                                            </div>
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

</div>
