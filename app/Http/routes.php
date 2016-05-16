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