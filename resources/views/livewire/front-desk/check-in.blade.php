<div>
    <div class="gap-4 sm:grid sm:grid-cols-12">
        <div wire:key="inqueue-guest-list"
            class="sm:col-span-8">
            @include('front-desk.sub.to-check-in')
        </div>
        <div wire:key="recent-check-in"
            class=" sm:col-span-4">
            @include('front-desk.sub.recent-check-in')
        </div>
    </div>
    <div wire:key="modal-panels">
        @include('front-desk.sub.check-in-guest')
    </div>
</div>
