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

        Route::prefix('kasir')->group(function() {
            // Route::
        });

    });
});

Route::middleware('jwt.verify')->group(function() {
    
    Route::get('/cari-barang/{keyword?}', 'ProductController@cariBarang');
    Route::put('business/update', 'BusinessController@updateBusiness')->middleware('can:admin');

});

