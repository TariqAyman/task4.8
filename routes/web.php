<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('products', 'ProductsController@index')->name('products');

Route::post('/products/search', 'ProductsController@search')->name('products.search');


Route::get('cart', 'CartController@index')->name('cart');

Route::get('empty-cart', 'CartController@empty_cart')->name('empty-cart');

Route::get('add-to-cart/{id}', 'CartController@addToCart')->name('add-to-cart');

Route::patch('update-cart', 'CartController@update')->name('update-cart');

Route::delete('remove-from-cart', 'CartController@remove')->name('remove-from-cart');
