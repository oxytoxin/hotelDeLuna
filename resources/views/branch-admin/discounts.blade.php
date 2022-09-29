@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Manage Discounts">
            @livewire('branch-admin.discounts')
        </x-page-layout>
    </x-layout.branch>
@endsection
