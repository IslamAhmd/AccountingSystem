<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Price;
use App\Repo;
use App\Client;
use Image;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prices = Price::get();

        return response()->json([
          "status" => "success",
          "data" => $prices
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
            'price_num' => 'required|unique:prices|integer',
            'price_date' => 'required|date',
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

        $price = new Price;
        $price->client_id = $request->client_id;
        $price->client_name = Client::where('id', $request->client_id)->first()->trade_name;
        $price->way = $request->way;
        $price->price_num = $request->price_num;
        $price->price_date = $request->price_date;
        $price->discount = $request->discount;
        $price->discount_type = $request->discount_type;
        if($request->hasFile('file')){
            $photo = $request->file('file');
            $file_name = time() . '-' . $photo->getClientOriginalName();
            $location = public_path('images/prices/' . $file_name);

            Image::make($photo)->resize(200,200)->save($location);
            $price->file = $file_name;
        }

        $price->shipment_costs = $request->shipment_costs;
        $price->repo_id = $request->repo_id;
        $price->repo_name = Repo::where('id', $request->repo_id)->first()->name;
        $price->save();

        return response()->json([
          "status" => "success",
          "data" => $price
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
        $price = Price::find($id);

        if(! $price){
            return response()->json([
              "status" => "error",
              "errors" => "Price Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $price
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
        $price = Price::find($id);

        if(! $price){
            return response()->json([
              "status" => "error",
              "errors" => "Price Not Found"
            ]);

        }

        $rules = [
            'client_id' => 'required|integer',
            'way' => 'required',
            'price_num' => "required|unique:prices,price_num,$id|integer",
            'price_date' => 'required|date',
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

        $price->client_id = $request->client_id;
        $price->client_name = Client::where('id', $request->client_id)->first()->trade_name;
        $price->way = $request->way;
        $price->price_num = $request->price_num;
        $price->price_date = $request->price_date;
        $price->discount = $request->discount;
        $price->discount_type = $request->discount_type;
        if($request->hasFile('file')){
            $path = public_path() . "/images/prices/" . $price->file;
            unlink($path);
            $photo = $request->file('file');
            $file_name = time() . '-' . $photo->getClientOriginalName();
            $location = public_path('images/prices/' . $file_name);

            Image::make($photo)->resize(200,200)->save($location);
            $price->file = $file_name;
        }

        $price->shipment_costs = $request->shipment_costs;
        $price->repo_id = $request->repo_id;
        $price->repo_name = Repo::where('id', $request->repo_id)->first()->name;
        $price->save();


        return response()->json([
          "status" => "success",
          "data" => $price
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
        $price = Price::find($id);

        if(! $price){
            return response()->json([
              "status" => "error",
              "errors" => "Price Not Found"
            ]);

        }

        $price->delete();

        return response()->json([
          "status" => "success",
          "message" => "Price deleted Successfully"
        ]);
    }
}
