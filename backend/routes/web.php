<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/userStatisticsCard', [App\Http\Controllers\HomeController::class, 'userStatisticsCard'])->name('userStatisticsCard');
Route::get('/userStatisticsChart', [App\Http\Controllers\HomeController::class, 'userStatisticsChart'])->name('userStatisticsChart');

Route::resource('users', App\Http\Controllers\UserController::class)->middleware(['auth']);

Route::resource('notices', App\Http\Controllers\NoticeController::class)->middleware(['auth']);

Route::resource('posts', App\Http\Controllers\NoticeController::class)->middleware(['auth']);

Route::resource('categories', App\Http\Controllers\NoticeController::class)->middleware(['auth']);