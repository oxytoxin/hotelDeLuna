@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Manage Rooms">
            @livewire('branch-admin.rooms')
        </x-page-layout>
    </x-layout.branch>
@endsection
