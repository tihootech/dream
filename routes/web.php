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

// game and landing
Route::get('search', 'GameController@search')->name('search');
Route::get('process', 'GameController@process')->name('process');
Route::get('competition/{year?}', 'LandingController@competition')->name('competition');
Route::post('competition', 'GameController@save_competition');
Route::post('next_month', 'ProcessController@next_month');
Route::post('stars/quick_add', 'GameController@quick_add')->name('quick_add');
Route::post('stars/quick_plus', 'GameController@quick_plus')->name('quick_plus');
Route::post('master', 'GameController@master')->name('master');
Route::get('result/{year?}', 'GameController@result')->name('result');
Route::get('points/delete/{point}', 'GameController@delete_point');
Route::get('points/{point}/edit', 'GameController@edit_point');
Route::get('prixes/{year?}', 'GameController@prixes')->name('prixes');
Route::post('rooms/{sid}', 'GameController@change_room')->name('rooms');
Route::get('sync/{name}', 'GameController@sync');
Route::get('events', 'LandingController@events')->name('events');
Route::get('rooms', 'LandingController@rooms')->name('rooms');
Route::get('birthdays', 'LandingController@birthdays');
Route::get('top10-track/{year?}', 'LandingController@top10_track')->name('top10_track');
Route::post('final/{type}', 'SemiFinalController@store');

// settings
Route::get('settings', 'SettingsController@edit')->name('settings');
Route::put('settings/time', 'SettingsController@update_time')->name('update_time');
Route::put('settings/trophies', 'SettingsController@update_trophies')->name('update_trophies');
Route::put('settings/competitions', 'SettingsController@update_competitions')->name('update_competitions');
Route::put('settings/base_point', 'SettingsController@update_base_points')->name('update_base_points');

//ajax
Route::get('random/{tops?}', 'GameController@random')->name('random');
