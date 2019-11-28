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
        //
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
            'trade_name' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'mobile' => 'required|integer',
            'phone' => 'required|integer',
            'first_address' => 'required|string',
            'sec_address' => 'required|string',
            'governorate' => 'required|string',
            'postal_code' => 'required|integer',
            'country' => 'required|string',
            'city' => 'required|string',
            'code_num' => 'required|integer',
            'currency' => 'required|string',
            'email' => 'required|string|email',
            'notes' => 'required',
            'language' => 'required|string',
            'send_data' => 'Boolean',
            'commercial_register' => 'string',
            'tax_record' => 'string'
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
    public function show(Client $client)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
