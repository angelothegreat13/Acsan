<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Admin')->group(function() {
    Route::prefix('admin')->group(function () {

        Route::get('/login','AuthController@login')->name('admin.auth.login');
        Route::post('/process-login','AuthController@processLogin')->name('admin.auth.process-login');

        Route::group(['middleware' => 'admin'], function() {
            Route::get('/logout','AuthController@logout')->name('admin.auth.logout');
            Route::get('/dashboard','DashboardController')->name('admin.dashboard');

            Route::get('/products','ProductsController@index')->name('admin.products.index');
            Route::get('/products/create','ProductsController@create')->name('admin.products.create');
            Route::post('/products/store','ProductsController@store')->name('admin.products.store');
            Route::get('/products/{product}/edit','ProductsController@edit')->name('admin.products.edit');
            Route::patch('/products/{product}/update','ProductsController@update')->name('admin.products.update');
            Route::get('/products/{product}/attribute','ProductsController@attribute')->name('admin.products.attribute');
            Route::delete('/products/{product}','ProductsController@destroy')->name('admin.products.destroy');

            Route::post('/product-option-values','ProductAttributesController@getOptionValues');
            Route::post('/product-attrib/store','ProductAttributesController@store')->name('admin.product-attrib.store');
            Route::get('/product-attrib/{productAttrib}/edit','ProductAttributesController@edit')->name('admin.product-attrib.edit');
            Route::delete('/product-attrib/{productAttrib}','ProductAttributesController@destroy')->name('admin.product-attrib.destroy');

            Route::get('/attributes','AttributesController@index')->name('admin.attributes.index');
            
            Route::get('/attributes/{option}/edit-option','AttributesController@editOption')->name('admin.attributes.edit-option');
            Route::patch('/attributes/{option}/update-option','AttributesController@updateOption')->name('admin.attributes.update-option');
            Route::get('/attributes/create-option','AttributesController@createOption')->name('admin.attributes.create-option');
            Route::post('/attributes/store-option','AttributesController@storeOption')->name('admin.attributes.store-option');
            Route::delete('/attributes/{option}/delete-option','AttributesController@destroyOption')->name('admin.attributes.destroy-option');

            Route::get('/attributes/{option}/manage-option-values','AttributesController@manageOptionValues')->name('admin.attributes.manage-option-values');

            Route::post('/attributes/store-option-value','AttributesController@storeOptionValue')->name('admin.attributes.store-option-value');
            Route::get('/attributes/{optionValue}/edit-option-value','AttributesController@editOptionValue')->name('admin.attributes.edit-option-value');
            Route::patch('/attributes/{optionValue}/update-option-value','AttributesController@updateOptionValue')->name('admin.attributes.update-option-value');
            Route::delete('/attributes/{optionValue}/delete-option-value','AttributesController@destroyOptionValue')->name('admin.attributes.destroy-option-value');

            Route::get('/feedbacks','FeedbacksController@index')->name('admin.feedbacks.index');
            Route::get('/feedbacks/{feedback}','FeedbacksController@show')->name('admin.feedbacks.show');

            Route::get('/orders','OrdersController@index')->name('admin.orders.index');
            Route::get('/orders/{order}/manage','OrdersController@manage')->name('admin.orders.manage');
            Route::patch('/orders/{order}/update-order-status','OrdersController@updateOrderStatus')->name('admin.orders.update-order-status');

            Route::get('/sales-report','SalesReportController@index')->name('admin.sales-report');

            Route::get('/customers','CustomersController@index')->name('admin.customers.index');
        });

    });
});

Route::namespace('Web')->group(function() {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/login','AuthController@login')->name('auth.login');
    Route::post('/process-login','AuthController@processLogin')->name('auth.process-login');

    Route::get('/register','RegistrationController@index')->name('registration.index');
    Route::post('/register/process','RegistrationController@process')->name('registration.process');

    Route::get('/cart','CartController@index')->name('cart.index');
    Route::post('/cart/store','CartController@store')->name('cart.store');
    Route::delete('/cart/{cartID}','CartController@destroy')->name('cart.destroy');
    Route::post('/cart/add-to-cart','CartController@addToCart')->name('cart.add-to-cart');
    
    Route::get('/products/{slug}','ProductsController@show')->name('products.show');

    Route::get('/faqs','PagesController@faqs')->name('faqs');
    Route::get('/about-us','PagesController@aboutUs')->name('about-us');
    Route::post('/send-feedback','PagesController@sendFeedback')->name('send-feedback');

    Route::group(['middleware' => 'customer'], function() {
        Route::get('/logout','AuthController@logout')->name('auth.logout');
        Route::get('/orders/checkout','OrdersController@checkout')->name('orders.checkout');
        Route::post('/orders/process-checkout','OrdersController@processCheckout')->name('orders.process-checkout');

        Route::get('/profile','ProfileController@index')->name('profile.index');
        Route::patch('/profile/{customer}/update','ProfileController@update')->name('profile.update');

        Route::get('/orders','OrdersController@index')->name('orders.index');
        Route::get('/orders/{order}/manage','OrdersController@manage')->name('orders.manage');
        Route::patch('/orders/{order}/upload-bank-statement','OrdersController@uploadBankStatement')->name('orders.upload-bank-statement');

        Route::get('/change-password','ChangePasswordController@index')->name('change-password');
        Route::patch('/change-password/{customer}update','ChangePasswordController@update')->name('change-password.update');

    });

    Route::get('{category}',['uses' => 'CategoriesController@index']);
});