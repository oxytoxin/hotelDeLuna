<?php

Route::prefix('frontdesk')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'front_desk',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('front-desk.dashboard');
    })->name('front-desk.dashboard');

    Route::get('/check-in', function () {
        return view('front-desk.check-in');
    })->name('front-desk.check-in');

    Route::get('/check-out', function () {
        return view('front-desk.check-out');
    })->name('front-desk.check-out');

    Route::get('/guest-transaction', function () {
        return view('front-desk.guest-transaction');
    })->name('front-desk.guest-transaction');

    Route::get('/room-monitoring', function () {
        return view('front-desk.room-monitoring');
    })->name('front-desk.room-monitoring');
});
