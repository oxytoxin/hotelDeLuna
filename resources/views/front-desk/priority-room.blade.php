@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <x-page-layout title="Manage Priority Room">
            @livewire('front-desk.priority-room')
        </x-page-layout>
    </x-layout.frontdesk>
@endsection
