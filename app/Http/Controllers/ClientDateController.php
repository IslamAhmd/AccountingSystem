<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientDate;
use Validator;
use App\Client;

class ClientDateController extends Controller
{


    public function index(){

    	$dates = ClientDate::select('client_id', 'date', 'duration', 'time', 'action')->get();

    	return $dates;

    }


    public function store(Request $request){

    	$rules = [

            'client_id' => 'required|integer',
            'date' => 'required|date',
            'duration' => 'required|date_format:H:i',
            'time' => 'required|date_format:H:i',
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


    public function contactList(){

    	$clients = Client::select('first_name', 'code_num')->get();
    	return $clients;
    }

}
