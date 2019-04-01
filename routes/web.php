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
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/users', 'UserController@index'); // Load user view
    Route::post('/add_users', 'UserController@store'); //Register new users
    Route::get('/view_users', 'UserController@user_view')->name('view_users'); //View added users
    Route::get('/get_userdetails/{id}', 'UserController@edit_user'); //Get user details for edit
    Route::post('/update_users/{id}', 'UserController@update'); //Edit & Update users
    Route::get('delete_user/{id}', 'UserController@destroy'); //Delete Users

    Route::get('customers', 'CustomerController@index'); //Load customer view
    Route::post('add_customers', 'CustomerController@store'); //Register new customers
    Route::post('update_customer/{id}', 'CustomerController@update'); //Update customer
    Route::resource('edit_customer', 'CustomerController'); //Edit customer view
    Route::get('delete_customer/{id}', 'CustomerController@destroy'); //Delete customer
    Route::get('view_customers', 'CustomerController@customer_view')->name('view_customer'); //View Added customers

    Route::get('tyres', 'TyreController@index'); // Load tyre view
    Route::post('add_tyres', 'TyreController@store'); // Register New Tyres
    Route::get('view_tyres', 'TyreController@create')->name('view_tyre'); // View Added Tyres

    Route::get('belt_category', 'TyreController@indexCategory'); // Load category view
    Route::post('add_category', 'TyreController@storeCategory'); //view Added categories
    Route::get('/tyres/edit', 'TyreController@show');
    Route::post('update_category', 'TyreController@updateCategory');
    Route::get('delete_tyer/{id}', 'TyreController@destroy');
    // sub catogory add
    Route::post('add_subcatogory', 'TyreController@addSubcatogory');
    Route::get('tyres/sub_cat_edit', 'TyreController@showSubcatogory');
    Route::post('update_sub_category', 'TyreController@updateSubCategory');

    Route::get('prices', 'Belt_priceController@index'); //Load price view
    Route::get('/tyres/find', 'Belt_priceController@search_products'); //auto complete get tyres
    Route::get('/tyres/category', 'Belt_priceController@get_category'); //load tyre sub category
    Route::get('/tyres/sub_category', 'Belt_priceController@get_subcategory'); //load tyre sub category
    Route::get('/price/beltno', 'Belt_priceController@gen_beltno'); //gen belt no
    Route::post('add_prices', 'Belt_priceController@store'); //Register new prices
    Route::get('view_prices', 'Belt_priceController@create')->name('view_prices'); // View Added Prices

    Route::get('orders', 'TyreordersController@index'); // Load tyre orders view
    Route::get('orders/generate_no', 'TyreordersController@gen_order_no'); //Generate Order No
    Route::get('/orders/customers', 'TyreordersController@search_customers'); //Auto complete get customers
    Route::get('/tyres/batch_numbers', 'TyreordersController@get_batchno'); //load batch numbers
    Route::get('/tyres/cus_prices', 'TyreordersController@get_cus_prices'); //load customer prices
    Route::post('add_salesorder', 'TyreordersController@store'); //Save Sales Order
    Route::get('view_orders','TyreordersController@create')->name('view_orders'); // View Added Orders
    Route::get('/display_order/{id}', 'TyreordersController@get_order_details'); //Get user details for display
    Route::get('delete_order/{id}', 'TyreordersController@destroy'); //Delete Sales Orders
    Route::get('/print_order/{id}', 'TyreordersController@print_order'); //Print Sales Orders
    Route::get('edit_order/{id}', 'TyreordersController@edit_order'); //Edit Sales Order
    Route::post('update_salesorder', 'TyreordersController@update_order'); //Update Edited Sales Order
    
    //stock add module
    Route::get('view_grn', 'GoodRecievedController@index')->name('view_grn'); //view added grns
    Route::get('grn/generate_no', 'GoodRecievedController@gen_grn_no'); //Generate GRN No
    Route::get('grn', 'GoodRecievedController@show'); //create grn
    Route::post('add_grn', 'GoodRecievedController@store');//save grn details
    Route::get('/display_grn/{id}', 'GoodRecievedController@get_grn_details'); //Get user details for display
    
    Route::get('complete_orders/{id}', 'CompleteOrderController@create'); // Load complete orders view

});
