<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientDate;
use Validator;
use App\Client;



// duration and time 


class ClientDateController extends Controller
{


    public function index(){

      $dates = ClientDate::get();

    	return response()->json([
          "status" => "success",
          "data" => $dates
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
            ]);

        }

        $date = ClientDate::create([
          'client_id' => $request->client_id,
          'date' => $request->date,
          'duration' => $request->duration,
          'time' => $request->time,
          'action' => $request->action,
          'sharing' => $request->sharing,
          'repeated' => $request->repeated,
          'client_name' => Client::where('id', $request->client_id)->first()->trade_name
        ]);

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
            ]);

        }
        
    	$date->update([
          'client_id' => $request->client_id,
          'date' => $request->date,
          'duration' => $request->duration,
          'time' => $request->time,
          'action' => $request->action,
          'sharing' => $request->sharing,
          'repeated' => $request->repeated,
          'client_name' => Client::where('id', $request->client_id)->first()->trade_name
        ]);

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
