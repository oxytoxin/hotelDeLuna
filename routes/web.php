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
Route::get('/gg', function () {
    return view('sample');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $role_id = auth()->user()->role_id;
        switch ($role_id) {
            case '1':
                return redirect()->route('re-branch-admin.dashboard');
                break;
            case '2':
                return redirect()->route('front-desk.dashboard');
                break;
            case '4':
                return redirect()->route('kitchen.dashboard');
                break;
            case '5':
                return redirect()->route('roomboy.home');
                break;
            // case '6':
            //     return redirect()->route('house-keeping.dashboard');
            //     break;
            case '3':
                return redirect()->route('kiosk.transaction');
                break;
            case '6':
                return redirect()->route('superadmin.dashboard');
                break;
            case '7':
                return redirect()->route('office.dashboard');
                break;
            default:
                // code...
                break;
        }
    })->name('dashboard');

    //KIOSK
    Route::prefix('/kiosk')
        ->middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified',
            'kiosk',
        ])
        ->group(function () {
            Route::get('/', function () {
                return view('kiosk.index');
            })->name('kiosk.transaction');
            Route::get('/check-in', function () {
                return view('kiosk.checkin');
            })->name('kiosk.checkin');
            Route::get('/check-out', function () {
                return view('kiosk.checkout');
            })->name('kiosk.checkout');

            Route::get('/reports', function () {
                return view('kiosk.reports');
            })->name('kiosk.reports');
        });

    //KITCHEN
    Route::prefix('/kitchen')
        ->middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified',
            'kitchen',
        ])
        ->group(function () {
            Route::get('/', function () {
                return view('kitchen.dashboard');
            })->name('kitchen.dashboard');
            Route::get('/orders', function () {
                return view('kitchen.order');
            })->name('kitchen.order');

            Route::get('/menu', function () {
                return view('kitchen.menu');
            })->name('kitchen.menu');
            Route::get('/menu/{id}', function () {
                return view('kitchen.manage-menu');
            })->name('kitchen.manage-menu');
            Route::get('/settings', function () {
                return view('kitchen.settings');
            })->name('kitchen.settings');
        });

    //SUPERADMIN
    Route::prefix('/superadmin')
        ->middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified',
            'super_admin',
        ])
        ->group(function () {
            Route::get('/', function () {
                return view('superadmin.dashboard');
            })->name('superadmin.dashboard');
            Route::get('/branch', function () {
                return view('superadmin.branch');
            })->name('superadmin.branch');
            Route::get('/branch/{id}', function () {
                return view('superadmin.manage-branch');
            })->name('superadmin.manage-branch');
            Route::get('/settings', function () {
                return view('superadmin.settings');
            })->name('superadmin.settings');
        });

    //BACKOFFICE
    Route::prefix('/back-office')
        ->middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified',
            'back_office',
        ])
        ->group(function () {
            Route::get('/', function () {
                return view('back-office.dashboard');
            })->name('office.dashboard');
            Route::get('/sales', function () {
                return view('back-office.sales');
            })->name('office.sales');
            Route::get('/expenses', function () {
                return view('back-office.expenses');
            })->name('office.expenses');
            Route::get('/reports', function () {
                return view('back-office.report');
            })->name('office.report');
            Route::get('/reports/occupied-rooms', function () {
                return view('back-office.report.occupied-rooms');
            })->name('office.occupied-rooms');
            Route::get('/reports/guests', function () {
                return view('back-office.report.guest');
            })->name('office.guest');
            Route::get('/reports/overdue-rooms', function () {
                return view('back-office.report.overdue');
            })->name('office.overdue');
            Route::get('/reports/roomboy', function () {
                return view('back-office.report.roomboy');
            })->name('office.roomboy');
            Route::get('/reports/time-interval', function () {
                return view('back-office.report.time-interval');
            })->name('office.time-interval');
            Route::get('/reports/number-of-stay', function () {
                return view('back-office.report.stay');
            })->name('office.stay');
            Route::get('/reports/transfer', function () {
                return view('back-office.report.transfer');
            })->name('office.transfer');
            Route::get('/reports/extend', function () {
                return view('back-office.report.extend');
            })->name('office.extend');
        });
});
