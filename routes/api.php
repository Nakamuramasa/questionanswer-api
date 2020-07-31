<?php

Route::get('me', 'User\MeController@getMe');

Route::get('questions', 'Questions\QuestionController@index');
Route::get('questions/{id}', 'Questions\QuestionController@findQuestion');
Route::get('questions/slug/{slug}', 'Questions\QuestionController@findBySlug');

Route::get('users', 'User\UserController@index');
Route::get('user/{username}', 'User\UserController@findByUsername');
Route::get('users/{id}/questions', 'Questions\QuestionController@getForUser');

Route::group(['middleware' => ['auth:api']], function(){
    Route::post('logout', 'Auth\LoginController@logout');
    Route::put('settings/password', 'User\SettingsController@updatePassword');

    Route::post('questions', 'Questions\QuestionController@store');
    Route::put('questions/{id}', 'Questions\QuestionController@update');
    Route::get('questions/{id}/byUser', 'Questions\QuestionController@userOwnsQuestion');
    Route::delete('questions/{id}', 'Questions\QuestionController@destroy');

    Route::post('questions/{id}/replies', 'Questions\ReplyController@store');
    Route::put('replies/{id}', 'Questions\ReplyController@update');
    Route::delete('replies/{id}', 'Questions\ReplyController@destroy');

    Route::post('replies/{id}/like', 'Questions\ReplyController@like');
    Route::get('replies/{id}/liked', 'Questions\ReplyController@checkIfUserHasLiked');
});

Route::group(['middleware' => ['guest:api']], function(){
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'Auth\VerificationController@resend');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});
