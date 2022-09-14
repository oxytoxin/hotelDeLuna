<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
       $role_id = auth()->user()->role_id;
    switch ($role_id) {
          case  "1":
            return redirect()->route('branch.dashboard');
            break;
          case "2":
            echo "Front Desk";
            break;
          case "4":
            echo "Kitchen";
            break;
          case "5":
            echo "Bell Boy";
            break;
          case "6":
            echo "House Keeping";
            break;
          case "3":
            return redirect()->route('kiosk.transaction');
            break;
         case "7":
            echo "Super Admin";
            break;
          default:
            # code...
            break;
        }
    })->name('dashboard');

    //KIOSK
    Route::prefix('/kiosk')->middleware([
      'auth:sanctum',
      config('jetstream.auth_session'),
      'verified'
  ])->group(function () {
      Route::get('/',function(){
          return view('kiosk.index');
      })->name('kiosk.transaction');
      Route::get('/check-in',function(){
          return view('kiosk.checkin');
      })->name('kiosk.checkin');
      Route::get('/check-out',function(){
          return view('kiosk.checkout');
      })->name('kiosk.checkout');
  
      Route::get('/reports',function(){
          return view('kiosk.reports');
      })->name('kiosk.reports');
  });


});
