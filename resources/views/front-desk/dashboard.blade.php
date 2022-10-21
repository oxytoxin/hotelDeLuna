@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <x-page-layout title="Dashboard">
            <div class="flex h-screen space-x-2 ">
                <div class="w-full h-full">
                    @livewire('branch-admin.dashboard.statistic-overview')
                </div>
                <div class="w-[45%] px-2 h-full">
                    @livewire('branch-admin.terminated-guest-list')
                </div>
            </div>
        </x-page-layout>
    </x-layout.frontdesk>
@endsection
