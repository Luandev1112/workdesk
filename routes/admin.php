<?php
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::post('/update', 'UpdateController@step0')->name('update');
Route::get('/update/step1', 'UpdateController@step1')->name('update.step1');
Route::get('/update/step2', 'UpdateController@step2')->name('update.step2');

Route::get('/admin', 'HomeController@admin_dashboard')->name('admin.dashboard')->middleware(['admin']);
Route::group(['prefix' =>'admin', 'middleware' => ['auth', 'admin']], function(){
	Route::get('profile', 'ProfileController@admin_profile')->name('admin.profile');
	Route::post('profile-update/{id}', 'ProfileController@update_admin_profile')->name('admin_profile.update');

	Route::resource('/project-categories', 'ProjectCategoryController');
	Route::get('/project-categories/destroy/{id}', 'ProjectCategoryController@destroy')->name('project-categories.destroy');

	Route::resource('skills','SkillController');
	Route::get('/skills/destroy/{id}', 'SkillController@destroy')->name('skills.destroy');

	Route::resource('badges','BadgeController');
	Route::get('/badges/destroy/{id}', 'BadgeController@destroy')->name('badges.destroy');
	Route::get('/client-badge', 'BadgeController@client_badges_create')->name('client_badges_create');
	Route::get('/client-badge/list', 'BadgeController@client_badges_index')->name('client_badges_index');
	Route::get('/client-badge/edit/{id}', 'BadgeController@client_badges_edit')->name('client_badges_edit');

	//PackageController for Freelancer and Client
	Route::get('/freelancer-package-index/{type}', 'PackageController@index')->name('freelancer_package.index');
	Route::get('/freelancer-package-create/{type}', 'PackageController@create')->name('freelancer_package.create');
	Route::post('/package-store', 'PackageController@store')->name('package.store');
	Route::post('/package-update/{id}', 'PackageController@update')->name('package.update');
	Route::get('/package-destroy/{id}', 'PackageController@destroy')->name('package.destroy');
	Route::get('/freelancer-package-edit/{id}', 'PackageController@edit')->name('freelancer_package.edit');
	Route::get('/client-package-index/{type}', 'PackageController@index')->name('client_package.index');
	Route::get('/client-package-create/{type}', 'PackageController@create')->name('client_package.create');
	Route::get('/client-package-edit/{id}', 'PackageController@edit')->name('client_package.edit');

	//LanguageController for Freelancer and Client
	Route::resource('/languages', 'LanguageController');
	Route::get('/languages/destroy/{id}', 'LanguageController@destroy')->name('languages.destroy');
	Route::post('/languages/update_language_status', 'LanguageController@update_language_status')->name('languages.update_language_status');
	Route::post('/languages/key_value_store', 'LanguageController@key_value_store')->name('languages.key_value_store');
    Route::post('/languages/update_language_status', 'LanguageController@update_language_status')->name('languages.update_language_status');

	//.env update
	Route::post('/env_key_update', 'SystemConfigurationController@env_key_update')->name('env_key_update.update');
	Route::post('/system-configuration/update', 'SystemConfigurationController@update')->name('system_configuration.update');

	//CurrencyController
	Route::resource('currencies','CurrencyController');
	Route::get('/currencies/destroy/{id}', 'CurrencyController@destroy')->name('currencies.destroy');
	Route::get('/currency/set_currency', 'CurrencyController@set_currency')->name('currencies.set_currency');

	//RoleController
	Route::resource('roles','RoleController');
    Route::get('/roles/destroy/{id}', 'RoleController@destroy')->name('roles.destroy');

	//EmployeeController
	Route::get('/employees/{name}', 'EmployeeController@index')->name('employees.index');
	Route::get('/employee/create', 'EmployeeController@create')->name('employees.create');
	Route::post('/employee/store', 'EmployeeController@store')->name('employees.store');
	Route::post('/employee/update/{id}', 'EmployeeController@update')->name('employees.update');
	Route::get('/employee/edit/{id}', 'EmployeeController@edit')->name('employees.edit');
	Route::get('/employee/set-permission/{id}', 'EmployeeController@show')->name('employees.set_permission');
    Route::get('/employees/destroy/{id}', 'EmployeeController@destroy')->name('employees.destroy');

	Route::post('/permissions/update/{id}', 'EmployeeController@permission_update')->name('permissions.update');

	Route::resource('countries','CountryController');
	Route::get('/countries/destroy/{id}', 'CountryController@destroy')->name('countries.destroy');

	Route::resource('cities','CityController');
	Route::get('/cities/destroy/{id}', 'CityController@destroy')->name('cities.destroy');

	Route::get('/all-projects', 'AdminProjectController@all_projects')->name('all_projects');
	Route::get('/running-projects', 'AdminProjectController@running_projects')->name('running_projects');
	Route::get('/open-projects', 'AdminProjectController@open_projects')->name('open_projects');
	Route::get('/cancelled-projects', 'AdminProjectController@cancelled_projects')->name('cancelled_projects');
	Route::get('/projects/destroy/{id}', 'ProjectController@destroy')->name('delete_project_by_admin');
	Route::post('/projects/approval-status', 'AdminProjectController@project_approval')->name('project_approval');

	Route::get('/general-configuration', 'SystemConfigurationController@activation_view')->name('general_configuration');
	Route::post('/general-configuration-update', 'SystemConfigurationController@updateActivation')->name('system_configuration.update.activation');

	Route::post('/freelancer-payment-configuration-update', 'SystemConfigurationController@update')->name('freelancer_payment_config_update');

	Route::get('/freelancer-payment-configuration', 'SystemConfigurationController@freelancer_payment_config')->name('freelancer_payment_settings');

	Route::get('cancel-project-request/index', 'CancelProjectController@index')->name('cancel-project-request.index');
	Route::post('cancel-project-request/show', 'CancelProjectController@show')->name('cancel-project-request.show');
	Route::get('cancel-project-request/destroy/{id}', 'CancelProjectController@destroy')->name('cancel-project-request.destroy');
	Route::post('cancel-project-request/accepted', 'CancelProjectController@request_accepted')->name('cancel-project-request.request_accepted');

	//general config
    Route::resource('general-config', 'GeneralConfigurationController')->only([
        'index', 'store'
    ]);

    //email config
    Route::resource('email-config', 'EmailConfigurationController')->only([
        'index', 'store'
    ]);

    //email config
    Route::resource('payment-config', 'PaymentConfigurationController')->only([
        'index', 'store'
    ]);

    //email config
    Route::resource('social-media-config', 'SocialMediaConfigurationController')->only([
        'index', 'store'
    ]);

	Route::get('/all-freelancers', 'UserController@all_freelancers')->name('all_freelancers');
	Route::get('/freelancer-info/{user_name}', 'UserController@freelancer_details')->name('freelancer_info_show');

	Route::get('/all-clients', 'UserController@all_clients')->name('all_clients');
	Route::get('/client-info/{user_name}', 'UserController@client_details')->name('client_info_show');

	Route::get('user/ban/{id}', 'UserController@destroy')->name('user.ban');

	Route::get('/verification-requests', 'VerificationController@index')->name('verification_requests');
	Route::get('/verification-request/details/{username}', 'VerificationController@show')->name('verification_request_details');
	Route::get('/verification-request/destroy/{id}', 'VerificationController@destroy')->name('verification_request_delete');
	Route::post('/verification-accept', 'VerificationController@verification_accept')->name('verififaction_accept');
	Route::post('/verification-reject', 'VerificationController@verification_reject')->name('verififaction_reject');

	// website setting
	Route::group(['prefix' => 'website'], function(){
		Route::get('/home', 'SystemConfigurationController@home_settings')->name('website.home');

		Route::view('/header', 'admin.default.website.header')->name('website.header')->middleware(['permission:show header']);
		Route::view('/footer', 'admin.default.website.footer')->name('website.footer')->middleware(['permission:show footer']);
		Route::view('/pages', 'admin.default.website.pages')->name('website.pages')->middleware(['permission:show pages']);
		Route::view('/appearance', 'admin.default.website.appearance')->name('website.appearance')->middleware(['permission:show apperance']);
		// Route::view('/website/pages/new', 'admin.default.website.pages-new')->name('website.pages.new');
		Route::resource('custom-pages', 'PageController');
		Route::get('/custom-pages/destroy/{id}', 'PageController@destroy')->name('custom-pages.destroy');
	});

	//Policy related
	Route::get('/policy/{type}', 'SystemConfigurationController@policy_index')->name('policy.index');
	Route::post('/system-policy/update', 'SystemConfigurationController@policy_update')->name('system_policy.update');



	//Milestone Pay Requests
	Route::get('/all-milestone-requests', 'MilestonePaymentController@all_milestone_request_index')->name('milestone-requests.admin.all');
	Route::get('/milestone-requests/{id}', 'MilestonePaymentController@milestone_request_details')->name('milestone_request_details');

	//chat_view
	Route::get('/user-chats', 'ChatController@admin_chat_index')->name('chat.admin.all');
	Route::get('/user-chats/{id}', 'ChatController@admin_chat_details')->name('chat_details_for_admin');

	// Milestone payment History
	Route::get('/all-project-payments', 'MilestonePaymentController@admin_index')->name('payment_history_for_admin');

	// Milestone payment to freelancer
	Route::get('/pay-to-user/{id}', 'PaytoFreelancerController@pay_to_freelancer')->name('pay_to_freelancer');
	Route::get('/pay_to_freelancer/cancel/{id}', 'PaytoFreelancerController@cancel_request')->name('pay_to_freelancer.cancel');
	Route::get('/freelancer-payments', 'PaytoFreelancerController@index')->name('freelancer_payment.index');
	Route::post('/pay-to-user/pay-store', 'PaytoFreelancerController@pay')->name('project_milestone_pay_from_admin');
	Route::get('/withdraw-requests', 'PaytoFreelancerController@withdraw_requests')->name('withdraw_request.index');

	// Package payment History
	Route::get('/all-package-payments', 'PackagePaymentController@admin_index')->name('package_payment_history_for_admin');

	// Service payment history
	Route::get('/all-services-admin', 'ServiceController@admin_all_services')->name('all_services_admin');
	Route::get('/all-cancelled_services', 'ServiceController@all_cancelled_services')->name('cancelled_services_admin');

	Route::get('/services-requested-for-cancellation', 'ServiceController@admin_requested_services_for_cancellation')->name('service_cancellation.requests');
	Route::post('cancel-service-request/show', 'ServiceController@cancel_service_request_show')->name('cancel-service-request.show');
	Route::post('cancel-service-request/accepted', 'ServiceController@cancel_service_request_accepted')->name('cancel-service-request.request_accepted');

	Route::get('/admin-service/{id}/cancel', 'ServiceController@admin_cancel_service')->name('cancel-service-request.destroy');


	Route::get('/all-service-payments', 'ServicePaymentController@admin_index')->name('service_payment_history_for_admin');

	// Wallet Recharge History
	Route::get('/all-wallet-recharge', 'WalletPaymentController@admin_index')->name('all-wallet-recharges_admin');

	//Addon
	Route::resource('addons','AddonController');
	Route::post('/addons/activation', 'AddonController@activation')->name('addons.activation');

	//Freelancer Review
	Route::get('/reviews/freelancer', 'ReviewController@freelancer_review_index')->name('reviews.freelancer');
	Route::get('/reviews/client', 'ReviewController@client_review_index')->name('reviews.client');
	Route::post('/reviews/published', 'ReviewController@update_review_published')->name('reviews.published');

	Route::get('/notifications','NotificationController@admin_listing')->name('admin.notifications');

	Route::get('/create-permission', 'HomeController@create_permission');

	Route::resource('staffs', 'StaffController');
	Route::get('/staffs/delete/{id}', 'StaffController@destroy')->name('staffs.destroy');


	Route::view('/system/update', 'admin.default.system.update')->name('system_update');
    Route::view('/system/server-status', 'admin.default.system.server_status')->name('system_server');

    // uploaded files
    Route::any('/uploaded-files/file-info', 'AizUploadController@file_info')->name('uploaded-files.info');
    Route::resource('/uploaded-files', 'AizUploadController');
    Route::get('/uploaded-files/destroy/{id}', 'AizUploadController@destroy')->name('uploaded-files.destroy');

});
