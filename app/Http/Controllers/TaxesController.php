<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tax;
use Validator;

class TaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxes = Tax::get();

        return response()->json([
          "status" => "success",
          "data" => $taxes
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

            'name' => "required|unique:taxes",
            'value' => 'required|integer'

        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $tax = Tax::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $tax
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $tax = Tax::find($id);

        $rules = [

            'name' => "required|unique:taxes,name,$id",
            'value' => 'required|integer'

        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $tax->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $tax
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
        $tax = Tax::find($id);
        
        $tax->delete();

        return response()->json([
          "status" => "success",
          "message" => "Tax deleted Successfully"
        ]); 
    }
}
