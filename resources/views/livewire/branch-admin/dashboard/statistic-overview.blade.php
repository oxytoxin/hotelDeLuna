<div>
    <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-2 lg:grid-cols-3">
        <x-stat-card title="Total Check In"
            value="{{ $data['total_check_in_overall_count'] }}">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    class="w-6 h-6 fill-white">
                    <path fill="none"
                        d="M0 0h24v24H0z" />
                    <path
                        d="M9 1v2h6V1h2v2h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2zm11 9H4v9h16v-9zm-4.964 1.136l1.414 1.414-4.95 4.95-3.536-3.536L9.38 12.55l2.121 2.122 3.536-3.536zM7 5H4v3h16V5h-3v1h-2V5H9v1H7V5z" />
                </svg>
            </x-slot:icon>
            <x-slot:actions>
                <a href="#"
                    class="flex items-center space-x-2 font-medium text-indigo-600 hover:text-indigo-500">
                    <span>Generate Reports</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>

                </a>
            </x-slot:actions>
        </x-stat-card>
        <x-stat-card title="Check In Today"
            value="{{ $data['total_check_in_today_count'] }}">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    class="w-6 h-6 fill-white">
                    <path fill="none"
                        d="M0 0h24v24H0z" />
                    <path
                        d="M9 1v2h6V1h2v2h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2zm11 7H4v11h16V8zm-4.964 2.136l1.414 1.414-4.95 4.95-3.536-3.536L9.38 11.55l2.121 2.122 3.536-3.536z" />
                </svg>
            </x-slot:icon>
            <x-slot:actions>
                <a href="#"
                    class="flex items-center space-x-2 font-medium text-indigo-600 hover:text-indigo-500">
                    <span>Generate Reports</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>

                </a>
            </x-slot:actions>
        </x-stat-card>
        <x-stat-card title="Checked Out Today"
            value="{{ $data['total_check_out_today_count'] }}">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    class="w-6 h-6 fill-white">
                    <path fill="none"
                        d="M0 0h24v24H0z" />
                    <path
                        d="M5 22a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3h-2V4H6v16h12v-2h2v3a1 1 0 0 1-1 1H5zm13-6v-3h-7v-2h7V8l5 4-5 4z" />
                </svg>

            </x-slot:icon>
            <x-slot:actions>
                <a href="#"
                    class="flex items-center space-x-2 font-medium text-indigo-600 hover:text-indigo-500">
                    <span>Generate Reports</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </a>
            </x-slot:actions>
        </x-stat-card>
        <x-stat-card title="Expected Check Out Today"
            value="{{ $data['total_expected_check_out_today_count'] }}">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    class="w-6 h-6 fill-white">
                    <path fill="none"
                        d="M0 0h24v24H0z" />
                    <path
                        d="M5 22a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5zm10-6l5-4-5-4v3H9v2h6v3z" />
                </svg>
            </x-slot:icon>
            <x-slot:actions>
                <a href="#"
                    class="flex items-center space-x-2 font-medium text-indigo-600 hover:text-indigo-500">
                    <span>Generate Reports</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>

                </a>
            </x-slot:actions>
        </x-stat-card>
    </dl>
</div>
