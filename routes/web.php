<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('login', 'Auth\LoginController@getLogin')->name('login');
    Route::get('panel', 'Auth\LoginController@getPanel')->name('panel');
    Route::get('logout', 'Auth\LoginController@getLogout')->name('auth.logout');
    Route::post('authenticate/client', 'Auth\LoginController@authenticate_client');
    Route::post('authenticate/administration', 'Auth\LoginController@authenticate_administration');
    Route::post('registration', 'Auth\RegisterController@registration');
    Route::get('register/confirmation/{token}', 'Auth\LoginController@confirmEmail')->name('confirm.email');
    Route::post('password/remind', 'Auth\ForgotPasswordController@sendPasswordReminder');
    Route::get('password/reset/{admin}/{token}', 'Auth\ResetPasswordController@getReset');
    Route::post('password/reset', 'Auth\ResetPasswordController@postReset');

    Route::get('/home', 'HomeController@index');


    /**
     * Setting of system
    */
    Route::group([
         'prefix' => 'setting'
     ], function () {

        Route::get('/administration',
            'SettingController@administration')
            ->name('setting.administration');

     	Route::get('/conditions_and_privacy',
     		'SettingController@conditions_and_privacy')
    		->name('setting.conditions_and_privacy');

        Route::get('/client/terms_conditions',
            'SettingController@conditions_client')
            ->name('setting.client.conditions');

        Route::get('/client/politics_privacy',
            'SettingController@privacy_client')
            ->name('setting.client.privacy');

        Route::get('/working_hours',
            'SettingController@working_hours')
            ->name('setting.working.hours');

        Route::post('/working_hours/update',
            'SettingController@working_hours_update')
            ->name('setting.update.working.hours');

        Route::post('/update',
            'SettingController@update')
            ->name('setting.update');

     });

    /**
     * Adminitrations of Users
    */
    Route::get('user/password', 'UserController@password')->name('user.password');
    Route::put('user/password', 'UserController@change_password')->name('user.password.update');
    Route::get('user/setting', 'UserController@setting')->name('user.setting');
    Route::put('user/setting', 'UserController@update_setting')->name('user.setting.update');
    Route::resource('user', 'UserController');

    /**
     *  Adminitrations of Roles
    */
    Route::resource('role', 'RoleController');/**
    
    /**
    *  Profile
    */
    Route::put('profile/avatar', 'ProfileController@updateAvatar')->name('update.avatar');
    Route::resource('profile', 'ProfileController');

    /**
     * Coupons administrations
    */
    Route::get('coupon/clients', 'CouponController@clients')->name('coupon.clients');
    Route::get('coupon/validate', 'CouponController@check_coupon')->name('coupon.check');
    Route::get('coupon/clients/show/{id}', 'CouponController@client_show')->name('coupon.clients.show');
    Route::get('coupon/send/{id}', 'CouponController@sendToClients')->name('coupon.send');
    Route::post('coupon/store/send/{id}', 'CouponController@sendStoreCouponsClients')->name('coupon.store.send');
    Route::resource('coupon', 'CouponController');

    /**
     * Branch offices administrations
    */
    Route::get('admin-branch-office/locations', 'Admin\BranchOfficeController@locations')->name('admin-branch-office.map');
    Route::resource('admin-branch-office', 'Admin\BranchOfficeController');

    /**
     * Clients administrations
    */
    Route::get('admin-client/friends', 'Admin\ClientController@friends')->name('admin-client.friends');
    Route::get('admin-client/locations', 'Admin\ClientController@locations')->name('admin-client.map');
     Route::get('admin-client/address/{client}', 'Admin\ClientController@editStatusLocations')->name('admin-client.address');
    Route::resource('admin-client', 'Admin\ClientController');

    /**
     * Drivers administrations
    */
    Route::get('admin-driver/activities/{id}', 'Admin\DriverController@showActivities')
        ->name('admin-driver.activities');
    Route::get('admin-driver/comission/shedule/{id}', 'Admin\DriverController@editComissionShedule')
        ->name('admin-driver.comission.shedule.edit');
    Route::put('admin-driver/comission/shedule/{id}', 'Admin\DriverController@updateComissionShedule')
        ->name('admin-driver.comission.shedule.update');
    Route::resource('admin-driver', 'Admin\DriverController');
    
    /**
     * Branch offices 
    */ 
    Route::get('branch-office/{id}/services', 'BranchOfficeController@services')
        ->name('branch-office.services');
    Route::get('branch-office/order/{status}', 'BranchOfficeController@orders')
        ->name('branch-office.order');
    Route::post('branch-office/order/{id}/complete', 'BranchOfficeController@completeOrder')
        ->name('branch-office.order.complete');
    Route::get('branch-office/order/{id}/change/incomplete', 'BranchOfficeController@reasonChangeBranch')
        ->name('branch-office.order.incomplete');
    Route::post('branch-office/reason/{id}/incomplete/update', 
        'BranchOfficeController@reasonIncompleteUpdate')
        ->name('branch-office.order.incomplete.update');
    Route::resource('branch-office', 'BranchOfficeController');

    /**
     * Faqs Administrations 
    */
    Route::resource('admin-faq', 'Admin\FaqController');

    /**
     * Clients
    */
    Route::get('client/setting', 'ClientController@setting')->name('client.setting');
    Route::put('client/setting', 'ClientController@update_setting')->name('client.setting.update');
    Route::get('client/friend', 'ClientController@friends')->name('client.friends');
    Route::post('client/friend', 'ClientController@friends_store')->name('client.friends.store');
    Route::get('client/locations', 'ClientController@locations')->name('client.locations');
    Route::put('client/locations/update', 'ClientController@updateLocations')->name('client.locations.update');
    Route::resource('client', 'ClientController');

    /**
     * Driver
    */
    Route::get('driver/my-activities', 'DriverController@activities')->name('driver.activities');
    Route::get('driver/order/itinerary', 'DriverController@itinerary')->name('driver.order.itinerary');
    Route::get('driver/order/itinerary/delivery', 'DriverController@itinerary_delivery')->name('driver.order.itinerary.delivery');
    Route::post('driver/order/{id}/taked', 'DriverController@takedOrder')->name('driver.order.taked');
    Route::get('driver/order/branch-taked/{id}', 'DriverController@list_branch')->name('driver.order.branch.list');
    Route::put('driver/order/branch/update/{id}', 'DriverController@update_branch_order')->name('driver.order.branch.update');
    Route::post('driver/order/{id}/inbranch', 'DriverController@inBranchOrder')->name('driver.order.inbranch');
    Route::post('driver/order/{id}/inexit', 'DriverController@inexitOrder')->name('driver.order.inexit');
    Route::post('driver/order/{id}/delivered', 'DriverController@deliveredOrder')->name('driver.order.delivered');
    Route::get('driver/notification/count', 'DriverController@countNotification')->name('driver.notification.count');
    Route::get('driver/notification', 'DriverController@notifications')->name('driver.notifications');

    Route::resource('driver', 'DriverController');

    /**
     * Faqs clients
    */
    Route::resource('faq', 'FaqController');

    /**
     * Services
    */
    Route::resource('service', 'ServiceController');

    /**
     * Orders
    */
    Route::get('my_orders', 'OrderController@my_orders')->name('my.orders');
    Route::get('service/payment/{order}', 'OrderController@method_payment')->name('order.payment');
    Route::post('service/payment/{order}', 'OrderController@method_payment_store')->name('order.payment.store');
    Route::put('service/payment/{payment}', 'OrderController@method_payment_update')->name('order.payment.update');
    Route::get('service/payment/penalty/{order}', 'OrderController@method_payment_penalty')->name('order.payment.penalty');
    Route::put('service/payment/penalty/{payment}', 'OrderController@method_payment_penalty_update')->name('order.payment.penalty.update');

    Route::get('order/bag-code/{id}', 'OrderController@changeBagCode')->name('order.change.bag');
    Route::put('order/bag-code/{id}', 'OrderController@updateBagCode')->name('order.bag.update');
    Route::resource('order', 'OrderController');

    /**
     * orders administrations
    */
    Route::get('admin-order/{client}/finance', 'Admin\OrderController@finance')->name('admin-order.finance');
    Route::get('admin-order/confirmed/{id}', 'Admin\OrderController@changeConfirmed')->name('admin-order.change.confirmed');
    Route::put('admin-order/confirmed/{id}', 'Admin\OrderController@updateConfirmed')->name('admin-order.confirmed.update');
    Route::get('admin-order/status/{id}', 'Admin\OrderController@changeStatus')->name('admin-order.change.status');
    Route::put('admin-order/status/{id}', 'Admin\OrderController@updateStatus')->name('admin-order.status.update');
    Route::resource('admin-order', 'Admin\OrderController');

    /**
     * packages administrations
    */
    Route::get('admin-package/categories', 'Admin\PackageController@categories_index')->name('admin-package.categories.index');
    Route::resource('admin-package', 'Admin\PackageController');

    /**
     * packages categories administrations
    */
    Route::resource('admin-package-category', 'Admin\PackageCategoryController');

    /**
     * packages
    */
    Route::get('package/show/category', 'PackageController@show_by_category')->name('package.show.category');
    Route::get('package/details', 'PackageController@details')->name('package.get.details');
    Route::get('package/order/preview', 'PackageController@orderPreview')->name('package.preview.order');
    Route::resource('package', 'PackageController');

    /**
     * suggestions Administration
    */
    Route::resource('admin-suggestion', 'Admin\SuggestionController');

    /**
     * suggestions
    */
    Route::resource('suggestion', 'SuggestionController');

    /**
     * Qualification
    */
    Route::resource('qualification', 'QualificationController');

    /**
     * Notification
    */
    
    Route::get('notification/supervisor/count', 'NotificationController@countNotificationSupervisor')->name('supervisor.notification.count');
    Route::post('notification/store/change-branch/{id}', 'NotificationController@storeChangeBranch')->name('notification.store.change.branch');
    
    Route::resource('notification', 'NotificationController');
 