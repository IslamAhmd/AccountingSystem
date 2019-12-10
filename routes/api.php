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

	// client
    Route::apiResource('client', 'ClientController')->except(['create', 'edit']);
    // set roles and permissions
    Route::apiResource('role', 'RolesController')->except(['create', 'edit', 'show']);
    // set dates with clients
    Route::apiResource('date', 'ClientDateController')->except(['create', 'edit']);
    // contact list
    Route::get('contactlist', 'ClientController@contactList');
    // employee
    Route::apiResource('employee', 'EmployeeController')->except(['create', 'edit']);
    // add new imports
    Route::post('import', 'ImportController@store');
    // get all imports
    Route::get('imports', 'ImportController@index');
    // Supplier
    Route::apiResource('supplier', 'SupplierController')->except(['create', 'edit', 'index']);
    // get all suppliers
    Route::post('suppliers', 'SupplierController@index');

});