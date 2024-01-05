<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizesController;
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


Route::get('/', [UserController::class, 'index'])->name('home');
Route::middleware('check.notAccess')->group(function () {
    Route::get('/cart', [UserController::class, 'cart'])->name('user.cart');
    Route::post('/cart_to_view', [CartController::class, 'cartDataToView'])->name('cart.cartDataToView');
    Route::post('/add_to_cart', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::post('/except_from_cart', [CartController::class, 'exceptFromCart'])->name('cart.exceptFromCart');
    Route::post('/set_to_cart', [CartController::class, 'setToCart'])->name('cart.setToCart');
    Route::post('/check_cart', [CartController::class, 'checkCart'])->name('cart.checkCart');
    Route::post('/remove_by_check_cart', [CartController::class, 'removeByCheckCart'])->name('cart.removeByCheckCart');
    Route::get('/product_detail/{id}', [ProductController::class, 'productDetail'])->name('user.productDetail');
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
        Route::get('/product_detail/{id}', [ProductController::class, 'productDetail'])->name('product.productDetail');
    });
    Route::prefix('/categories')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');
        Route::get('/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::post('/destroy/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    });
    Route::prefix('/colors')->group(function () {
        Route::get('/', [ColorsController::class, 'index'])->name('colors.index');
    });
    Route::prefix('/sizes')->group(function () {
        Route::get('/', [SizesController::class, 'index'])->name('sizes.index');
    });
    Route::prefix('/images')->group(function () {
        Route::get('/', [ImagesController::class, 'index'])->name('images.index');
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

Route::middleware('checkLogoutAccess')->middleware('check.notAccess')->get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::middleware('checkLogoutAccess')->middleware('auth.checkAdmin')->get('/logout_admin', [AuthController::class, 'logoutAdmin'])->name('auth.logoutAdmin');