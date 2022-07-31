<?php

Route::group(['prefix' => 'support'], function(){

	Route::resource('support-tickets','SupportTicketController');
	Route::get('/my-ticket', 'SupportTicketController@my_ticket')->name('support-tickets.my_ticket');
	Route::get('/solved-ticket', 'SupportTicketController@solved_ticket')->name('support-tickets.solved_ticket');
	Route::get('/active-ticket', 'SupportTicketController@active_ticket')->name('support-tickets.active_ticket');
	Route::post('support-ticket/agent/reply', 'SupportTicketController@ticket_reply')->name('support-ticket.admin_reply');
	Route::get('/support-ticket/destroy/{id}', 'SupportTicketController@destroy')->name('support-tickets.destroy');


	// deafult staff for assigning ticket
	Route::get('/default-ticket-assigned-agent', 'SupportTicketController@default_ticket_assigned_agent')->name('default_ticket_assigned_agent');

	// Support categories
	Route::resource('support-categories','SupportCategoryController');
	Route::get('/support-categories/destroy/{id}', 'SupportCategoryController@destroy')->name('support_categories.destroy');

});

Route::group(['middleware' => ['user', 'verified']], function(){
	Route::get('support-ticket/create', 'SupportTicketController@user_ticket_create')->name('support-tickets.user_ticket_create');
	Route::post('support-ticket/store', 'SupportTicketController@store')->name('support-ticket.store');
	Route::post('support-ticket/user-reply', 'SupportTicketController@ticket_reply')->name('support-ticket.user_reply');
	Route::get('support-ticket/history', 'SupportTicketController@user_index')->name('support-tickets.user_index');
	Route::get('support-ticket/view-details/{id}', 'SupportTicketController@user_view_details')->name('support-tickets.user_view_details');

});

?>
