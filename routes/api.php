<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryLogController;
use Illuminate\Support\Facades\Route;

// Route::prefix('api')->group(function () {
//     Route::resource('users', UserController::class);
//     Route::resource('customers', CustomerController::class);
//     Route::resource('services', ServiceController::class);
//     Route::resource('orders', OrderController::class);
//     Route::resource('order-items', OrderItemController::class);
//     Route::resource('payments', PaymentController::class);
//     Route::resource('inventories', InventoryController::class);
//     Route::resource('inventory-logs', InventoryLogController::class);
// });
