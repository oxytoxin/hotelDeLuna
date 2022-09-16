<?php


Route::prefix('house-keeping')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
   Route::get('/dashboard',function(){
        return view('house-keeping.dashboard');
    })->name('house-keeping.dashboard');

    Route::get('/designations',function(){
        return view('house-keeping.designations');
    })->name('house-keeping.designations');

    Route::get('/room-boy',function(){
        return view('house-keeping.room-boy');
    })->name('house-keeping.room-boy');

    Route::get('/room-monitoring',function(){
        return view('house-keeping.room-monitoring');
    })->name('house-keeping.room-monitoring');

});