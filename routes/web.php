<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LockScreenController;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Mail;

Route::get('/', [HomeController::class, 'index'])->name('home');

//Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/item/{id}', [CartController::class, 'remove'])->name('cart.remove');



//Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');

// Email Verification
Route::get('/email/verify', [AuthController::class, 'verifyEmailPrompt'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmailHandler'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'verifyEmailResend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

//Reset Password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/send-reset-link', [AuthController::class, 'sendResetLink'])->name('sendResetLink');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('passwordReset');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('updatePassword');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    //Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/midtrans-callback', [CheckoutController::class, 'midtransCallback'])->name('midtrans.callback');

    //Order
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    //User Address
    Route::post('/address/store', [UserAddressController::class, 'store'])->name('address.store');

    //Lockscreen
    Route::get('/lock', [LockScreenController::class, 'lock'])->name('lock');
    Route::get('/lock-screen', [LockScreenController::class, 'show'])->name('lock.screen');
    Route::post('/unlock', [LockScreenController::class, 'unlock'])->name('unlock');

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //Store
    Route::get('/store', [StoreController::class, 'index'])->name('store');
    Route::get('/store/insert', [StoreController::class, 'insert'])->name('store.insert');
    Route::post('/store/store', [StoreController::class, 'create'])->name('store.create');
    Route::get('/store/edit/{uuid}', [StoreController::class, 'edit'])->name('store.edit');
    Route::put('/store/update/{uuid}', [StoreController::class, 'update'])->name('store.update');
    Route::put('/store/verify/{uuid}', [StoreController::class, 'verify'])->name('store.verify');

    //Category Product
    Route::get('/category', [CategoryProductController::class, 'index'])->name('category');
    Route::post('/category', [CategoryProductController::class, 'create'])->name('category.create');
    Route::put('/category/{id}', [CategoryProductController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryProductController::class, 'destroy'])->name('category.destroy');

    //Product
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/product/insert', [ProductController::class, 'insert'])->name('product.insert');
    Route::post('/product/insert', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product/edit/{uuid}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/update/{uuid}', [ProductController::class, 'update'])->name('product.update');
    Route::patch('/product/verify/{uuid}', [ProductController::class, 'verify'])->name('product.verify');
    Route::delete('/product/destroy/{uuid}', [ProductController::class, 'destroy'])->name('product.destroy');

    //Users
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::patch('/users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::patch('/users/toggle/{id}', [UsersController::class, 'toggle'])->name('users.toggle');

    //Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}', [ChatController::class, 'store'])->name('chat.store');
});
