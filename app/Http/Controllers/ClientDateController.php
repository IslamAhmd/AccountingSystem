<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientDate;
use Validator;
use App\Client;


// duration and time 


class ClientDateController extends Controller
{


    public function index(Request $request){

        $rules = [

            'action' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ], 400);

        }

    	$date = ClientDate::where('action', $request->action)->first();

        if(! $date){

            return response()->json([
              "status" => "error",
              "errors" => "Date Not Found"
            ]);
        }

    	return response()->json([
          "status" => "success",
          "data" => $date
        ], 200);

    }


    public function store(Request $request){

    	$rules = [

            'client_id' => 'required|integer',
            'date' => 'required|date',
            'duration' => 'required',
            'time' => 'required',
            'action' => 'required',
            'sharing' => 'Boolean',
            'repeated' => 'Boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ], 400);

        }

        $date = ClientDate::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $date
        ], 201);

    }


     public function show($id){

     	$date = ClientDate::find($id);
     	if(! $date){
     		return response()->json([
              "status" => "error",
              "errors" => "Date Not Found"
            ]);

     	}

     	return response()->json([
          "status" => "success",
          "data" => $date
        ], 200);
    }


    public function update(Request $request, $id){

    	$date = ClientDate::find($id);

        if(! $date){

            return response()->json([
              "status" => "error",
              "errors" => "Date Not Found"
            ]);

        }
    	$date->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $date
        ], 200);

    }

    public function destroy($id){

    	$date = ClientDate::find($id);

    	if(! $date){

     		return response()->json([
              "status" => "error",
              "errors" => "Date Not Found"
            ]);
     	}

     	$date->delete();

        return response()->json([
          "status" => "success",
          "message" => "Date deleted Successfully"
        ]);

    }

}
