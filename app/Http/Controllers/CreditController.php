<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credit;
use App\Client;
use App\Repo;
use Validator;
use Image;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $credits = Credit::get();

        return response()->json([
          "status" => "success",
          "data" => $credits
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
            'client_id' => 'required|integer',
            'way' => 'required',
            'credit_date' => 'required|date',
            'release_date' => 'required|date',
            'discount' => 'required|integer',
            'discount_type' => 'required',
            'file' => 'required|image|mimes:jpg,png,jpeg',
            'shipment_costs' => 'required|integer',
            'repo_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);
        }      

        $credit = new Credit;
        $credit->client_id = $request->client_id;
        $credit->client_name = Client::where('id', $request->client_id)->first()->trade_name;
        $credit->way = $request->way;
        $credit->credit_date = $request->credit_date;
        $credit->release_date = $request->release_date;
        $credit->discount = $request->discount;
        $credit->discount_type = $request->discount_type;
        if($request->hasFile('file')){
            $photo = $request->file('file');
            $filename = time() . '-' . $photo->getClientOriginalName();
            $location = public_path('images/credits/'. $filename);

            Image::make($photo)->resize(200,200)->save($location);
            $credit->file = $filename;
        }

        $credit->shipment_costs = $request->shipment_costs;
        $credit->repo_id = $request->repo_id;
        $credit->repo_name = Repo::where('id', $request->repo_id)->first()->name;
        $credit->save();

        return response()->json([
          "status" => "success",
          "data" => $credit
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
        $credit = Credit::find($id);
        if(! $credit){
            return response()->json([
              "status" => "error",
              "errors" => "Credit Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $credit
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
        $credit = Credit::find($id);
        if(! $credit){
            return response()->json([
              "status" => "error",
              "errors" => "Credit Not Found"
            ]);

        }

        $rules = [
            'client_id' => 'required|integer',
            'way' => 'required',
            'credit_date' => 'required|date',
            'release_date' => 'required|date',
            'discount' => 'required|integer',
            'discount_type' => 'required',
            'file' => 'required|image|mimes:jpg,png,jpeg',
            'shipment_costs' => 'required|integer',
            'repo_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);
        } 

        $credit->client_id = $request->client_id;
        $credit->client_name = Client::where('id', $request->client_id)->first()->trade_name;
        $credit->way = $request->way;
        $credit->credit_date = $request->credit_date;
        $credit->release_date = $request->release_date;
        $credit->discount = $request->discount;
        $credit->discount_type = $request->discount_type;
        if($request->hasFile('file')){

            $path = public_path() . "/images/credits/" . $credit->file;
            unlink($path);

            $photo = $request->file('file');
            $filename = time() . '-' . $photo->getClientOriginalName();
            $location = public_path('images/credits/'. $filename);

            Image::make($photo)->resize(200,200)->save($location);
            $credit->file = $filename;
        }

        $credit->shipment_costs = $request->shipment_costs;
        $credit->repo_id = $request->repo_id;
        $credit->repo_name = Repo::where('id', $request->repo_id)->first()->name;
        $credit->save();

        return response()->json([
          "status" => "success",
          "data" => $credit
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
        $credit = Credit::find($id);
        if(! $credit){
            return response()->json([
              "status" => "error",
              "errors" => "Credit Not Found"
            ]);

        }

        $credit->delete();

        return response()->json([
          "status" => "success",
          "message" => "Credit deleted Successfully"
        ]);
    }
}
