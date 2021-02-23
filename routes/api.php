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
Route::namespace('Api')->group(function() {
    
    // Authentication
    Route::prefix('auth')->group(function() {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
    });


    Route::middleware('jwt.verify')->group(function() {

        // Profile
        Route::prefix('profile')->group(function() {
            Route::get('/', 'ProfileController@getAuthenticatedUser');
            Route::put('/update', 'ProfileController@updateProfile');
            Route::put('/change-password', 'ProfileController@changePassword');
            Route::get('/request-role/{role_id}', 'ProfileController@requestRole');
            Route::get('/set-self-as-admin', 'ProfileController@setSelfAsAdmin');
        });    

    });
});

Route::middleware('jwt.verify')->group(function() {
    
    Route::get('/cari-barang/{keyword?}', 'ProductController@cariBarang');
    Route::put('/business/update', 'BusinessController@updateBusiness')->middleware('can:admin');

    // Kasir    
    Route::prefix('kasir')->middleware('can:kasir')->group(function() {
        Route::prefix('member')->group(function() {
            Route::get('/cari/{keyword?}', 'MemberController@cariMember');
            Route::post('/create', 'MemberController@createMember');
            Route::post('/top-up', 'MemberController@topUpSaldoMember');
        });

        Route::prefix('penjualan')->group(function() {
            Route::get('form', 'PenjualanController@getFormTransaksi');
            Route::post('create-detail', 'Api\Kasir\PenjualanController@createDetailPenjualan');
            Route::post('finish', 'Api\Kasir\PenjualanController@finishPenjualan');
        });
    });
});

