<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\BillReports;

class BillReportsController extends Controller
{
    public function index(){

    	$bills = BillReports::get();

    	return response()->json([
          "status" => "success",
          "data" => $bills
        ], 200);
    }

    public function store(Request $request){

    	$rules = [
    		"from" => "required|date",
    		"to" => "required|date",
    		"type" => "required",
    		"client_id" => "required",
    		"employee_id" => "required",
    		"import_id" => "required",
    	];

    	$validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);
        }

        $bill = BillReports::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $bill
        ], 201);
    }
}
