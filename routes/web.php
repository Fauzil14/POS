<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware('verified')->name('home');

Route::get('/cari-barang/{keyword?}', 'ProductController@cariBarang');

Route::prefix('dashboard')->middleware(['verified'])->group(function() {
    Route::get('/', 'HomeController@dashboard')->name('dashboard');

    Route::prefix('inventaris')->group(function() {

        // Product
        Route::get('/', 'ProductController@index')->name('inventaris');
        Route::post('/new-product', 'ProductController@newProduct')->name('inventaris.new-product');
        Route::get('/show-product/{product_id}', 'ProductController@show')->name('inventaris.show.product');
        Route::put('/update-product', 'ProductController@update')->name('inventaris.update.product');
        Route::put('/update-product', 'ProductController@update')->name('inventaris.update.product');
        Route::delete('/delete-product/{product_id}', 'ProductController@delete')->name('inventaris.delete.product');
        
        // Kategori
        Route::get('/kategori', 'CategoryController@kategori')->name('inventaris.kategori');
        Route::get('/show-kategori/{category_id}', 'CategoryController@show')->name('inventaris.kategori.show');
        Route::post('/new-kategori', 'CategoryController@newCategory')->name('inventaris.new.kategori');
        Route::put('/update-kategori', 'CategoryController@update')->name('inventaris.update.kategori');
        Route::delete('/delete-kategori/{category_id}', 'CategoryController@delete')->name('inventaris.delete.kategori');

    });

    Route::prefix('supplier')->group(function() {
        Route::get('/', 'SupplierController@index')->name('supplier');
    });
});