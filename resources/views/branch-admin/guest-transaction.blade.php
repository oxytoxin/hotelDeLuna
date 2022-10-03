@extends('layouts.master')
@section('content')
    <x-layout.branch>
        <x-page-layout title="Guest Transaction">
            @livewire('front-desk.guest-transactions')
        </x-page-layout>
    </x-layout.branch>
@endsection
