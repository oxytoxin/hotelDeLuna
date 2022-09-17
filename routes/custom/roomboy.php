<?php

Route::prefix('roomboy')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', function () {
        return view('roomboy.home');
    })->name('roomboy.home');
});
