@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <x-page-layout title="Check In">
            @livewire('front-desk.check-in')
        </x-page-layout>
    </x-layout.frontdesk>
@endsection
