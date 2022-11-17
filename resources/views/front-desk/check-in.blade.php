@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <x-page-layout title="Check In">
            @livewire('v2.front-desk.check-in.index')
        </x-page-layout>
    </x-layout.frontdesk>
@endsection
