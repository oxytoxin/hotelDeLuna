@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Manage User">
            @livewire('branch-admin.users')
        </x-page-layout>
    </x-layout.branch>
@endsection
