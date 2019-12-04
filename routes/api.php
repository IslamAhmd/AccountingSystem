<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('login', 'UserController@authenticate');


Route::group(['middleware' => ['jwt.verify']], function(){

	// add new client
    Route::apiResource('client', 'ClientController')->except(['create', 'edit']);
    // set roles and permissions
    Route::post('role', 'PermissionController@assignRolePermissions');
    // get roles
    Route::get('employee', 'PermissionController@getRoles');
    // get clients to set dates
    Route::get('getclients', 'ClientController@getClients');
    // set dates with clients
    // Route::post('date', '')

});