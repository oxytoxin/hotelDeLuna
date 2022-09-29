@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Extension Amounts">
            @livewire('branch-admin.extensions')
        </x-page-layout>
    </x-layout.branch>
@endsection
