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
Route::group(['domain' => env('DOMAIN_ADMIN')], function(){
    Route::get('/', function () { return view('admin.index'); });
});

Route::group(['domain' => env('DOMAIN_USER'), 'namespace' => 'User'], function(){
    // Route::get('/', function () { return view('admin.index'); });
});
