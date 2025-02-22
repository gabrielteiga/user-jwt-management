<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::middleware('jwt.auth')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    
    Route::patch('/user', [UserController::class, 'edit']);

    Route::delete('/user', [UserController::class, 'delete']);

    Route::post('/user/address', [UserController::class, 'addAddress']);
});

Route::post('/user', [UserController::class, 'create']);

Route::post('/auth', [AuthController::class, 'login']);