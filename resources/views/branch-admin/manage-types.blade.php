@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Manage Type">
            @livewire('branch-admin.types')
        </x-page-layout>
    </x-layout.branch>
@endsection
