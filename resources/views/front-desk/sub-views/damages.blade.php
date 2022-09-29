<div>
    <div>
        <div class="flex flex-col p-2">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-10 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6">
                                        Item
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                        Initial Amount
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                        occured_at
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
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
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $damage->hotel_item->price }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $damage->occured_at }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr colspan="4">
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            No Damages
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
