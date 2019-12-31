<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DateAction;
use Validator;

class DateActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = DateAction::get();

        return response()->json([
            "status" => "Success",
            "data" => $actions 
        ]);
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
            "name" => "required|unique:date_actions"
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $action = DateAction::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $action
        ], 201);


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
        $action = DateAction::find($id);

        $rules = [
            "name" => "required|unique:date_actions,name,$id"
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $action->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $action
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
        $action = DateAction::find($id);
        
        $action->delete();

        return response()->json([
          "status" => "success",
          "message" => "Action deleted Successfully"
        ]);

    }
}
