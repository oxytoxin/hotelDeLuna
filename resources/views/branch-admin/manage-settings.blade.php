@extends('layouts.master')

@section('content')
    <x-layout.branch>
        <x-page-layout title="Manage Branch Setting">
            <div class="grid gap-3">
                <x-card shadow="shadow"
                    cardClasses="border-gray-400">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            {{ auth()->user()->branch_name }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Settings and cofingurations for this branch.
                        </p>
                    </div>
                    <div class="mt-5 border-t border-gray-200">
                        <dl class="divide-y divide-gray-200">
                            @livewire('branch-admin.setting.extension-capping')
                        </dl>
                    </div>
                </x-card>
            </div>
        </x-page-layout>
    </x-layout.branch>
@endsection
