@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Room Boy Designations">
            @livewire('branch-admin.room-boy-designations')
        </x-page-layout>
    </x-layout.branch>
@endsection
