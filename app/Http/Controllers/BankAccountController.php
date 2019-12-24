<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BankAccount;
use Validator;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = BankAccount::get();

        return response()->json([
          "status" => "success",
          "data" => $accounts
        ], 200);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:bank_accounts',
            'desc' => 'required',
            'payment' => 'required|integer',
            'withdraw' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $account = BankAccount::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $account
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = BankAccount::find($id);
        if(! $account){
            return response()->json([
              "status" => "error",
              "errors" => "Account Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $account
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $account = BankAccount::find($id);
        if(! $account){
            return response()->json([
              "status" => "error",
              "errors" => "Account Not Found"
            ]);

        }

        $rules = [
            'name' => "required|unique:bank_accounts,name,$id",
            'desc' => 'required',
            'payment' => 'required|integer',
            'withdraw' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $account->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $account
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = BankAccount::find($id);
        if(! $account){
            return response()->json([
              "status" => "error",
              "errors" => "Account Not Found"
            ]);

        }

        $account->delete();

        return response()->json([
          "status" => "success",
          "message" => "Account deleted Successfully"
        ]);

    }
}
