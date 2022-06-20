<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "admin" middleware group. Enjoy building your Admin!
|
*/

Route::namespace('Report')->group(function () {
    Route::get('report/assignment', 'AssignmentController@index');
    Route::get('report/assignment/print', 'AssignmentController@print');
    Route::get('assignment/letter/{id}', 'AssignmentController@letterIndex');
    Route::get('assignment/letter/{id}/print', 'AssignmentController@letterPrint');
});

Route::get('/', 'HomeController@admin');
Route::get('dashboard', 'HomeController@index');

Route::get('user/api', 'UserController@api')->name('user.api');
Route::resource('user', 'UserController');
Route::get('role/api', 'RoleController@api')->name('role.api');
Route::resource('role', 'RoleController');
Route::get('permission/api', 'PermissionController@api')->name('permission.api');
Route::resource('permission', 'PermissionController');

Route::get('my-assignment/api', 'MyAssignmentController@api')->name('my-assignment.api');
Route::get('my-assignment/', 'MyAssignmentController@index')->name('my-assignment.index');
Route::get('my-assignment/{id}', 'MyAssignmentController@show')->name('my-assignment.show');

Route::get('assignment/api', 'AssignmentController@api')->name('assignment.api');
Route::resource('assignment', 'AssignmentController');

Route::get('assignment-user/api/{id}', 'AssignmentUserController@api')->name('assignment-user.api');
Route::get('assignment-user/{id}', 'AssignmentUserController@show')->name('assignment-user.show');
Route::post('assignment-user', 'AssignmentUserController@store')->name('assignment-user.store');
Route::get('assignment-user/{id}/edit', 'AssignmentUserController@edit')->name('assignment-user.edit');
Route::put('assignment-user/{id}', 'AssignmentUserController@update')->name('assignment-user.update');
Route::delete('assignment-user/{id}', 'AssignmentUserController@destroy')->name('assignment-user.destroy');

Route::get('activity-log/api', 'ActivityLogController@api')->name('activity-log.api');
Route::get('activity-log/{id}', 'ActivityLogController@show')->name('activity-log.show');
Route::get('activity-log', 'ActivityLogController@index')->name('activity-log.index');