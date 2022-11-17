@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <x-page-layout title="Guest Transaction">
            @livewire('v2.front-desk.transactions.index')
        </x-page-layout>
    </x-layout.frontdesk>
@endsection
