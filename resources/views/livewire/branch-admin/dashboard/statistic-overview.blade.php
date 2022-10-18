<div class="grid gap-5">
    <div>
        <h1>
            <span class="text-gray-700 uppercase ">Total Statistic Overview</span>
        </h1>
        <div>
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div class="relative px-4 pt-5 overflow-hidden bg-white rounded-lg shadow ">
                    <dt>
                        <div class="absolute p-3 bg-[#9ED2C6] rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-6 h-6 text-white">
                                <path
                                    d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                <path fill-rule="evenodd"
                                    d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                            Total Check In
                        </p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $data['total_check_in_overall_count'] }}
                        </p>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
    <div>
        <h1>
            <span class="text-gray-700 uppercase ">Today Statistic Overview</span>
        </h1>
        <div>
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-2">

                <div class="relative px-4 pt-5 overflow-hidden bg-white rounded-lg shadow ">
                    <dt>
                        <div class="absolute p-3 bg-[#FFDBA4] rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                class="w-6 h-6 fill-white">
                                <path fill="none"
                                    d="M0 0h24v24H0z" />
                                <path
                                    d="M9 1v2h6V1h2v2h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2zm11 7H4v11h16V8zm-4.964 2.136l1.414 1.414-4.95 4.95-3.536-3.536L9.38 11.55l2.121 2.122 3.536-3.536z" />
                            </svg>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                            Checked In Today
                        </p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $data['total_check_in_today_count'] }}
                        </p>
                    </dd>
                </div>
                <div class="relative px-4 pt-5 overflow-hidden bg-white rounded-lg shadow ">
                    <dt>
                        <div class="absolute p-3 bg-[#FF9494] rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                class="w-6 h-6 fill-white">
                                <path fill="none"
                                    d="M0 0h24v24H0z" />
                                <path
                                    d="M9 1v2h6V1h2v2h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2zm11 7H4v11h16V8zm-4.964 2.136l1.414 1.414-4.95 4.95-3.536-3.536L9.38 11.55l2.121 2.122 3.536-3.536z" />
                            </svg>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                            Checked Out Today
                        </p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $data['total_check_out_today_count'] }}
                        </p>
                    </dd>
                </div>
                <div class="relative px-4 pt-5 overflow-hidden bg-white rounded-lg shadow ">
                    <dt>
                        <div class="absolute p-3 bg-[#967E76] rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                class="w-6 h-6 fill-white">
                                <path fill="none"
                                    d="M0 0h24v24H0z" />
                                <path
                                    d="M9 1v2h6V1h2v2h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2zm11 7H4v11h16V8zm-4.964 2.136l1.414 1.414-4.95 4.95-3.536-3.536L9.38 11.55l2.121 2.122 3.536-3.536z" />
                            </svg>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                            Expected Check Out Today
                        </p>
                    </dt>
                    <dd class="flex items-baseline pb-6 ml-16 sm:pb-7">
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $data['total_expected_check_out_today_count'] }}
                        </p>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
