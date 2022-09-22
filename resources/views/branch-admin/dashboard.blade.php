@extends('layouts.master')
@push('headScripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
@endpush
@section('content')
    <x-layout.branch>
        <x-page-layout title="Dashboard">
            <div>
                @livewire('branch-admin.dashboard.statistic-overview')
            </div>
            <div>

            </div>
        </x-page-layout>
    </x-layout.branch>
@endsection
