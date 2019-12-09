<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Validator;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // ادارة الاعملاء 
    public function index(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'type' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ], 400);

        }

        $client = Client::where('first_name', $request->first_name)
                        ->where('last_name', $request->last_name)
                        ->where('type', $request->type)
                        ->first();

        if(! $client){

            return response()->json([
              "status" => "error",
              "errors" => "Client Not Found"
            ], 400);
        }

        return response()->json([
          "status" => "success",
          "data" => $client
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $rules = [
            'type' => 'required',
            'trade_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|integer',
            'phone' => 'required|integer',
            'first_address' => 'required',
            'sec_address' => 'required',
            'governorate' => 'required',
            'postal_code' => 'required|integer',
            'country' => 'required',
            'city' => 'required|string',
            'code_num' => 'required|integer',
            'currency' => 'required',
            'email' => 'required|email',
            'notes' => 'required',
            'language' => 'required',
            'send_data' => 'Boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ], 400);

        }

        $client = Client::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $client
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $client = Client::find($id);

        if(! $client){

            return response()->json([
              "status" => "error",
              "errors" => "Client Not Found"
            ], 400);

        }


        return response()->json([
          "status" => "success",
          "data" => $client
        ], 200);


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if(! $client){

            return response()->json([
              "status" => "error",
              "errors" => "Client Not Found"
            ], 400);

        }

        $client->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $client
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        if(! $client){

            return response()->json([
              "status" => "error",
              "errors" => "Client Not Found"
            ], 400);

        }


        $client->delete();

        return response()->json([
          "status" => "success",
          "message" => "Client deleted Successfully"
        ]);
    }


    // قائمة الاتصال
    public function contactList(Request $request){

        $rules = [
            'first_name' => 'required',
            'code_num' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ], 400);

        }
        

        $client = Client::where('first_name', $request->first_name)
                          ->where('code_num', $request->code_num)
                          ->first();

        if(! $client){

            return response()->json([
              "status" => "error",
              "errors" => "Client Not Found"
            ], 400);

        }

        return response()->json([
          "status" => "success",
          "data" => $client
        ], 200);
        
    }


}
