<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientContact;
use App\ClientPrice;
use App\Price;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Bill;


class ClientController extends Controller
{
     

    public function index()
    {


        $clients = Client::get();

        $clients_id = $clients->pluck('id');
        
        $clientscontacts = ClientContact::whereIn('client_id', $clients_id)->get();
      
        
        $clientprices = ClientPrice::whereIn('client_id', $clients_id)->select(['price_id', 'price_name'])->get();

        return response()->json([
          "status" => "success",
          "data" => [

            'client' => $clients,
            'clientcontact' => $clientscontacts,
            'clientprice' => $clientprices

          ]
        ], 200);

    }




    public function store(Request $request){

        $price = new Price;

        $rules = [
            'type' => 'required',
            'trade_name' => 'required_if:type,business|unique:clients',
            'full_name' => 'required_if:type,individual|unique:clients',
            'first_name' => 'required_if:type,business',
            'last_name' => 'required_if:type,business',
            'postal_code' => 'integer',
            'secondary_address' => 'Boolean',
            'secondary_address1' => 'required_if:secondary_address,1',
            'secondary_address2' => 'required_if:secondary_address,1',
            'sec_city' => 'required_if:secondary_address,1',
            'sec_state' => 'required_if:secondary_address,1',
            'sec_country' => 'required_if:secondary_address,1',
            'sec_postal_code' => 'required_if:secondary_address,1|integer',
            'code_num' => 'required|integer|unique:clients',
            'email' => 'required|email|unique:clients',
            'contacts.*.contact_email' => 'email',
            'contacts.*.contact_telephone' => 'integer',
            'contacts.*.contact_mobile' => 'integer',
            'send_data' => 'Boolean|required_if:invoicing_method,send via email',
            'price_id' => [

              Rule::exists($price->getTable(),$price->getKeyName()),

            ],    

        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }


        // create client 
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
          'language' => $request->language,
          'send_data' => $request->send_data,
          'employee_id' => Auth::id(),
          'tag' => $request->tag
        ]);

        // create client contacts
        $contacts = $request->contacts;
        foreach ((array) $contacts as $contact) {

          ClientContact::create([

            'client_id' => $client->id,
            'contact_Fname' => isset($contact['contact_Fname'])? $contact['contact_Fname'] : null,
            'contact_Lname' => isset($contact['contact_Lname'])? $contact['contact_Lname'] : null ,
            'contact_email' => isset($contact['contact_email'])? $contact['contact_email'] : null,
            'contact_telephone' => isset($contact['contact_telephone'])? $contact['contact_telephone'] : null,
            'contact_mobile' => isset($contact['contact_mobile'])? $contact['contact_mobile'] : null
          ]);
          

        }

        // get client name based on his type
        $type = $client->type;
        switch($type){
          case "business": 
            $clientName = Client::find($client->id)->trade_name;
          break;
          case "individual":
            $clientName = Client::find($client->id)->full_name;
          break;
        }

        // create client price
        if($price->where('id', $request->price_id)->exists()){

          ClientPrice::create([

            'client_id' => $client->id,
            'client_name' => $clientName,
            'price_id' => $request->price_id,
            'price_name' => $price->find($request->price_id)->name

          ]);

        }

        // get the client price
        $clientprice = ClientPrice::where('client_id', $client->id)->select('price_id', 'price_name')->get();

        // get the client contacts 
        $clientcontact = ClientContact::where('client_id', $client->id)->get();


        return response()->json([
          "status" => "success",
          "data" => [

            'client' => $client,
            'clientcontact' => $clientcontact,
            'clientprice' => $clientprice

          ]
        ], 201);
    }

 
    public function show($id)
    {

        $client = Client::find($id);

        if(! $client){

            return response()->json([
              "status" => "error",
              "errors" => "Client Not Found"
            ]);

        }

        $clientprice = ClientPrice::where('client_id', $client->id)->select('price_id', 'price_name')->get();

        $clientcontact = ClientContact::where('client_id', $client->id)->get();

        $clientbills = Bill::where('client_id', $client->id)->orderBy('id', 'DESC')->get();

        return response()->json([
          "status" => "success",
          "data" => [

            'client' => $client,
            'clientcontact' => $clientcontact,
            'clientprice' => $clientprice,
            'ClientBills' => $clientbills

          ]
        ], 200);


    }



    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if(! $client){

            return response()->json([
              "status" => "error",
              "errors" => "Client Not Found"
            ]);

        }

        $price = new Price;
        $rules = [
            'type' => 'required',
            'trade_name' => "required_if:type,business|unique:clients,trade_name,$id",
            'full_name' => "required_if:type,individual|unique:clients,full_name,$id",
            'first_name' => 'required_if:type,business',
            'last_name' => 'required_if:type,business',
            'postal_code' => 'integer',
            'secondary_address' => 'Boolean',
            'secondary_address1' => 'required_if:secondary_address,1',
            'secondary_address2' => 'required_if:secondary_address,1',
            'sec_city' => 'required_if:secondary_address,1',
            'sec_state' => 'required_if:secondary_address,1',
            'sec_country' => 'required_if:secondary_address,1',
            'sec_postal_code' => 'required_if:secondary_address,1|integer',
            'code_num' => "required|integer|unique:clients,code_num,$id",
            'email' => "required|email|unique:clients,email,$id",
            'contacts.*.contact_email' => "email",
            'contacts.*.contact_telephone' => 'integer',
            'contacts.*.contact_mobile' => 'integer',
            'send_data' => 'Boolean|required_if:invoicing_method,send via email',
            'price_id' => [

              Rule::exists($price->getTable(),$price->getKeyName()),

            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $client->update([
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
          'language' => $request->language,
          'send_data' => $request->send_data,
          'employee_id' => Auth::id(),
          'tag' => $request->tag
        ]);

        ClientContact::where('client_id', $client->id)->delete();

        $contacts = $request->contacts;

        foreach ((array) $contacts as $contact) {

          ClientContact::create([

            'client_id' => $client->id,
            'contact_Fname' => isset($contact['contact_Fname'])? $contact['contact_Fname'] : null,
            'contact_Lname' => isset($contact['contact_Lname'])? $contact['contact_Lname'] : null ,
            'contact_email' => isset($contact['contact_email'])? $contact['contact_email'] : null,
            'contact_telephone' => isset($contact['contact_telephone'])? $contact['contact_telephone'] : null,
            'contact_mobile' => isset($contact['contact_mobile'])? $contact['contact_mobile'] : null
          ]);

        }


        ClientPrice::where('client_id', $client->id)->delete();

        $type = $client->type;
        switch($type){
          case "business": 
            $clientName = Client::find($client->id)->trade_name;
          break;
          case "individual":
            $clientName = Client::find($client->id)->full_name;
          break;
        }


        if($price->where('id', $request->price_id)->exists()){

          ClientPrice::create([

            'client_id' => $client->id,
            'client_name' => $clientName,
            'price_id' => $request->price_id,
            'price_name' => $price->find($request->price_id)->name

          ]);

        }


        $clientcontact = ClientContact::where('client_id', $client->id)->get();

        $clientprice = ClientPrice::where('client_id', $client->id)->select('price_id', 'price_name')->get();



        return response()->json([
          "status" => "success",
          "data" => [

            'client' => $client,
            'clientcontact' => $clientcontact,
            'clientprice' => $clientprice

          ]
        ], 200);
    }



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


    public function contactList(){
      

        $clients = Client::select('first_name', 'last_name', 'trade_name', 'mobile', 'telephone', 'code_num', 'email')->get();


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
