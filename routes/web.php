<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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


Route::prefix('/')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('home');
    Route::get('/cart', [UserController::class, 'cart'])->name('user.cart');
});

Route::middleware('auth.checkAdmin')->prefix("/admin")->group(function () {
    Route::get("/", [AdminController::class, "index"])->name("admin.index");
    Route::prefix('/products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/', [ProductController::class, 'store'])->name('product.store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/{id}/delete', [ProductController::class, 'destroy'])->name('product.destroy');
    });
    Route::prefix('/ajax')->group(function () {
        Route::post('/delete_many', [AjaxController::class, 'destroyMany'])->name('ajax.destroyMany');
        Route::post('/{id}/update_status', [AjaxController::class, 'updateStatus'])->name('product.updateStatus');
    });
    Route::prefix('/images')->group(function () {
        Route::post('/upload', [ImageController::class, 'upload'])->name('image.upload');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'checkLogin'])->name('auth.checkLogin');
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'checkRegister'])->name('auth.checkRegister');
    Route::get('/forgot_password', [AuthController::class, 'forgotPassword'])->name('auth.forgotPassword');
    Route::post('/forgot_password', [AuthController::class, 'handleForgotPassword'])->name('auth.handleForgotPassword');
    Route::get('/reset_password/{token}', [AuthController::class, 'resetPassword'])->name('auth.resetPassword');
    Route::post('/reset_password/{token}', [AuthController::class, 'handleResetPassword'])->name('auth.handleResetPassword');
});

Route::middleware('checkLogoutAccess')->get('/logout', [AuthController::class, 'logout'])->name('auth.logout');