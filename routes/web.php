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

        Route::get('/', 'ProductController@index')->name('inventaris');
        Route::post('new-product', 'ProductController@newProduct')->name('inventaris.new-product');
    });
});