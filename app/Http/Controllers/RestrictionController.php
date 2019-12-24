<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restriction;
use Validator;

class RestrictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restrictions = Restriction::get();

        return response()->json([
          "status" => "success",
          "data" => $restrictions
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
            'date' => 'required|date',
            'currency' => 'required',
            'restriction_num' => 'required|unique:restrictions|integer',
            'desc' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $restriction = Restriction::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $restriction
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
        $restriction = Restriction::find($id);
        if(! $restriction){
            return response()->json([
              "status" => "error",
              "errors" => "Restriction Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $restriction
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
        $restriction = Restriction::find($id);
        if(! $restriction){
            return response()->json([
              "status" => "error",
              "errors" => "Restriction Not Found"
            ]);

        }

        $rules = [
            'date' => 'required|date',
            'currency' => 'required',
            'restriction_num' => "required|unique:restrictions,restriction_num,$id|integer",
            'desc' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $restriction->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $restriction
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
        $restriction = Restriction::find($id);
        if(! $restriction){
            return response()->json([
              "status" => "error",
              "errors" => "Restriction Not Found"
            ]);

        }

        $restriction->delete();

        return response()->json([
          "status" => "success",
          "message" => "Restriction deleted Successfully"
        ]);
    }
}
