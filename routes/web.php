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
    Route::get('edit_customer/{id}', 'CustomerController@show'); //Edit customer view
    Route::get('delete_customer/{id}', 'CustomerController@destroy'); //Delete customer
    Route::get('view_customers', 'CustomerController@customer_view')->name('view_customer'); //View Added customers

    Route::get('tyres', 'TyreController@index'); // Load tyre view
    Route::post('add_tyres', 'TyreController@store'); // Register New Tyres
    Route::get('view_tyres', 'TyreController@create')->name('view_tyre'); // View Added Tyres

    Route::get('belt_category', 'TyreController@indexCategory'); // Load category view
    Route::post('add_category', 'TyreController@storeCategory'); //view Added categories
    Route::get('/tyres/edit', 'TyreController@show');
    Route::post('update_category', 'TyreController@updateCategory');
    Route::get('delete_category/{id}', 'TyreController@destroy');
    Route::get('delete_sub_category/{id}', 'TyreController@destroySubCategory');
    Route::get('delete_tire/{id}', 'TyreController@destroyTire');
    // sub catogory add
    Route::post('add_subcatogory', 'TyreController@addSubcatogory');
    Route::get('tyres/sub_cat_edit', 'TyreController@showSubcatogory');
    Route::post('update_sub_category', 'TyreController@updateSubCategory');

    Route::get('tyres/tire_edit', 'TyreController@showTires');
    Route::post('update_tires', 'TyreController@updateTires');

    Route::get('prices', 'Belt_priceController@index'); //Load price view
    Route::get('/tyres/find', 'Belt_priceController@search_products'); //auto complete get tyres
    Route::get('/tyres/category', 'Belt_priceController@get_category'); //load tyre sub category
    Route::get('/tyres/sub_category', 'Belt_priceController@get_subcategory'); //load tyre sub category
    Route::get('/price/beltno', 'Belt_priceController@gen_beltno'); //gen belt no
    Route::post('add_prices', 'Belt_priceController@store'); //Register new prices
    Route::get('view_prices', 'Belt_priceController@create')->name('view_prices'); // View Added Prices
    Route::get('edit_price/{id}', 'Belt_priceController@show'); //Edit price view
    Route::post('update_price/{id}', 'Belt_priceController@update'); //Update price
    Route::get('delete_price/{id}', 'Belt_priceController@destroy'); //Delete Users

    Route::get('orders', 'TyreordersController@index'); // Load tyre orders view
    Route::get('orders/generate_no', 'TyreordersController@gen_order_no'); //Generate Order No
    Route::get('/orders/customers', 'TyreordersController@search_customers'); //Auto complete get customers
    Route::get('/tyres/batch_numbers', 'TyreordersController@get_batchno'); //load batch numbers
    Route::get('/tyres/cus_prices', 'TyreordersController@get_cus_prices'); //load customer prices
    Route::get('/orders/remain_credit_limit', 'TyreordersController@search_customer_credit_amount'); //Auto complete get customers
    Route::get('/orders/customer_credit_limit', 'TyreordersController@search_customer_credit_limit'); //Auto complete get customers

    Route::post('add_salesorder', 'TyreordersController@store'); //Save Sales Order
    Route::get('view_orders', 'TyreordersController@create')->name('view_orders'); // View Added Orders
    Route::get('/display_order/{id}', 'TyreordersController@get_order_details'); //Get user details for display
    Route::get('delete_order/{id}', 'TyreordersController@destroy'); //Delete Sales Orders
    Route::get('/print_order/{id}', 'TyreordersController@print_order'); //Print Sales Orders
    Route::get('edit_order/{id}', 'TyreordersController@edit_order'); //Edit Sales Order
    Route::post('update_salesorder', 'TyreordersController@update_order'); //Update Edited Sales Order
    Route::get('/complete_order/{id}', 'TyreordersController@complete_order'); // Load Tyre order Complete Purpose
    Route::post('/update_order_reason', 'TyreordersController@update_order_reason'); // Update order reason

    Route::get('/order/stock_availability', 'TyreordersController@get_stocks'); //Check stock availability

    //stock add module
    Route::get('view_grn', 'GoodRecievedController@index')->name('view_grn'); //view added grns
    Route::get('grn/generate_no', 'GoodRecievedController@gen_grn_no'); //Generate GRN No
    Route::get('grn', 'GoodRecievedController@show'); //create grn
    Route::post('add_grn', 'GoodRecievedController@store'); //save grn details
    Route::get('/display_grn/{id}', 'GoodRecievedController@get_grn_details'); //Get user details for display

    Route::post('add_completeorder', 'CompleteOrderController@store'); // Load complete orders view
    Route::get('view_completeorders', 'CompleteOrderController@index'); // View added complete orders
    Route::get('display_completeorder/{id}', 'CompleteOrderController@show'); // Display complete orders
    Route::get('/print_invoice/{id}', 'CompleteOrderController@print_invoice'); //Print Complete Sales Orders

    Route::get('payment', 'PaymentController@index'); //Load Payment view
    Route::get('/payment/load_invoice', 'PaymentController@get_outstanding_invoice');
    Route::get('/payment/outstanding', 'PaymentController@get_outstanding_amount');
    Route::post('add_payment', 'PaymentController@store');
    Route::get('view_payments', 'PaymentController@create')->name('view_payments'); // View Added Payments
    Route::get('/display_payment/{id}', 'PaymentController@show'); //Get Payment details for display
    Route::get('/print_payment/{id}', 'PaymentController@print_payment'); //Print Payments

    Route::get('stock_statement', 'StockReportController@index')->name('stock_report.index');
    Route::get('stock_statement/search', 'StockReportController@search');
    // Route::post('search_stock_statement', 'StockReportController@search')->name('stock_report.search');

    Route::get('invoice_summary', 'InvoiceSummaryReportController@index')->name('invoice.index');
    Route::get('invoice_summary/search', 'InvoiceSummaryReportController@search');

    Route::get('outstanding_summary', 'OutstandingSummaryController@index')->name('outstanding.index');
    Route::get('outstanding_summary/search', 'OutstandingSummaryController@search');


    Route::get('permission', 'PermissionController@index');
    Route::post('save_parmission', 'PermissionController@store');
    Route::get('view_parmissions', 'PermissionController@create')->name('view_parmission'); // View Added Payments
    Route::get('display_permission/{id}', 'PermissionController@show');
    Route::get('edit_permission/{id}', 'PermissionController@edit');
    Route::post('update_parmission/{id}', 'PermissionController@update'); //Update Edited Sales Order
    Route::get('delete_permission/{id}', 'PermissionController@destroy');

});
