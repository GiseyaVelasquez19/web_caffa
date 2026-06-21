<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public catalog
Route::get('/catalogo', [ProductController::class, 'catalog'])->name('products.catalog');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin resources
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('modules', ModuleController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    Route::get('/roles/{role}/permissions', [PermissionController::class, 'assignToRole'])->name('permissions.assign');
    Route::put('/roles/{role}/permissions', [PermissionController::class, 'syncRolePermissions'])->name('permissions.sync');
    Route::get('/modules/{module}/permissions', [ModuleController::class, 'managePermissions'])->name('modules.permissions');

    // Cart
    Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
    Route::put('/carrito/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/carrito/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/carrito', [CartController::class, 'clear'])->name('cart.clear');

    // Client orders
    Route::post('/pedidos/crear', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/mis-pedidos', [OrderController::class, 'myOrders'])->name('orders.my');
    Route::get('/mis-pedidos/{order}', [OrderController::class, 'showMyOrder'])->name('orders.show.my');
});

// Vendedor + Admin orders
Route::middleware(['auth'])->prefix('pedidos')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::post('/{order}/procesar', [OrderController::class, 'process'])->name('process');
    Route::put('/{order}/estado', [OrderController::class, 'updateStatus'])->name('updateStatus');
});
