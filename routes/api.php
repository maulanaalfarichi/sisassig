<?php

use Illuminate\Http\Request;

use App\Province;
use App\Regency;
use App\District;
use App\Village;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/province', function () {
    return Province::all();
});
Route::get('/regency', function () {
    return Regency::all();
});
Route::get('/district', function () {
    return District::all();
});
Route::get('/village', function () {
    return Village::all();
});

Route::get('/province/{id}', function ($id) {
    return Province::findOrFail($id);
});
Route::get('/regency/{id}', function ($id) {
    return Regency::findOrFail($id);
});
Route::get('/district/{id}', function ($id) {
    return District::findOrFail($id);
});
Route::get('/village/{id}', function ($id) {
    return Village::findOrFail($id);
});
Route::get('/user/{id}', function ($id) {
    return User::findOrFail($id);
});

Route::get('/dropdown/regency/{id}', function ($id) {
    return Regency::where(['province_id' => $id])->get();
});
Route::get('/dropdown/district/{id}', function ($id) {
    return District::where(['regency_id' => $id])->get();
});
Route::get('/dropdown/village/{id}', function ($id) {
    return Village::where(['district_id' => $id])->get();
});

Route::get('/search/regency', function (Request $request) {
    $term = $request->query('term');
    return Regency::where('name', 'like', '%' . $term . '%')->get();
});

Route::get('/search/user', function (Request $request) {
    $term = $request->query('term');
    return User::where('name', 'like', '%' . $term . '%')->get();
});