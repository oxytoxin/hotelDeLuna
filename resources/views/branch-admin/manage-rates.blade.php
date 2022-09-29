@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Manage Rates">
            @livewire('branch-admin.rates')
        </x-page-layout>
    </x-layout.branch>
@endsection
