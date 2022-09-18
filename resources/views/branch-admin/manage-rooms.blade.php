@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Manage Rooms">
            @livewire('branch-admin.room-list')
        </x-page-layout>
    </x-layout.branch>
@endsection
