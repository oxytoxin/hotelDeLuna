<?php

Route::prefix('branch-admin')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'branch_admin',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('v2.branch-admin.dashboard');
    })->name('re-branch-admin.dashboard');
    
    Route::get('/guests', function () {
        return view('v2.branch-admin.guests');
    })->name('re-branch-admin.guests');

    // -------------------------------

    Route::get('/types', function () {
        return view('v2.branch-admin.types');
    })->name('re-branch-admin.types');

    Route::get('/rates', function () {
        return view('v2.branch-admin.rates');
    })->name('re-branch-admin.rates');

    Route::get('/rooms', function () {
        return view('v2.branch-admin.rooms');
    })->name('re-branch-admin.rooms');

    Route::get('/floors', function () {
        return view('v2.branch-admin.floors');
    })->name('re-branch-admin.floors');

    Route::get('/users', function () {
        return view('v2.branch-admin.users');
    })->name('re-branch-admin.users');

    Route::get('/discounts', function () {
        return view('v2.branch-admin.discounts');
    })->name('re-branch-admin.discounts');

    Route::get('/extensions-rates', function () {
        return view('v2.branch-admin.extensions');
    })->name('re-branch-admin.extensions');

    Route::get('/charges-for-damages', function () {
        return view('v2.branch-admin.charges-for-damages');
    })->name('re-branch-admin.charges-for-damages');

    Route::get('/amenities', function () {
        return view('v2.branch-admin.amenities');
    })->name('re-branch-admin.amenities');


    // --- guest actions

    Route::get('/check-in', function () {
        return view('v2.branch-admin.check-in');
    })->name('re-branch-admin.check-in');

    Route::get('/check-out', function () {
        return view('v2.branch-admin.check-out');
    })->name('re-branch-admin.check-out');

    Route::get('/transactions', function () {
        return view('v2.branch-admin.transactions');
    })->name('re-branch-admin.transactions');

    Route::get('/rooms-monitoring', function () {
        return view('v2.branch-admin.rooms-monitoring');
    })->name('re-branch-admin.rooms-monitoring');

    Route::get('/priority-rooms', function () {
        return view('v2.branch-admin.priority-rooms');
    })->name('re-branch-admin.priority-rooms');
});
