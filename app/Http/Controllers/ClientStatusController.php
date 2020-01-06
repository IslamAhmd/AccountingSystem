<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientStatus;
use Validator;

class ClientStatusController extends Controller
{
    public function index(){

    	$statuses = ClientStatus::get();

    	return response()->json([
          "status" => "success",
          "data" => $statuses
        ], 200);

    }



    public function store(Request $request){

    	$rules = [
    		'name' => "required|unique:client_statuses",
    		'color' => 'required'
    	];

    	$validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $status = ClientStatus::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $status
        ], 201);

    }



    public function update($id, Request $request){

    	$status = ClientStatus::find($id);


    	$rules = [
    		'name' => "required|unique:client_statuses,name,$id",
    		'color' => 'required'
    	];

    	$validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $status->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $status
        ], 200);

    }



    public function destroy($id){

    	$status = ClientStatus::find($id);

    	$status->delete();

    	return response()->json([
          "status" => "success",
          "message" => "Status deleted Successfully"
        ]);
    }
}
