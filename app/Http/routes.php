<?php

/**
 * Application point of entrance
 */

Route::get('/', 'MainController@index');

/**
 * List of available countries to call to.
 */
Route::resource('/api/country', 'Api\CountriesController',
    ['only' => ['index', 'show']]
);

/**
 * External resource routes
 * TODO make 'em post methods
 */
Route::get('processCallStart', 'Api\TwilioController@processCallStart');
Route::get('processSms', 'Api\TwilioController@processSms');
Route::get('processCallEnd', 'Api\TwilioController@processCallEnd');
Route::get('voiceFallback', 'Api\TwilioFallbackController@voiceFallback');
Route::get('voiceFallback', 'Api\TwilioFallbackController@smsFallback');