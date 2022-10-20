@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout>
            @livewire('front-desk.priority-room')
        </x-page-layout>
    </x-layout.branch>
@endsection
