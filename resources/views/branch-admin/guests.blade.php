@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Guests">
            @livewire('branch-admin.guest-list')
        </x-page-layout>
    </x-layout.branch>
@endsection
