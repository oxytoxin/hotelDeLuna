@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <x-page-layout title="Guest Transaction">
            @livewire('front-desk.guest-transactions')
        </x-page-layout>
    </x-layout.frontdesk>
@endsection
