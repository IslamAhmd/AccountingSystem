<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Treasury;
use Validator;

class TreasuryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $treasuries = Treasury::get();

        return response()->json([
          "status" => "success",
          "data" => $treasuries
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
            'name' => 'required|unique:treasuries',
            'desc' => 'required',
            'payment' => 'required|integer',
            'withdraw' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $treasury = Treasury::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $treasury
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
        $treasury = Treasury::find($id);
        if(! $treasury){
            return response()->json([
              "status" => "error",
              "errors" => "Treasury Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $treasury
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
        $treasury = Treasury::find($id);
        if(! $treasury){
            return response()->json([
              "status" => "error",
              "errors" => "Treasury Not Found"
            ]);

        }

        $rules = [
            'name' => "required|unique:treasuries,name,$id",
            'desc' => 'required',
            'payment' => 'required|integer',
            'withdraw' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $treasury->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $treasury
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
        $treasury = Treasury::find($id);
        if(! $treasury){
            return response()->json([
              "status" => "error",
              "errors" => "Treasury Not Found"
            ]);

        }

        $treasury->delete();

        return response()->json([
          "status" => "success",
          "message" => "Treasury deleted Successfully"
        ]);

    }
}
