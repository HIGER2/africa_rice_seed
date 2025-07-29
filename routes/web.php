<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AppController::class, 'index']);
Route::post('/orders', [AppController::class, 'store']);
Route::get('/email', [AppController::class, 'email']);

