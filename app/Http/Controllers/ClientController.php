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
    public function index()
    {


        $clients = Client::get();

        return response()->json([
          "status" => "success",
          "data" => $clients
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
            'trade_name' => 'required_if:type,business|unique:clients',
            'full_name' => 'required_if:type,individual|unique:clients',
            'first_name' => 'required_if:type,business',
            'last_name' => 'required_if:type,business',
            'mobile' => 'required|integer',
            'telephone' => 'required|integer',
            'first_address' => 'required',
            'sec_address' => 'required',
            'state' => 'required',
            'postal_code' => 'required|integer',
            'country' => 'required',
            'city' => 'required',
            'tax_record' => 'integer',
            'secondary_address' => 'Boolean',
            'secondary_address1' => 'required_if:secondary_address,1',
            'secondary_address2' => 'required_if:secondary_address,1',
            'sec_city' => 'required_if:secondary_address,1',
            'sec_state' => 'required_if:secondary_address,1',
            'sec_country' => 'required_if:secondary_address,1',
            'sec_postal_code' => 'required_if:secondary_address,1|integer',
            'code_num' => 'required|integer|unique:clients',
            'invoicing_method' => 'required',
            'currency' => 'required',
            'email' => 'required|email|unique:clients',
            'category' => 'required',
            'notes' => 'required',
            'language' => 'required',
            'price' => 'required',
            'contact_email' => 'email|unique:clients',
            'contact_telephone' => 'integer',
            'contact_mobile' => 'integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $client = Client::create([
          'type' => $request->type,
          'trade_name' => $request->trade_name,
          'full_name' => $request->full_name,
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'mobile' => $request->mobile,
          'telephone' => $request->telephone,
          'first_address' => $request->first_address,
          'sec_address' => $request->sec_address,
          'state' => $request->state,
          'postal_code' => $request->postal_code,
          'country' => $request->country,
          'city' => $request->city,
          'tax_record' => $request->tax_record,
          'cr' => $request->cr,
          'secondary_address' => $request->secondary_address,
          'secondary_address1' => $request->secondary_address1,
          'secondary_address2' => $request->secondary_address2,
          'sec_city' => $request->sec_city,
          'sec_state' => $request->sec_state,
          'sec_country' => $request->sec_country,
          'sec_postal_code' => $request->sec_postal_code,
          'code_num' => $request->code_num,
          'invoicing_method' => $request->invoicing_method,
          'currency' => $request->currency,
          'email' => $request->email,
          'category' => $request->category,
          'notes' => $request->notes,
          'language' => $request->language
        ]);

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
            ]);

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
            ]);

        }

        $rules = [
            'type' => 'required',
            'trade_name' => "required|unique:clients,trade_name,$id",
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
            'code_num' => "required|integer|unique:clients,code_num,$id",
            'billingmethod' => 'required',
            'currency' => 'required',
            'email' => "required|email|unique:clients,email,$id",
            'category' => 'required',
            'notes' => 'required',
            'language' => 'required',
            'prices' => 'required',
            'send_data' => 'Boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

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
            ]);

        }


        $client->delete();

        return response()->json([
          "status" => "success",
          "message" => "Client deleted Successfully"
        ]);
    }


    // قائمة الاتصال
    public function contactList(){
      

        $clients = Client::select('first_name', 'last_name', 'trade_name', 'mobile', 'phone', 'code_num', 'email')->get();


        return response()->json([
          "status" => "success",
          "data" => $clients
        ], 200);
        
    }


    public function getClients(){

      $clients = Client::select('id', 'first_name', 'last_name')->get();

      return response()->json([
          "status" => "success",
          "data" => $clients
      ], 200);


    }

    public function Clients(){

      $clients = Client::select('id', 'first_name', 'last_name')->get();

      return response()->json([
          "status" => "success",
          "data" => $clients
      ], 200);


    }


}
