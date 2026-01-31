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
use App\Http\Controllers\AdminReturnController;
use App\Http\Controllers\SellerReturnController;
use Illuminate\Support\Facades\Mail;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

//Products
Route::get('/products', [HomeController::class, 'allProducts'])->name('products.all');
Route::get('/products/category/{slug}', [HomeController::class, 'productsByCategory'])->name('products.category');
Route::get('/product/{uuid}', [HomeController::class, 'productDetail'])->name('product.detail');

//Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/item/{id}', [CartController::class, 'remove'])->name('cart.remove');



//Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->name('register');

//Reset Password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/send-reset-link', [AuthController::class, 'sendResetLink'])->name('sendResetLink');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('passwordReset');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('updatePassword');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    //Checkout (moved to general route for buyer)
    // Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    // Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/midtrans-callback', [CheckoutController::class, 'midtransCallback'])->name('midtrans.callback');

    //Order
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    //User Address
    Route::post('/address/store', [UserAddressController::class, 'store'])->name('address.store');
    Route::patch('/address/set-default/{uuid}', [UserAddressController::class, 'setDefault'])->name('address.setDefault');
    Route::delete('/address/delete/{uuid}', [UserAddressController::class, 'delete'])->name('address.delete');

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

    //Buyer Profile Pages
    Route::get('/my-orders', [ProfileController::class, 'myOrders'])->name('my.orders');
    Route::get('/my-address', [ProfileController::class, 'myAddress'])->name('my.address');
    Route::get('/order/{uuid}', [ProfileController::class, 'orderDetail'])->name('orders.detail');
    Route::get('/order/{uuid}/payment', [ProfileController::class, 'orderPayment'])->name('orders.payment');
    Route::patch('/order/{uuid}/cod', [ProfileController::class, 'orderCod'])->name('orders.cod');
    Route::patch('/order/{uuid}/simulate-pay', [ProfileController::class, 'simulatePay'])->name('orders.simulatePay');
    Route::patch('/order/{uuid}/cancel', [ProfileController::class, 'orderCancel'])->name('orders.cancel');
    Route::patch('/order/{uuid}/complete', [ProfileController::class, 'orderComplete'])->name('orders.complete');
    Route::post('/order/{uuid}/return', [ProfileController::class, 'orderReturn'])->name('orders.return');
    Route::get('/my-returns', [ProfileController::class, 'myReturns'])->name('my.returns');

    //Admin Return Management - Admin only monitors and processes refund
    Route::get('/returns', [AdminReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/{uuid}', [AdminReturnController::class, 'show'])->name('returns.show');
    Route::post('/returns/{uuid}/process-refund', [AdminReturnController::class, 'processRefund'])->name('returns.process-refund');
    Route::post('/returns/{uuid}/cancel-refund', [AdminReturnController::class, 'cancelRefund'])->name('returns.cancel-refund');

    // Buyer Return Routes - Submit shipment tracking
    Route::post('/returns/{uuid}/submit-shipment', [ProfileController::class, 'submitReturnShipment'])->name('returns.submit-shipment');
});

// Seller Routes
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Store Management
    Route::get('/store', [StoreController::class, 'index'])->name('store');
    Route::get('/store/insert', [StoreController::class, 'insert'])->name('store.insert');
    Route::post('/store/store', [StoreController::class, 'create'])->name('store.create');
    Route::get('/store/edit/{uuid}', [StoreController::class, 'edit'])->name('store.edit');
    Route::put('/store/update/{uuid}', [StoreController::class, 'update'])->name('store.update');

    // Category - View Only for Seller
    Route::get('/category', [CategoryProductController::class, 'index'])->name('category');

    // Product Management
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/product/insert', [ProductController::class, 'insert'])->name('product.insert');
    Route::post('/product/insert', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product/edit/{uuid}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/update/{uuid}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/destroy/{uuid}', [ProductController::class, 'destroy'])->name('product.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Lockscreen
    Route::get('/lock', [LockScreenController::class, 'lock'])->name('lock');
    Route::get('/lock-screen', [LockScreenController::class, 'show'])->name('lock.screen');
    Route::post('/unlock', [LockScreenController::class, 'unlock'])->name('unlock');

    // Return Management
    Route::get('/returns', [SellerReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/{uuid}', [SellerReturnController::class, 'show'])->name('returns.show');
    Route::post('/returns/{uuid}/approve', [SellerReturnController::class, 'approve'])->name('returns.approve');
    Route::post('/returns/{uuid}/reject', [SellerReturnController::class, 'reject'])->name('returns.reject');
    Route::post('/returns/{uuid}/mark-received', [SellerReturnController::class, 'markReceived'])->name('returns.mark-received');
});

// Checkout Routes (for all authenticated users - buyer)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Buyer Routes
Route::middleware(['auth'])->prefix('buyer')->name('buyer.')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Orders & Returns
    Route::get('/my-orders', [ProfileController::class, 'myOrders'])->name('my.orders');
    Route::get('/my-address', [ProfileController::class, 'myAddress'])->name('my.address');
    Route::get('/order/{uuid}', [ProfileController::class, 'orderDetail'])->name('orders.detail');
    Route::get('/order/{uuid}/payment', [ProfileController::class, 'orderPayment'])->name('orders.payment');
    Route::patch('/order/{uuid}/cod', [ProfileController::class, 'orderCod'])->name('orders.cod');
    Route::patch('/order/{uuid}/simulate-pay', [ProfileController::class, 'simulatePay'])->name('orders.simulatePay');
    Route::patch('/order/{uuid}/cancel', [ProfileController::class, 'orderCancel'])->name('orders.cancel');
    Route::patch('/order/{uuid}/complete', [ProfileController::class, 'orderComplete'])->name('orders.complete');
    Route::post('/order/{uuid}/return', [ProfileController::class, 'orderReturn'])->name('orders.return');
    Route::get('/my-returns', [ProfileController::class, 'myReturns'])->name('my.returns');

    // Return Shipment
    Route::post('/returns/{uuid}/submit-shipment', [ProfileController::class, 'submitReturnShipment'])->name('returns.submit-shipment');

    // User Address
    Route::post('/address/store', [UserAddressController::class, 'store'])->name('address.store');
    Route::patch('/address/set-default/{uuid}', [UserAddressController::class, 'setDefault'])->name('address.setDefault');
    Route::delete('/address/delete/{uuid}', [UserAddressController::class, 'delete'])->name('address.delete');
});
