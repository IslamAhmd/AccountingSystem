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
	public function index(Request $request){

        $rules = [
            'name' => 'required',
            'import_num' => 'required',
            'client_id' => 'required',
            'employee_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()){

            return response()->json($validator->errors(), 400);

        }

		$import = Import::where('name', $request->name)
                            ->where('import_num', $request->import_num)
                            ->where('client_id', $request->client_id)
                            ->where('employee_id', $request->employee_id)
                            ->first();

        if(! $import){

            return ["message" => "Import not found"];
        }

		return $import;
		
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
    		'shipment_num' => 'required|integer',
    		'container_data' => 'required',
    		'shipment_date' => 'required|date',
    		'arrival_date' => 'required|date',
    		'abstract_name' => 'required|integer',
    		'abstract_num' => 'required|integer',
    		'shipment_location' => 'required',
    		'doc_credit_num' => 'required|integer',
    		'gurantee_letter_num' => 'required|integer'
    	];


    	$validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json($validator->errors(), 400);

        }

    	$import = Import::create($request->all());

    	return response()->json($import, 201);

    }


}
