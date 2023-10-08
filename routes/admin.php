<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginAdimn;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->name('loadimns.')->group(function () {


    Route::middleware('isAdmin')->group(function () {

        // display admin pages
        Route::view('loadmins/login', 'loadmins.login');
        Route::view('loadmins/dashboard','loadimns.dashboard');

    });
    require __DIR__ . '/admin_auth.php';

});