<?php

use App\Http\Controllers\ReservasController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EnterpriseLoginController;
use App\Http\Controllers\EnterpriseRegisterController;
use App\Http\Controllers\EnterpriseProductController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ReservasController::class, 'index']);
Route::post('/', [ReservasController::class, 'login']);
Route::get('/loggout', [ReservasController::class, 'loggout']);
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/enterprise', [EnterpriseLoginController::class, 'index']);
Route::post('/enterprise', [EnterpriseLoginController::class, 'login']);
Route::get('/registerEnterprise', [EnterpriseRegisterController::class, 'index']);
Route::post('/registerEnterprise', [EnterpriseRegisterController::class, 'register']);
Route::get('/enterprise/registerProduct', [EnterpriseProductController::class, 'index']);
Route::post('/enterprise/registerProduct', [EnterpriseProductController::class, 'register']);
Route::get('/loja/{empresa}', [StoreController::class, 'index']);
Route::get('/loja/{empresa}/{name}', [StoreController::class, 'index']);
Route::post('/loja/{empresa}/{name}', [StoreController::class, 'reserve']);

