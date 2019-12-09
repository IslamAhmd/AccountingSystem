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

    	return $dates;

    }


    public function store(Request $request){

    	$rules = [

            'client_id' => 'required|integer',
            'date' => 'required|date',
            'duration' => 'required',
            'time' => 'required',
            'action' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json($validator->errors(), 400);

        }

        $date = ClientDate::create($request->all());
        return response()->json($date, 201);

    }


     public function show($id){

     	$date = ClientDate::find($id);
     	if(! $date){
     		return response()->json([
     			"message" => "Date not Found"
     		]);
     	}

     	return response()->json($date, 200);
    }


    public function update(Request $request, $id){

    	$date = ClientDate::find($id);
    	$date->update($request->all());

        return response()->json($date, 200);

    }

    public function destroy($id){

    	$date = ClientDate::find($id);

    	if(! $date){
     		return response()->json([
     			"message" => "Date not Found"
     		]);
     	}

     	$date->delete();

        return response()->json([
        	"message" => "Date deleted Successfully"
        ]);

    }

}
