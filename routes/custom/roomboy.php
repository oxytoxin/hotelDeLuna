<?php

Route::prefix('roomboy')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'room_boy'
])->group(function () {
    Route::get('/home', function () {
        return view('roomboy.home');
    })->name('roomboy.home');
});
