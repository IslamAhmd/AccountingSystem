<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use Validator;

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

        return response()->json([
          "status" => "success",
          "data" => $suppliers
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
            'governorate' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'city' => 'required',
            'currency' => 'required',
            'balance' => 'required|integer',
            'balance_date' => 'required|date',
            'email' => 'required|email|unique:suppliers',
            'notes' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ], 400);

        }

        $supplier = Supplier::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $supplier
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

        return response()->json([
          "status" => "success",
          "data" => $supplier
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

        $supplier->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $supplier
        ], 200);
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