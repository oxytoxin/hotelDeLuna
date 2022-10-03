@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="CHARGES ON STAIN/DAMAGES">
            @livewire('branch-admin.stain-and-damages')
        </x-page-layout>
    </x-layout.branch>
@endsection
