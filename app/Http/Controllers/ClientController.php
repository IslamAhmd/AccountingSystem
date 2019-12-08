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
    public function index()
    {
        $clients = Client::select('first_name', 'last_name', 'mobile', 'phone', 'email', 'first_address', 'sec_address')->get();

        return $clients;
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

            return response()->json($validator->errors(), 400);

        }

        $client = Client::create($request->all());
        return response()->json($client, 201);
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
                "Message" => "Not Found"
            ]);

        }


        return response()->json($client, 200);
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
                "Message" => "Not Found"
            ]);

        }

        $client->update($request->all());

        return response()->json($client, 200);
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
                "Message" => "Not Found"
            ]);

        }


        $client->delete();

        return response()->json(["message" => "Client deleted Successfully"], 204);
    }


}
