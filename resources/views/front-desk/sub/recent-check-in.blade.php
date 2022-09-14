<div>
    <div>
        <div class="flex flex-col">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td colspan="2"
                                        class="py-4 pl-4 pr-3 text-sm font-medium text-center text-gray-700 whitespace-nowrap sm:pl-6">
                                        <div class="flex items-center justify-center space-x-3">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="w-6 h-6 text-gray-700">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                            </svg>
                                            <span> Recent Check In</span>
                                        </div>
                                    </td>
                                </tr>
                                {{--  --}}
                                @forelse ($recent_check_in_list as $guest)
                                    <tr>
                                        <td
                                            class="py-2 pl-4 pr-3 text-xs font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                            {{ $guest->name }}
                                        </td>
                                        <td class="px-3 py-2 text-xs text-gray-500 whitespace-nowrap">
                                            {{ $guest->qr_code }}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                {{--  --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
