<?php

use App\Http\Controllers\ReservasController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ReservasController::class, 'index']);
Route::post('/', [ReservasController::class, 'login']);
Route::get('/loggout', [ReservasController::class, 'loggout']);
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'register']);
