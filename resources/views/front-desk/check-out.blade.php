@extends('layouts.master')
@section('content')
    <x-layout.frontdesk>
        <x-page-layout title="Check Out">
            @livewire('v2.front-desk.check-out.index')
        </x-page-layout>
    </x-layout.frontdesk>
@endsection
