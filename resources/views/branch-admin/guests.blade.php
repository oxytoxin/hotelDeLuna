@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <div>
            <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">Guests</h1>
            </div>
            <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                @livewire('branch-admin.guest-list')
            </div>
        </div>
    </x-layout.branch>
@endsection
