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
    return redirect('/home');
});

Route::controllers([
   'auth'=>'Auth\AuthController',
    'password'=>'Auth\PasswordController'
]);

Route::group(array('before' => 'auth'), function(){
   Route::get('pages/studentInfo/{id}', 'studentController@show');
    Route::get('pages/editInfo/{id}', 'studentController@edit');
    Route::get('pages/studentInfo/pages/editInfo/{id}', 'studentController@edit');
    Route::post('pages', 'studentController@update');
    Route::get('admin/teamInfo', 'studentController@admin')->middleware(['admin']);
    Route::post('admin/teamInfo', 'studentController@makeTeams');
    Route::post('admin/assignTeam', 'studentController@assignTeam');
    Route::post('admin/removeMember', 'studentController@removeMember');

});

Route::get('pages/teamInfo', 'studentController@team');

Route::resource('student', 'studentController');