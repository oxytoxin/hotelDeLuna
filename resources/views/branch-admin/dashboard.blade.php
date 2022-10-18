@extends('layouts.master')
@push('headScripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
@endpush
@section('content')
    <x-layout.branch>
        <x-page-layout>
            <div class="flex h-screen space-x-2 ">
                <div class="w-full h-full">
                    @livewire('branch-admin.dashboard.statistic-overview')
                </div>
                <div class="w-[45%] px-2 h-full">
                    @livewire('branch-admin.terminated-guest-list')
                </div>
            </div>
            {{-- <div class="gap-2 mt-5 sm:grid sm:grid-cols-2">
                <div class="sm:col-span-1">
                </div>
            </div> --}}
        </x-page-layout>
    </x-layout.branch>
@endsection
