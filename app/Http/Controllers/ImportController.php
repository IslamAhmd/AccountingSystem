<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Import;
use Validator;
use App\Client;
use App\Employee;



class ImportController extends Controller
{

    // اوامر الاستيراد
	public function index(){

        $imports = Import::get();

		return response()->json([
          "status" => "success",
          "data" => $imports
        ], 200);
		
	}


    public function store(Request $request){

    	$rules = [
    		'name' => 'required|string',
    		'import_num' => 'required|integer',
    		'starts_at' => 'required|date',
    		'ends_at' => 'required|date',
    		'budget' => 'required',
    		'client_id' => 'required',
    		'employee_id' => 'required',
            'desc' => 'required',
            'tag' => 'required',
    		'shipment_num' => 'required|integer',
    		'container_data' => 'required',
    		'shipment_date' => 'required|date',
    		'arrival_date' => 'required|date',
    		'abstract_name' => 'required',
    		'abstract_num' => 'required|integer',
    		'shipment_location' => 'required',
    		'doc_credit_num' => 'required|integer',
    		'gurantee_letter_num' => 'required|integer'
    	];


    	$validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ], 400);

        }

    	$import = Import::create($request->all());

    	return response()->json([
          "status" => "success",
          "data" => $import
        ], 201);

    }


}
