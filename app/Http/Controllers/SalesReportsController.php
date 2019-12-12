<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\SalesReports;


class SalesReportsController extends Controller
{
    public function index(){

    	$sales = SalesReports::get();

    	return response()->json([
          "status" => "success",
          "data" => $sales
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
            ], 400);
        }

        $sale = SalesReports::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $sale
        ], 201);
    }
}
