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
        Route::post('/new-supplier', 'SupplierController@newSupplier')->name('supplier.new-supplier');
        Route::get('/show-supplier/{supplier_id}', 'SupplierController@show')->name('supplier.show');
        Route::put('/update-supplier', 'SupplierController@update')->name('supplier.update');
        Route::delete('/delete-supplier/{supplier_id}', 'SupplierController@delete')->name('supplier.delete');

    });

    Route::prefix('member')->group(function() {
        Route::get('/', 'MemberController@index')->name('member');
        Route::post('/new-member', 'MemberController@newSupplier')->name('member.new-member');
        Route::get('/show-member/{member_id}', 'MemberController@show')->name('member.show');
        Route::put('/update-member', 'MemberController@update')->name('member.update');
        Route::delete('/delete-member/{member_id}', 'MemberController@delete')->name('member.delete');

    });
});