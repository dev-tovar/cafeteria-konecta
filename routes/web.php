<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

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

Route::resource('crudProduct', ProductController::class);
Route::resource('crudSale', SaleController::class);
Route::post('search-product', [ProductController::class, 'searchProduct']);




Route::get('/', function () {
    return view('pages.home');
});
Route::get('/products', function () {
    return view('pages.home');
});
Route::get('/products/new', function () {
    return view('pages.home');
});
Route::get('/products/edit/{id_producto}', function () {
    return view('pages.home');
});
Route::get('/shop-products', function () {
    return view('pages.home');
});
Route::get('/sales-products', function () {
    return view('pages.home');
});
Route::get('/yecid-tovar', function () {
    return view('pages.home');
});
