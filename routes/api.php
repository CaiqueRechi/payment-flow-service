<?php

use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/payments', [PaymentController::class, 'store']);
Route::patch('/payments/{payment}/status', [PaymentController::class, 'updateStatus']);
Route::get('/payments', [PaymentController::class, 'index']);
Route::get('/payments/{payment}', [PaymentController::class, 'show']);
Route::post('/payments', [PaymentController::class, 'store']);
Route::patch('/payments/{payment}/status', [PaymentController::class, 'updateStatus']);
