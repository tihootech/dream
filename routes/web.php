<?php

// laravel defaults
Route::redirect('/','login');
Route::get('home', 'HomeController@index')->name('home');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// resource
Route::resource('stars', 'StarController');
Route::resource('awards', 'AwardController');

// game
Route::get('search', 'GameController@search')->name('search');
Route::get('process', 'GameController@process')->name('process');
Route::post('next_month', 'GameController@next_month');
Route::post('stars/quick_add', 'GameController@quick_add')->name('quick_add');
Route::post('stars/quick_plus', 'GameController@quick_plus')->name('quick_plus');
Route::post('master', 'GameController@master')->name('master');
Route::get('result/{year?}', 'GameController@result')->name('result');
Route::get('events', 'GameController@events')->name('events');
Route::get('points/delete/{point}', 'GameController@delete_point');
Route::get('points/{point}/edit', 'GameController@edit_point');
Route::get('prixes', 'GameController@prixes')->name('prixes');


// settings
Route::get('settings', 'SettingsController@edit')->name('settings');
Route::put('settings/time', 'SettingsController@update_time')->name('update_time');
Route::put('settings/trophies', 'SettingsController@update_trophies')->name('update_trophies');
Route::put('settings/base_point', 'SettingsController@update_base_points')->name('update_base_points');
