@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <div>
            <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">Check Out</h1>
            </div>
            <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                <div class="my-5">
                    @livewire('front-desk.check-out')
                </div>
            </div>
        </div>
    </x-layout.frontdesk>
@endsection