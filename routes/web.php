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

Route::group([], function () {
    Route::get('/', 'HomeController@index');
    Auth::routes();
    
    Route::namespace('Admin')->prefix('admin')->group(function () {
        Route::get('/', 'DashboardController@index');

        Route::get('login', 'LoginController@showLoginForm')->name('adminLogin')->middleware('guest');
  
        Route::post('invoices/export', 'InvoiceController@export');
        Route::get('invoices/browse_invoices', 'InvoiceController@browseInvoices');
        Route::get('invoices/create_invoice', 'InvoiceController@createInvoice');
        Route::get('invoices/edit_invoice/{id}', 'InvoiceController@editInvoice');
        Route::resource('invoices', 'InvoiceController');

        // Users controller
        Route::resource('users', 'UserController');
        Route::get('users/create_user', 'UserController@createUser');
        Route::get('users/browse_users', 'UserController@browseUsers');
        Route::get('users/edit_user/{id}', 'UserController@editUser');
    });
    
    Route::namespace('User')->prefix('user')->group(function () {
        Route::get('/', 'DashboardController@index');
    });
});

// Catch all page controller (place at the very bottom)
//Route::get('{slug}', ['uses' => 'PageController@getPage'])->where('slug', '([ა-ჰA-Za-z0-9\-\/]+)');