<?php

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


Route::get('products-grid/{offset}', 'Products\ProductsController@productGrid');
Route::resource('products', 'Products\ProductsController');
Route::post('products/update', 'Products\ProductsController@update');
Route::post('products/delete', 'Products\ProductsController@delete');
Route::get('/admin', 'AdminController@dashboard')->middleware('auth');
Route::post('/products/count', 'Products\ProductsController@countProducts');
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
