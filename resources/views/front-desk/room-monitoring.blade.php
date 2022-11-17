@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <x-page-layout title="Room Monitoring">
            @livewire('v2.front-desk.rooms-monitoring.index')
        </x-page-layout>
    </x-layout.frontdesk>
@endsection
