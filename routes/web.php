<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\frontendController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\frontend\FrontController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\frontend\UserController;
use App\Http\Controllers\frontend\contactComplains;
use Illuminate\support\Facades\Mail;
use App\Mail\WelcomeMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontController::class, 'mainpage']);
Route::get('/category', [FrontController::class, 'category']);
Route::get('view-category/{slug}', [FrontController::class, 'viewCategory']);
Route::get('view-category/{cate_slug}/{prod_slug}', [FrontController::class, 'productView']);
Route::get('view-product/{prod_slug}', [FrontController::class, 'eachProdView']);

// Updated: Removed email verification requirement
Auth::routes(['verify' => false]);

// Optional: Comment out or remove email testing route
// Route::get('/email', function(){
//     Mail::to('mrmoiz1.dev@gmail.com')->send(new WelcomeMail());
//     return new WelcomeMail();
// });

Route::post('add-to-cart', [CartController::class, 'addProduct']);
Route::post('delete-cart-item', [CartController::class, 'deleteProduct']);
Route::post('update-cart', [CartController::class, 'updateCart']);
Route::post('searchProduct', [FrontController::class, 'searchProducts']);

Route::get('contact', [contactComplains::class, 'index']);
Route::post('sendMessage', [contactComplains::class, 'submitForm']);
Route::view('about', 'frontend.About');

// User routes - only require auth, no email verification
Route::middleware(['auth'])->group(function () {
    Route::get('cart', [CartController::class, 'viewCart']);
    Route::get('checkout', [CheckoutController::class, 'index']);
    Route::post('place-order', [CheckoutController::class, 'placeOrder']);
    Route::get('my-order', [UserController::class, 'index']);
    Route::get('view-order/{id}', [UserController::class, 'viewOrder']);
});

// Admin Dashboard Routes
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // FIXED: Use DashboardController@index instead of static view or frontendController
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Categories Routes
    Route::get('/categories', 'App\Http\Controllers\Admin\CategoriesController@index');
    Route::get('/add-category', 'App\Http\Controllers\Admin\CategoriesController@add');
    Route::post('insert-category', 'App\Http\Controllers\Admin\CategoriesController@insert');
    Route::get('edit-category/{id}', [CategoriesController::class, 'edit']);
    Route::put('update-category/{id}', [CategoriesController::class, 'update']);
    Route::get('delete-category/{id}', [CategoriesController::class, 'delete']);

    // Product Routes
    Route::get('/products', 'App\Http\Controllers\Admin\ProductController@index');
    Route::get('/add-product', 'App\Http\Controllers\Admin\ProductController@add');
    Route::post('insert-product', 'App\Http\Controllers\Admin\ProductController@insert');
    Route::get('edit-product/{id}', [ProductController::class, 'edit']);
    Route::put('update-product/{id}', [ProductController::class, 'update']);
    Route::get('delete-product/{id}', [ProductController::class, 'delete']);

    // Order Routes
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('admin/view-order/{id}', [OrderController::class, 'view']);
    Route::put('update-order/{id}', [OrderController::class, 'updateOrder']);
    Route::get('order-history', [OrderController::class, 'orderHistory']);

    // User Management Routes
    Route::get('users', [DashboardController::class, 'users']);
    Route::get('view-user/{id}', [DashboardController::class, 'viewUser']);

    // Contact/Message Routes
    Route::get('message', [contactComplains::class, 'viewcomplains']);
});