<?php

Route::prefix('branch')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'branch_admin',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('branch-admin.dashboard');
    })->name('branch.dashboard');

    Route::get('/manage-rates', function () {
        return view('branch-admin.manage-rates');
    })->name('branch.manage-rates');

    Route::get('/guests', function () {
        return view('branch-admin.guests');
    })->name('branch.guests');

    Route::get('/manage-rooms', function () {
        return view('branch-admin.manage-rooms');
    })->name('branch.manage-rooms');

    Route::get('/manage-users', function () {
        return view('branch-admin.manage-users');
    })->name('branch.manage-users');

    Route::get('/manage-branch-discounts', function () {
        return view('branch-admin.discounts');
    })->name('branch.discounts');

    Route::get('/extension-amounts', function () {
        return view('branch-admin.extension-amounts');
    })->name('branch.extension-amounts');

    Route::get('/charges-on-stain-and-damages', function () {
        return view('branch-admin.charges-on-stain-and-damages');
    })->name('branch.charges-on-stain-and-damages');

    Route::get('/check-in', function () {
        return view('branch-admin.check-in');
    })->name('branch.check-in');

    Route::get('/check-out', function () {
        return view('branch-admin.check-out');
    })->name('branch.check-out');

    Route::get('/guest-transaction', function () {
        return view('branch-admin.guest-transaction');
    })->name('branch.guest-transaction');

    Route::get('/room-monitoring', function () {
        return view('branch-admin.room-monitoring');
    })->name('branch.room-monitoring');

    Route::get('/room-boy-designations', function () {
        return view('branch-admin.room-boy-designations');
    })->name('branch.room-boy-designations');
});
