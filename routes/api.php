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
    // get client's id and name
    Route::get('clients', 'ClientController@Clients');
    // set roles and permissions
    Route::apiResource('role', 'RolesController')->except(['create', 'edit', 'show']);
    // set dates with clients
    Route::apiResource('date', 'ClientDateController')->except(['create', 'edit']);
    // contact list
    Route::get('contactlist', 'ClientController@contactList');
    // employee
    Route::apiResource('employee', 'EmployeeController')->except(['create', 'edit']);
    // import
    Route::apiResource('import', 'ImportController')->except(['create', 'edit']);
    // Supplier
    Route::apiResource('supplier', 'SupplierController')->except(['create', 'edit']);
    // payment reports
    Route::apiResource('payment', 'PaymentReportsController')->only(['index', 'store']);
    // Earning Reports
    Route::apiResource('earning', 'EarningReportsController')->only(['index', 'store']);
    // Bill Reports
    Route::apiResource('billreport', 'BillReportsController')->only(['index', 'store']);
    // Sale Reports
    Route::apiResource('salereport', 'SalesReportsController')->only(['index', 'store']);
    // Repos
    Route::apiResource('repo', 'RepoController')->except(['create', 'edit']);
    // Purchase
    Route::apiResource('purchase', 'PurchaseController')->except(['create', 'edit']);
    // Products
    Route::apiResource('product', 'ProductController')->except(['create', 'edit']);
    // Services
    Route::apiResource('service', 'ServiceController')->except(['create', 'edit']);
    // add inventory
    Route::post('inventory', 'InventoryController@store');
    // Manual Addition
    Route::apiResource('addition', 'ManualAddController')->except(['create', 'edit']);
    // Manual Exchange
    Route::apiResource('exchange', 'ManualExchangeController')->except(['create', 'edit']);
    // Manual Conversion
    Route::apiResource('conversion', 'ManualConversionController')->except(['create', 'edit']);
    // Bills
    Route::apiResource('bill', 'BillController')->except(['create', 'edit']);
    // prices
    Route::apiResource('price', 'PriceController')->except(['create', 'edit']);
    // Credits
    Route::apiResource('credit', 'CreditController')->except(['create', 'edit']);
    // Periodic Bills
    Route::apiResource('periodic', 'PeriodicBillController')->except(['create', 'edit']);
    // Receipts
    Route::apiResource('receipt', 'ReceiptsController')->except(['create', 'edit']);
    // Catch Receipts
    Route::apiResource('catchreceipt', 'CatchReceiptsController')->except(['create', 'edit']);
    // Treasuries
    Route::apiResource('treasury', 'TreasuryController')->except(['create', 'edit']);
    // Bank Accounts
    Route::apiResource('bankaccount', 'BankAccountController')->except(['create', 'edit']);
    // Restrictions
    Route::apiResource('restriction', 'RestrictionController')->except(['create', 'edit']);
    // Account
    Route::post('account', 'AccountController@store');
    // Client Statuses
    Route::apiResource('status', 'ClientStatusController')->except(['create', 'edit', 'show']);
    // Date Actions
    Route::apiResource('action', 'DateActionController')->except(['create', 'edit', 'show']);
    // Taxes
    Route::apiResource('tax', 'TaxesController')->except(['create', 'edit', 'show']);

});