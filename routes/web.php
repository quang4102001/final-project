<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/add_to_cart', [CartController::class, 'addToCart'])->name('cart.addToCart');
Route::post('/except_from_cart', [CartController::class, 'exceptFromCart'])->name('cart.exceptFromCart');
Route::post('/remove_from_cart', [CartController::class, 'removeFromCart'])->name('cart.removeFromCart');
Route::post('/merge_cart_database', [CartController::class, 'mergeCartWithDatabase'])->name('cart.mergeCartWithDatabase');
Route::post('/set_to_cart', [CartController::class, 'setToCart'])->name('cart.setToCart');
Route::post('/check_session_cart', [CartController::class, 'checkSessionCart'])->name('cart.checkSessionCart');
Route::post('/check_database_cart', [CartController::class, 'checkDatabaseCart'])->name('cart.checkDatabaseCart');
Route::get('/cart', [HomeController::class, 'cart'])->name('user.cart');

Route::middleware('check.notAdmin')->get('/product_detail/{id}', [ProductController::class, 'productDetail'])->name('user.productDetail');

Route::middleware('auth.checkAdmin')->prefix("/admin")->group(function () {
    Route::get("/", [AdminController::class, "index"])->name("admin.index");
    Route::post('/delete_multiple_products', [AjaxController::class, 'destroyManyProducts'])->name('product.destroyManyProducts');
    Route::post('/delete_multiple_categories', [AjaxController::class, 'destroyManyCategories'])->name('categories.destroyManyCategories');
    Route::post('/delete_multiple_colors', [AjaxController::class, 'destroyManyColors'])->name('colors.destroyManyColors');
    Route::post('/delete_multiple_sizes', [AjaxController::class, 'destroyManySizes'])->name('sizes.destroyManySizes');
    Route::post('/delete_multiple_images', [AjaxController::class, 'destroyManyImages'])->name('images.destroyManyImages');
    Route::prefix('/products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/', [ProductController::class, 'store'])->name('product.store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/{id}/delete', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::get('/product_detail/{id}', [ProductController::class, 'productDetail'])->name('product.productDetail');
        Route::post('/{id}/update_status', [ProductController::class, 'updateStatus'])->name('product.updateStatus');
    });
    Route::prefix('/categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::post('/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
    Route::prefix('/colors')->group(function () {
        Route::get('/', [ColorController::class, 'index'])->name('colors.index');
        Route::post('/store', [ColorController::class, 'store'])->name('colors.store');
        Route::post('/update/{id}', [ColorController::class, 'update'])->name('colors.update');
        Route::post('/destroy/{id}', [ColorController::class, 'destroy'])->name('colors.destroy');
    });
    Route::prefix('/sizes')->group(function () {
        Route::get('/', [SizeController::class, 'index'])->name('sizes.index');
        Route::post('/store', [SizeController::class, 'store'])->name('sizes.store');
        Route::post('/update/{id}', [SizeController::class, 'update'])->name('sizes.update');
        Route::post('/destroy/{id}', [SizeController::class, 'destroy'])->name('sizes.destroy');
    });
    Route::prefix('/images')->group(function () {
        Route::get('/', [ImageController::class, 'index'])->name('images.index');
        Route::post('/upload', [ImageController::class, 'upload'])->name('images.upload');
        Route::post('/destroy/{id}', [ImageController::class, 'destroy'])->name('images.destroy');
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

Route::middleware('checkLogoutAccess')->group(function () {
    Route::get('/change_password', [AuthController::class, 'changePassword'])->name('auth.changePassword');
    Route::post('/change_password', [AuthController::class, 'handleChangePassword'])->name('auth.handleChangePassword');
    Route::middleware('check.notAdmin')->get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::middleware('auth.checkAdmin')->get('/logout_admin', [AuthController::class, 'logoutAdmin'])->name('auth.logoutAdmin');
});