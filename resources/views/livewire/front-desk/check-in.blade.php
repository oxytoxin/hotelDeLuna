<div>
    <div class="gap-4 sm:grid sm:grid-cols-12">
        <div wire:key="inqueue-guest-list"
            class="sm:col-span-8">
            @include('front-desk.sub.to-check-in')
        </div>
        <div class=" sm:col-span-4">
            <div wire:key="rooms-termination">
                <div class="grid space-y-2">

                </div>
            </div>
            <div wire:key="recent-check-in">
                @include('front-desk.sub.recent-check-in')
            </div>
        </div>
    </div>
    <div wire:key="modal-panels">
        @include('front-desk.sub.check-in-guest')
    </div>
</div>
