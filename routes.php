<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//vendor name
Route::group(array('before' =>'auth','prefix' => 'module', 'namespace' => "Module\\Content\\Controller"), function() {
    //package name
    Route::group(array('prefix' => 'content'), function() {
        //controllers of packages
        Route::resource('/product', 'ContentController');
        Route::get('table', 'ContentController@getTable');

        Route::controller('/generate', 'GenerateController');
        Route::get('generate/table', 'GenerateController@getTable');


    });
});

Route::group(array('before' => 'auth'), function()
{
    \Route::get('elfinder', 'Barryvdh\Elfinder\ElfinderController@showIndex');
    \Route::any('elfinder/connector/', 'Barryvdh\Elfinder\ElfinderController@showConnector');
    Route::get('elfinder/standalonepopup/{input_id}', 'Barryvdh\Elfinder\ElfinderController@showPopup');
});