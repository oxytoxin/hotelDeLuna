@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Manage Rates">
            @livewire('branch-admin.rate-list')
        </x-page-layout>
    </x-layout.branch>
@endsection
