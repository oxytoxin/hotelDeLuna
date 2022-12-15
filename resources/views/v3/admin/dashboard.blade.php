<x-hotel.admin-layout title="Dashboard">
    <div class="flex h-screen space-x-2">
        <div class="w-full h-full">
            @livewire('branch-admin.dashboard.statistic-overview')
        </div>
        <div class="h-full w-[45%] px-2">
            @livewire('branch-admin.terminated-guest-list')
        </div>
    </div>
</x-hotel.admin-layout>
