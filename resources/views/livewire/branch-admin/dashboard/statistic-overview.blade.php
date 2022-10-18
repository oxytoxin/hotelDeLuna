<div class="grid gap-10">
    <div class="grid gap-5">
        <h1>
            <span class="text-lg font-semibold text-gray-800 uppercase">Today Statistic Overview</span>
        </h1>
        <div>
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-2">
                <x-stat-card title="Checked In Today"
                    value="{{ $data['total_check_in_today_count'] }}">
                    <x-slot:icon>
                        <div class="absolute p-3 bg-[#BCCEF8] rounded-md">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                class="w-6 h-6 fill-white">
                                <path fill="none"
                                    d="M0 0h24v24H0z" />
                                <path
                                    d="M9 1v2h6V1h2v2h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2zm11 7H4v11h16V8zm-4.964 2.136l1.414 1.414-4.95 4.95-3.536-3.536L9.38 11.55l2.121 2.122 3.536-3.536z" />
                            </svg>
                        </div>
                    </x-slot:icon>
                </x-stat-card>
                <x-stat-card title="Checked Out Today"
                    value="{{ $data['total_check_out_today_count'] }}">
                    <x-slot:icon>
                        <div class="absolute p-3 bg-[#F8C4B4] rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                class="w-6 h-6 fill-white">
                                <path fill="none"
                                    d="M0 0h24v24H0z" />
                                <path
                                    d="M9 1v2h6V1h2v2h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2zm11 7H4v11h16V8zm-4.964 2.136l1.414 1.414-4.95 4.95-3.536-3.536L9.38 11.55l2.121 2.122 3.536-3.536z" />
                            </svg>
                        </div>
                    </x-slot:icon>
                </x-stat-card>
                <x-stat-card title="Expected Check Out Today"
                    value="{{ $data['total_expected_check_out_today_count'] }}">
                    <x-slot:icon>
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
                    </x-slot:icon>
                </x-stat-card>
            </dl>
        </div>
    </div>
    <div class="grid gap-5">
        <h1>
            <span class="text-lg font-semibold text-gray-800 uppercase">Total Statistic Overview</span>
        </h1>
        <div>
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-2">
                <x-stat-card title="Total Check In"
                    value=" {{ $data['total_check_in_overall_count'] }}">
                    <x-slot:icon>
                        <div class="absolute p-3 bg-[#9ED2C6] rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                class="w-6 h-6 fill-white">
                                <path fill="none"
                                    d="M0 0h24v24H0z" />
                                <path
                                    d="M9 1v2h6V1h2v2h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2zm11 7H4v11h16V8zm-4.964 2.136l1.414 1.414-4.95 4.95-3.536-3.536L9.38 11.55l2.121 2.122 3.536-3.536z" />
                            </svg>
                        </div>
                    </x-slot:icon>
                </x-stat-card>

            </dl>
        </div>
    </div>
</div>
