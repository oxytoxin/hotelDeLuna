@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <x-page-layout title="Dashboard">
            @livewire('front-desk.check-out')
        </x-page-layout>
    </x-layout.frontdesk>
@endsection
