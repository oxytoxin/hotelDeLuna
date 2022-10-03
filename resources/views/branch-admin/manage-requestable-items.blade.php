@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Manage Requestable Item">
            @livewire('branch-admin.requestable-items')
        </x-page-layout>
    </x-layout.branch>
@endsection
