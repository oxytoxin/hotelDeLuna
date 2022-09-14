<div>
    @php
        $headers = ['Qr Code', 'Name', 'Contact Number', 'Check In At', ''];
    @endphp
    <div class="mt-5">
        <div class="flex flex-col">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <div class="flex justify-between px-2 py-3 bg-white border-b border-gray-200 sm:px-6">
                            <div class="flex space-x-2">
                                <x-input icon="search"
                                    placeholder="Search..." />
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
                                @forelse ($guests as $guest)
                                    <tr>
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            {{ $guest->qr_code }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $guest->name }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $guest->contact_number }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $guest->check_in_at }}
                                        </td>
                                        <td
                                            class="relative py-2.5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                            <x-button wire:key="{{ $guest->id }}"
                                                xs
                                                label="View"
                                                x-on:click="$wire.emit('viewGuest',' {{ $guest->id }}');" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            No guest Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="py-2">
                        {{ $guests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
