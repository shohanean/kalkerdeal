<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SslCommerzPaymentController;

require __DIR__ . '/auth.php';

Route::get('dashboard', [BackendController::class, 'dashboard'])->middleware(['auth', 'verified', 'check.customer'])->name('dashboard');

Route::middleware(['auth', 'check.customer'])->group(function () {
    Route::get('category', [CategoryController::class, 'index']);
    Route::get('category/create', [CategoryController::class, 'create']);
    Route::post('category/insert', [CategoryController::class, 'insert']);
    Route::get('category/delete/{category_id}', [CategoryController::class, 'delete']);
    Route::get('category/restore/{category_id}', [CategoryController::class, 'restore']);
    Route::get('category/permanent/delete/{category_id}', [CategoryController::class, 'permanent_delete']);
    Route::get('category/update/{category_id}', [CategoryController::class, 'update']);
    Route::post('category/edit/{category_id}', [CategoryController::class, 'edit']);
    Route::get('category/all/restore', [CategoryController::class, 'restore_all']);
    Route::get('category/all/permanant/delete', [CategoryController::class, 'permanent_delete_all']);

    Route::get('user', [UserController::class, 'index']);
    Route::get('user/create', [UserController::class, 'create']);
    Route::post('user/insert', [UserController::class, 'insert']);

    Route::get('my/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('change/password', [ProfileController::class, 'change_password'])->name('change.password');
    Route::post('change/information', [ProfileController::class, 'change_information'])->name('change.information');

    Route::resource('product', ProductController::class);
    Route::get('add/inventory/{id}', [ProductController::class, 'add_inventory'])->name('add.inventory');
    Route::post('insert/inventory/{id}', [ProductController::class, 'insert_inventory'])->name('insert.inventory');

    Route::get('add/attribute', [AttributeController::class, 'add_attribute'])->name('add.attribute');
    Route::post('insert/size', [AttributeController::class, 'insert_size'])->name('insert.size');
    Route::post('insert/color', [AttributeController::class, 'insert_color'])->name('insert.color');

    Route::resource('coupon', CouponController::class);
});


Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('product/details/{id}', [FrontendController::class, 'product_details'])->name('product.details');
Route::get('search', [FrontendController::class, 'search'])->name('search');
Route::get('add/to/wishlist/{id}', [FrontendController::class, 'add_to_wishlist'])->name('add.to.wishlist');
Route::get('remove/from/wishlist/{id}', [FrontendController::class, 'remove_from_wishlist'])->name('remove.from.wishlist');
Route::get('wishlist', [FrontendController::class, 'wishlist'])->name('wishlist');
Route::post('custom/login', [FrontendController::class, 'custom_login'])->name('custom.login');
Route::post('get/color/list', [FrontendController::class, 'get_color_list'])->name('get.color.list');
Route::get('cart', [FrontendController::class, 'cart'])->name('cart');
Route::post('add/to/cart', [FrontendController::class, 'add_to_cart'])->name('add.to.cart');
Route::get('remove/from/cart/{id}', [FrontendController::class, 'remove_from_cart'])->name('remove.from.cart');
Route::post('update/cart', [FrontendController::class, 'update_cart'])->name('update.cart');
Route::get('about', [FrontendController::class, 'about'])->name('about');
Route::get('shop/{category_slug}', [FrontendController::class, 'shop'])->name('shop');
Route::get('checkout', [FrontendController::class, 'checkout'])->name('checkout');
Route::post('add/address', [FrontendController::class, 'add_address'])->name('add.address');
Route::post('checkout/final', [FrontendController::class, 'checkout_final'])->name('checkout.final');
Route::get('contact', [FrontendController::class, 'contact'])->name('contact');

Route::get('github/redirect', [GithubController::class, 'redirect'])->name('github.redirect');
Route::get('github/callback', [GithubController::class, 'callback'])->name('github.callback');

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

Route::get('customer/dashboard', [CustomerController::class, 'dashboard']);
Route::get('invoice/download/{invoice_id}', [CustomerController::class, 'invoice_download'])->name('invoice.download');
Route::get('customer/review/{invoice_id}', [CustomerController::class, 'customer_review'])->name('customer.review');
Route::post('customer/review/insert', [CustomerController::class, 'customer_review_insert'])->name('customer.review.insert');
