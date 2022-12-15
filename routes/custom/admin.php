<?php

Route::prefix('admin')->middleware(['auth','branch_admin'])->group(function(){

  Route::get('/dashboard', function(){
    return view('v3.admin.dashboard');
  })->name('v3-admin.dashboard');

  Route::get('/guests', function(){
    return view('v3.admin.guests');
  })->name('v3-admin.guests');

  Route::get('/types', function(){
    return view('v3.admin.types');
  })->name('v3-admin.types');

  Route::get('/rates', function(){
    return view('v3.admin.rates');
  })->name('v3-admin.rates');

  Route::get('/floors', function(){
    return view('v3.admin.floors');
  })->name('v3-admin.floors');

  Route::get('/rooms', function(){
    return view('v3.admin.rooms');
  })->name('v3-admin.rooms');

  Route::get('/users', function(){
    return view('v3.admin.users');
  })->name('v3-admin.users');

  Route::get('/discounts', function(){
    return view('v3.admin.discounts');
  })->name('v3-admin.discounts');

  Route::get('/discounts', function(){
    return view('v3.admin.discounts');
  })->name('v3-admin.discounts');

  Route::get('/extension-rates', function(){
    return view('v3.admin.extension-rates');
  })->name('v3-admin.extension-rates');

  Route::get('/charges-for-damages', function(){
    return view('v3.admin.charges-for-damages');
  })->name('v3-admin.charges-for-damages');

  Route::get('/amenities', function(){
    return view('v3.admin.amenities');
  })->name('v3-admin.amenities');


  Route::get('/check-in', function(){
    return view('v3.admin.check-in');
  })->name('v3-admin.check-in');

  Route::get('/check-out', function(){
    return view('v3.admin.check-out');
  })->name('v3-admin.check-out');

  Route::get('/transactions', function(){
    return view('v3.admin.transactions');
  })->name('v3-admin.transactions');

  Route::get('/room-monitoring', function(){
    return view('v3.admin.room-monitoring');
  })->name('v3-admin.room-monitoring');

  Route::get('/priority-rooms', function(){
    return view('v3.admin.priority-rooms');
  })->name('v3-admin.priority-rooms');

});