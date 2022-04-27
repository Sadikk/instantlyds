<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::group(['middleware' => ['auth:sanctum', 'verified'] ], function() {
    Route::redirect('/dashboard', '/')->name('dashboard');
    Route::inertia('/', 'Dashboard')->name('home');

    Route::get('/dropdown', [\App\Http\Controllers\ContactController::class, 'getDropdown']);
    Route::post('/export', [\App\Http\Controllers\ContactController::class, 'export']);
});
Route::impersonate();
