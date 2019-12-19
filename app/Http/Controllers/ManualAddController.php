<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ManAddition;
use App\Repo;
use Validator;


class ManualAddController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adds = ManAddition::get();

        return response()->json([
          "status" => "success",
          "data" => $adds
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
            'repo_id' => 'required|integer',
            'purchase_num' => 'required|integer',
            'notes' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $add = ManAddition::create([
            'repo_id' => $request->repo_id,
            'repo_name' => Repo::where('id', $request->repo_id)->first()->name,
            'purchase_num' => $request->purchase_num,
            'notes' => $request->notes
        ]);

        return response()->json([
          "status" => "success",
          "data" => $add
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
        $add = ManAddition::find($id);
        if(! $add){
            return response()->json([
              "status" => "error",
              "errors" => "Addition Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $add
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
        $add = ManAddition::find($id);

        if(! $add){
            return response()->json([
              "status" => "error",
              "errors" => "Addition Not Found"
            ]);

        }

        $rules = [
            'repo_id' => 'required|integer',
            'purchase_num' => 'required|integer',
            'notes' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $add->update([
            'repo_id' => $request->repo_id,
            'repo_name' => Repo::where('id', $request->repo_id)->first()->name,
            'purchase_num' => $request->purchase_num,
            'notes' => $request->notes
        ]);

        return response()->json([
          "status" => "success",
          "data" => $add
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
        $add = ManAddition::find($id);

        if(! $add){
            return response()->json([
              "status" => "error",
              "errors" => "Addition Not Found"
            ]);

        }

        $add->delete();

        return response()->json([
          "status" => "success",
          "message" => "Addition deleted Successfully"
        ]);
    }
}
