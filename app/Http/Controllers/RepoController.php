<?php

namespace App\Http\Controllers;
use App\Repo;
use Validator;

use Illuminate\Http\Request;

class RepoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repos = Repo::paginate(5);

        return response()->json([
          "status" => "success",
          "data" => $repos
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
            'name' => 'required',
            'location' => 'required',
            'active' => 'boolean',
            'primary' => 'boolean',
            'show' => 'required',
            'bill' => 'required',
            'store' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);
        }

        $repo = Repo::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $repo
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
        $repo = Repo::find($id);

        if(! $repo){
            return response()->json([
              "status" => "error",
              "errors" => "Repo Not Found"
            ]);
        }

        return response()->json([
          "status" => "success",
          "data" => $repo
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
        $repo = Repo::find($id);

        if(! $repo){
            return response()->json([
              "status" => "error",
              "errors" => "Repo Not Found"
            ]);
        }

        $rules = [
            'name' => 'required',
            'location' => 'required',
            'active' => 'boolean',
            'primary' => 'boolean',
            'show' => 'required',
            'bill' => 'required',
            'store' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);
        }

        $repo->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $repo
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
        $repo = Repo::find($id);
        
        if(! $repo){
            return response()->json([
              "status" => "error",
              "errors" => "Repo Not Found"
            ]);

        }

        $repo->delete();

        return response()->json([
          "status" => "success",
          "message" => "Repo deleted Successfully"
        ]);
    }
}






