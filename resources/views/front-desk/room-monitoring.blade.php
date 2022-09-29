@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <x-page-layout title="Room Monitoring">
            @livewire('front-desk.room-monitoring')
        </x-page-layout>
    </x-layout.frontdesk>
@endsection
