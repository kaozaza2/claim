<?php

use App\Http\Livewire\Admin;
use App\Http\Livewire\User;
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
Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', User\Dashboard::class)->name('dashboard');

    Route::middleware('admin')->group(function () {
        Route::get('admin', function () {
            return redirect()->route('admin.claims');
        })->name('admin');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('requests', Admin\UserRequest::class)->name('requests');
            Route::get('statistics', Admin\Statistics::class)->name('statistics');
            Route::get('claims', Admin\Claims::class)->name('claims');
            Route::get('equipments', Admin\Equipments::class)->name('equipments');
            Route::get('departments', Admin\Departments::class)->name('departments');
            Route::get('accounts', Admin\Accounts::class)->name('accounts');
            Route::get('archives', Admin\Archives::class)->name('archives');
        });
    });
});

Route::fallback(function () {
    return redirect()->route('dashboard');
});
