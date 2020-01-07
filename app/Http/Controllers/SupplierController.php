<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Supplier;
use Validator;
use App\SupplierContact;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::get();

        $suppliers_ids = $suppliers->pluck('id');

        $suppliercontacts = SupplierContact::whereIn('supplier_id', $suppliers_ids)->get();

        return response()->json([
          "status" => "success",
          "data" => [

            'suppliers' => $suppliers,
            'supplierscontacts' => $suppliercontacts

          ]
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'trade_name' => 'required|unique:suppliers',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|integer',
            'phone' => 'required|integer',
            'first_address' => 'required',
            'sec_address' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'city' => 'required',
            'currency' => 'required',
            'opening_balance' => 'required|integer',
            'opening_balance_date' => 'required|date',
            'email' => 'required|email|unique:suppliers',
            'notes' => 'required',
            'secondary_address' => 'Boolean',
            'secondary_address1' => 'required_if:secondary_address,1',
            'secondary_address2' => 'required_if:secondary_address,1',
            'sec_city' => 'required_if:secondary_address,1',
            'sec_state' => 'required_if:secondary_address,1',
            'sec_country' => 'required_if:secondary_address,1',
            'sec_postal_code' => 'required_if:secondary_address,1|integer',
        ];


        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $supplier = Supplier::create($request->except(['emp_name', 'contacts']));
        $supplier->emp_name = Auth()->user()->name;
        $supplier->save();

        $contacts = $request->contacts;
        foreach ((array) $contacts as $contact) {

          SupplierContact::create([

            'supplier_id' => $supplier->id,
            'contact_Fname' => isset($contact['contact_Fname'])? $contact['contact_Fname'] : null,
            'contact_Lname' => isset($contact['contact_Lname'])? $contact['contact_Lname'] : null ,
            'contact_email' => isset($contact['contact_email'])? $contact['contact_email'] : null,
            'contact_telephone' => isset($contact['contact_telephone'])? $contact['contact_telephone'] : null,
            'contact_mobile' => isset($contact['contact_mobile'])? $contact['contact_mobile'] : null
          ]);

        }

        $suppliercontact = SupplierContact::where('supplier_id', $supplier->id)->get();


        return response()->json([
          "status" => "success",
          "data" => [

            'supplier' => $supplier,
            'suppliercontact' => $suppliercontact

          ]
        ], 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);

        if(! $supplier){
            return response()->json([
              "status" => "error",
              "errors" => "Supplier Not Found"
            ]);
        }

        $suppliercontact = SupplierContact::where('supplier_id', $supplier->id)->get();


        return response()->json([
          "status" => "success",
          "data" => [

            'supplier' => $supplier,
            'suppliercontact' => $suppliercontact

          ]
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);

        if(! $supplier){
            return response()->json([
              "status" => "error",
              "errors" => "Supplier Not Found"
            ]);
        }

        $rules = [
            'trade_name' => "required|unique:suppliers,trade_name,$id",
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|integer',
            'phone' => 'required|integer',
            'first_address' => 'required',
            'sec_address' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'city' => 'required',
            'currency' => 'required',
            'opening_balance' => 'required|integer',
            'opening_balance_date' => 'required|date',
            'email' => "required|email|unique:suppliers,email,$id",
            'notes' => 'required',
            'secondary_address' => 'Boolean',
            'secondary_address1' => 'required_if:secondary_address,1',
            'secondary_address2' => 'required_if:secondary_address,1',
            'sec_city' => 'required_if:secondary_address,1',
            'sec_state' => 'required_if:secondary_address,1',
            'sec_country' => 'required_if:secondary_address,1',
            'sec_postal_code' => 'required_if:secondary_address,1|integer',
        ];


        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }


        $supplier->update($request->except(['emp_name','contacts']));
        $supplier->emp_name = Auth()->user()->name;
        $supplier->save();


        SupplierContact::where('supplier_id', $supplier->id)->delete();


        $contacts = $request->contacts;
        foreach ((array) $contacts as $contact) {

          SupplierContact::create([

            'supplier_id' => $supplier->id,
            'contact_Fname' => isset($contact['contact_Fname'])? $contact['contact_Fname'] : null,
            'contact_Lname' => isset($contact['contact_Lname'])? $contact['contact_Lname'] : null ,
            'contact_email' => isset($contact['contact_email'])? $contact['contact_email'] : null,
            'contact_telephone' => isset($contact['contact_telephone'])? $contact['contact_telephone'] : null,
            'contact_mobile' => isset($contact['contact_mobile'])? $contact['contact_mobile'] : null
          ]);

        }

        $suppliercontact = SupplierContact::where('supplier_id', $supplier->id)->get();


        return response()->json([
          "status" => "success",
          "data" => [

            'supplier' => $supplier,
            'suppliercontact' => $suppliercontact

          ]
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        
        if(! $supplier){
            return response()->json([
              "status" => "error",
              "errors" => "Supplier Not Found"
            ]);

        }

        $supplier->delete();

        return response()->json([
          "status" => "success",
          "message" => "Supplier deleted Successfully"
        ]);

    }
}
