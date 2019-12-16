<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\EarningReports;


class EarningReportsController extends Controller
{
    public function index(){

    	$earnings = EarningReports::get();

    	return response()->json([
          "status" => "success",
          "data" => $earnings
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

        $earning = EarningReports::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $earning
        ], 201);
    }

}
