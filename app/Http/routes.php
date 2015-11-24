<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controllers([
   'auth'=>'Auth\AuthController',
    'password'=>'Auth\PasswordController'
]);

Route::group(array('before' => 'auth'), function(){
   Route::get('pages/studentInfo/{id}', 'studentController@show');
    Route::get('pages/editInfo/{id}', 'studentController@edit');
    Route::post('pages', 'studentController@update');

});

Route::resource('student', 'studentController');