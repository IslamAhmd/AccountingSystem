<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentReports;
use Validator;

class PaymentReportsController extends Controller
{
    public function index(){

    	$payments = PaymentReports::get();

    	return response()->json([
          "status" => "success",
          "data" => $payments
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

        $payment = PaymentReports::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $payment
        ], 201);
    }
}
