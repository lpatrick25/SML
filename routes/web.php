<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemLogController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\TransactionController;
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
    return view('sign-in');
})->name('signIn');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth')->group(function() {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User Component
    Route::get('user-list', [AdminController::class, 'userList'])->name('admin.userList');
    Route::get('user-management', [AdminController::class, 'userManagement'])->name('admin.userManagement');

    // Main Components
    Route::get('customers-management', [AdminController::class, 'customersManagement'])->name('admin.customersManagement');
    Route::get('services-management', [AdminController::class, 'servicesManagement'])->name('admin.servicesManagement');
    Route::get('orders-management', [AdminController::class, 'ordersManagement'])->name('admin.ordersManagement');
    Route::get('item-management', [AdminController::class, 'itemManagement'])->name('admin.itemManagement');

    // Report Components
    Route::get('sales-report', [SalesReportController::class, 'index'])->name('admin.salesReport');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('admin.inventoryReport');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/sales-report', [SalesReportController::class, 'index'])->name('sales-report.index');
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

Route::resource('users', UserController::class)->names([
    'index' => 'users.index',
    'show' => 'users.show',
    'store' => 'users.store',
    'update' => 'users.update',
    'destroy' => 'users.destroy',
]);

Route::put('/users/{user}/changePassword', [UserController::class, 'changePassword'])->name('users.changePassword');
Route::put('/users/{user}/changeStatus', [UserController::class, 'changeStatus'])->name('users.changeStatus');

Route::resource('customers', CustomerController::class)->names([
    'index' => 'customers.index',
    'show' => 'customers.show',
    'store' => 'customers.store',
    'update' => 'customers.update',
    'destroy' => 'customers.destroy',
]);

Route::resource('services', ServiceController::class)->names([
    'index' => 'services.index',
    'show' => 'services.show',
    'store' => 'services.store',
    'update' => 'services.update',
    'destroy' => 'services.destroy',
]);

Route::resource('orders', OrderController::class)->names([
    'index' => 'orders.index',
    'show' => 'orders.show',
    'store' => 'orders.store',
    'update' => 'orders.update',
    'destroy' => 'orders.destroy',
]);

Route::resource('order-items', OrderItemController::class)->names([
    'index' => 'order-items.index',
    'show' => 'order-items.show',
    'store' => 'order-items.store',
    'update' => 'order-items.update',
    'destroy' => 'order-items.destroy',
]);

Route::resource('transactions', TransactionController::class)->names([
    'index' => 'transactions.index',
    'show' => 'transactions.show',
    'store' => 'transactions.store',
    'update' => 'transactions.update',
    'destroy' => 'transactions.destroy',
]);
Route::patch('/transactions/{transaction}/status', [TransactionController::class, 'changeStatus']);

Route::resource('payments', PaymentController::class)->names([
    'index' => 'payments.index',
    'show' => 'payments.show',
    'store' => 'payments.store',
    'update' => 'payments.update',
    'destroy' => 'payments.destroy',
]);

Route::resource('items', ItemController::class)->names([
    'index' => 'items.index',
    'show' => 'items.show',
    'store' => 'items.store',
    'update' => 'items.update',
    'destroy' => 'items.destroy',
]);

Route::resource('item-logs', ItemLogController::class)->names([
    'index' => 'item-logs.index',
    'show' => 'item-logs.show',
    'store' => 'item-logs.store',
    'update' => 'item-logs.update',
    'destroy' => 'item-logs.destroy',
]);
