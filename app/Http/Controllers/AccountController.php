<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Validator;

class AccountController extends Controller
{
    public function store(Request $request){

    	$rules = [
    		'type' => 'required',
    		'code_num' => 'required|unique:accounts|integer',
    		'name' => 'required|unique:accounts',
    		'account' => 'required',
    		'genre' => 'required'
    	];

    	$validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }


        $account = Account::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $account
        ], 201);
    
    }
}
