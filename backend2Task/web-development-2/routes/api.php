<?php

use App\Http\Controllers\clientController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\driverController;
use App\Http\Controllers\productController;
use App\Http\Controllers\orderController;






Route::post('/register',[userController::class,'register']);


Route::post('/login',[userController::class,'login']);



Route::get('/GetDriverDetails/{id}',[driverController::class,'GetDriverDetails'])->middleware('auth:sanctum');

Route::get('/AllMyOrders', [orderController::class, 'getUserOrders'])->middleware('auth:sanctum');

Route::get('/AllDrivers', [driverController::class, 'getAllDrivers'])->middleware('auth:sanctum');

Route::post('/request-delivery', [orderController::class, 'requestDelivery'])->middleware('auth:sanctum');

Route::post('/orders', [orderController::class, 'createOrderWithProducts'])->middleware('auth:sanctum');
Route::post('/reviews', [clientController::class, 'createReview'])->middleware('auth:sanctum');
Route::get('/drivers/{id}', [driverController::class, 'getReviews'])->middleware('auth:sanctum');
Route::get('/DriverInbox', [driverController::class, 'getMyInbox'])->middleware('auth:sanctum');



Route::post('/create-checkout-session', [paymentController::class, 'createCheckoutSession'])->middleware('auth:sanctum');

Route::post('/orders/mark-paid/{id}', [paymentController::class, 'markAsPaidById']);
Route::post('/CryptoPayment', [paymentController::class, 'createCharge'])->middleware('auth:sanctum');

Route::post('/create-coinbase-charge', [paymentController::class, 'makePayment'])->middleware('auth:sanctum');

Route::get('/payment', [paymentController::class, 'showPaymentPage'])->middleware('auth:sanctum');

// routes/web.php
Route::post('/currency/convert', [CurrencyController::class, 'convertCurrency']);

