<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Middleware\VerifyJwtToken;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('api.register');
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('api.login');

Route::middleware([VerifyJwtToken::class])->group(function () {
    Route::post('/verify4code', [App\Http\Controllers\Api\AuthController::class, 'verifyCode']);
    Route::post('/profileUpdate', [App\Http\Controllers\Api\UserController::class, 'update']);
});