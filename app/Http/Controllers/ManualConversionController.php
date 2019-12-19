<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ManConversion;
use Validator;
use App\Repo;

class ManualConversionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $convs = ManConversion::get();

        return response()->json([
          "status" => "success",
          "data" => $convs
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
            'from_repo_id' => 'required|integer',
            'to_repo_id' => 'required|integer',
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

        $conv = ManConversion::create([
            'from_repo_id' => $request->from_repo_id,
            'to_repo_id' => $request->to_repo_id,
            'from_repo_name' => Repo::where('id', $request->from_repo_id)->first()->name,
            'to_repo_name' => Repo::where('id', $request->to_repo_id)->first()->name,
            'purchase_num' => $request->purchase_num,
            'notes' => $request->notes
        ]);

        return response()->json([
          "status" => "success",
          "data" => $conv
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
        $conv = ManConversion::find($id);
        if(! $conv){
            return response()->json([
              "status" => "error",
              "errors" => "Convertion Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $conv
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
        $conv = ManConversion::find($id);

        if(! $conv){
            return response()->json([
              "status" => "error",
              "errors" => "Convertion Not Found"
            ]);

        }

        $rules = [
            'from_repo_id' => 'required|integer',
            'to_repo_id' => 'required|integer',
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

        $conv->update([
            'from_repo_id' => $request->from_repo_id,
            'to_repo_id' => $request->to_repo_id,
            'from_repo_name' => Repo::where('id', $request->from_repo_id)->first()->name,
            'to_repo_name' => Repo::where('id', $request->to_repo_id)->first()->name,
            'purchase_num' => $request->purchase_num,
            'notes' => $request->notes
        ]);

        return response()->json([
          "status" => "success",
          "data" => $conv
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
        $conv = ManConversion::find($id);

        if(! $conv){
            return response()->json([
              "status" => "error",
              "errors" => "Convertion Not Found"
            ]);

        }

        $conv->delete();

        return response()->json([
          "status" => "success",
          "message" => "Convertion deleted Successfully"
        ]);

    }
}
