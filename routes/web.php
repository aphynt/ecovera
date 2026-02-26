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
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminReturnController;
use App\Http\Controllers\SellerReturnController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminComplaintController;
use Illuminate\Support\Facades\Mail;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

//Products
Route::get('/products', [HomeController::class, 'allProducts'])->name('products.all');
Route::get('/products/category/{slug}', [HomeController::class, 'productsByCategory'])->name('products.category');
Route::get('/product/{uuid}', [HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/about', [HomeController::class, 'about'])->name('about');

//Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/item/{id}/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
Route::delete('/cart/item/{id}', [CartController::class, 'remove'])->name('cart.remove');



//Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
Route::get('/email-sent', [AuthController::class, 'emailSent'])->name('email.sent');
Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])->name('verification.send');

//Email Verification
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');

//Reset Password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/send-reset-link', [AuthController::class, 'sendResetLink'])->name('sendResetLink');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('passwordReset');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('updatePassword');
Route::post('/checkout/midtrans-callback', [CheckoutController::class, 'midtransCallback'])->name('midtrans.callback');

// Complaint
Route::get('/complaint', [ComplaintController::class, 'index'])->name('complaint.index');
Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    //Checkout (moved to general route for buyer)
    // Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    // Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    //Order
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');


    //Lockscreen
    Route::get('/lock', [LockScreenController::class, 'lock'])->name('lock');
    Route::get('/lock-screen', [LockScreenController::class, 'show'])->name('lock.screen');
    Route::post('/unlock', [LockScreenController::class, 'unlock'])->name('unlock');

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


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


    //Admin Return Management - Admin only monitors and processes refund
    Route::get('/returns', [AdminReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/{uuid}', [AdminReturnController::class, 'show'])->name('returns.show');
    Route::post('/returns/{uuid}/process-refund', [AdminReturnController::class, 'processRefund'])->name('returns.process-refund');
    Route::post('/returns/{uuid}/cancel-refund', [AdminReturnController::class, 'cancelRefund'])->name('returns.cancel-refund');
    // Announcement
    Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('announcement.create');
    Route::post('/announcement/store', [AnnouncementController::class, 'store'])->name('announcement.store');

    // Complaint Management
    Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{id}', [AdminComplaintController::class, 'show'])->name('complaints.show');
    Route::put('/complaints/{id}', [AdminComplaintController::class, 'update'])->name('complaints.update');
});

// Seller Routes
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Subscription Management
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscription/process', [SubscriptionController::class, 'subscribe'])->name('subscription.process');

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

    // Order Management
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{uuid}', [SellerOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{uuid}/process', [SellerOrderController::class, 'process'])->name('orders.process');
    Route::patch('/orders/{uuid}/ship', [SellerOrderController::class, 'ship'])->name('orders.ship');
    Route::patch('/orders/{uuid}/update-tracking', [SellerOrderController::class, 'updateTracking'])->name('orders.update-tracking');

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

    // Chat Routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}', [ChatController::class, 'store'])->name('chat.store');
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
    Route::put('/address/update/{uuid}', [UserAddressController::class, 'update'])->name('address.update');
    Route::patch('/address/set-default/{uuid}', [UserAddressController::class, 'setDefault'])->name('address.setDefault');
    Route::delete('/address/delete/{uuid}', [UserAddressController::class, 'delete'])->name('address.delete');
});
