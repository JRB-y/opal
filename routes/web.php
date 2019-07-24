<?php
Route::get('/', function () {
    return view('welcome');
});


Route::get('products-grid/{offset}', 'Products\ProductsController@productGrid');
Route::resource('products', 'Products\ProductsController');
Route::post('products/update', 'Products\ProductsController@update');
Route::post('products/delete', 'Products\ProductsController@delete');
Route::post('/products/count', 'Products\ProductsController@countProducts');
Route::post('/product/update/secondaryImage', 'Images\ImagesController@updateSecondaryImage');
Route::post('/images/delete/secondary', 'Images\ImagesController@deleteSecondary');

Route::get('/admin', 'AdminController@dashboard')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
// ################################################ Stay in bottom
Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');