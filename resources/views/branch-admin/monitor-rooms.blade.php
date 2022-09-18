@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Monitor Rooms">
            @livewire('branch-admin.user-list')
        </x-page-layout>
    </x-layout.branch>
@endsection
