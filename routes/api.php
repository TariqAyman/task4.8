<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::middleware(['auth:api'])->group(function () {

    Route::post('logout', 'AuthController@logout');

    Route::get('products', 'ProductsController@index');

    Route::post('products/search', 'ProductsController@search');

    Route::get('cart', 'CartController@index');

    Route::get('empty-cart', 'CartController@empty_cart');

    Route::get('add-to-cart/{id}', 'CartController@addToCart');

    Route::post('update-cart', 'CartController@update');

    Route::post('remove-from-cart', 'CartController@remove');

});
