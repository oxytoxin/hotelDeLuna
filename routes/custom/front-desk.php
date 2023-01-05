<?php

Route::prefix('frontdesk')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'front_desk',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('front-desk.dashboard');
    })->name('front-desk.dashboard')->middleware('assigned_frontdesk');

    Route::get('/check-in', function () {
        return view('front-desk.check-in');
    })->name('front-desk.check-in')->middleware('assigned_frontdesk');

    Route::get('/check-out', function () {
        return view('front-desk.check-out');
    })->name('front-desk.check-out');

    Route::get('/guest-transaction', function () {
        return view('front-desk.guest-transaction');
    })->name('front-desk.guest-transaction')->middleware('assigned_frontdesk');

    Route::get('/guest-transaction/{guest}/change-room', function ($quest) {
        return view('front-desk.change-room',['guest' => $quest]);
    })->name('front-desk.change-room')->middleware('assigned_frontdesk');

    Route::get('/room-monitoring', function () {
        return view('front-desk.room-monitoring');
    })->name('front-desk.room-monitoring')->middleware('assigned_frontdesk');

    Route::get('/priority-rooms', function () {
        return view('front-desk.priority-room');
    })->name('front-desk.priority-room')->middleware('assigned_frontdesk');

    Route::get('/assign-frontdesk', function () {
        if (auth()->user()->assigned_frontdesks) {
            return redirect()->route('front-desk.dashboard');
        }
        return view('front-desk.assign-frontdesk');
    })->name('front-desk.assign-frontdesk');
});
