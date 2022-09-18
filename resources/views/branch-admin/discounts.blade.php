@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Manage Discounts">
            @livewire('branch-admin.discount-list')
        </x-page-layout>
    </x-layout.branch>
@endsection
