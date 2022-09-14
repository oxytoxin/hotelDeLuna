<?php

Route::prefix('branch')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard',function(){
        return view('branch-admin.dashboard');
    })->name('branch.dashboard');

    Route::get('/manage-rates',function(){
        return view('branch-admin.manage-rates');
    })->name('branch.manage-rates');

    Route::get('/manage-rooms',function(){
        return view('branch-admin.manage-rooms');
    })->name('branch.manage-rooms');

    Route::get('/monitor-rooms',function(){
        return view('branch-admin.monitor-rooms');
    })->name('branch.monitor-rooms');

});