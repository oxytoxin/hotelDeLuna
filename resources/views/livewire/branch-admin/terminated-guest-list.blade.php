<div class="overflow-hidden bg-white shadow sm:rounded-lg ">

    <div class="p-4">
        <h1 class="text-lg text-center text-gray-500">
            Terminated Check In List
        </h1>
        <ul class="grid space-y-2">
            @forelse ($guests as $guest)
                <li class="flex p-2 space-x-2 text-white bg-red-600 border border-red-300 rounded-lg hover:bg-red-500">
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
