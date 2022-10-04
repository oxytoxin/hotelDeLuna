<div class="overflow-hidden bg-white border border-gray-300 shadow sm:rounded-lg ">
    <div class="px-5 py-3 border-b">
        <h1 class="text-lg text-gray-700">Guest Terminated List</h1>
    </div>
    <div class="p-4">
        <ul class="grid space-y-2">
            @forelse ($guests as $guest)
                <li class="flex p-2 space-x-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    <h1>
                        {{ $guest->qr_code }}
                    </h1>
                    <span>|</span>
                    <h1>
                        {{ $guest->name }}
                    </h1>
                </li>
            @empty
            @endforelse
        </ul>
    </div>
</div>
