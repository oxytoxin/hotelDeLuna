<?php

Route::prefix('branch')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'branch_admin'
])->group(function () {

    Route::get('/dashboard',function(){
        return view('branch-admin.dashboard');
    })->name('branch.dashboard');

    Route::get('/manage-rates',function(){
        return view('branch-admin.manage-rates');
    })->name('branch.manage-rates');

    Route::get('/guests',function(){
        return view('branch-admin.guests');
    })->name('branch.guests');

    Route::get('/manage-rooms',function(){
        return view('branch-admin.manage-rooms');
    })->name('branch.manage-rooms');

    Route::get('/monitor-rooms',function(){
        return view('branch-admin.monitor-rooms');
    })->name('branch.monitor-rooms');
    
    Route::get('/manage-users',function(){
        return view('branch-admin.manage-users');
    })->name('branch.manage-users');

});