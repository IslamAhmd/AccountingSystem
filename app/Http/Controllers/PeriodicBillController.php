<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeriodicBill;
use App\Client;
use App\Repo;
use Image;
use Validator;


class PeriodicBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodics = PeriodicBill::get();

        return response()->json([
          "status" => "success",
          "data" => $periodics
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
            'subscription' => 'required|unique:periodic_bills',
            'release_bill' => 'required|integer',
            'release_bill_type' => 'required',
            'repeat_num' => 'required|integer',
            'first_bill_date' => 'required|date',
            'active' => 'boolean',
            'send_copy' => 'boolean',
            'show_date' => 'boolean',
            'auto_pay' => 'boolean',
            'way' => 'required',
            'client_id' => 'required|integer',
            'payment_conditions' => 'required|integer',
            'discount' => 'required|integer',
            'discount_type' => 'required',
            'payment' => 'required|integer',
            'payment_type' => 'required',
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

        $periodic = new PeriodicBill;
        $periodic->subscription = $request->subscription;
        $periodic->release_bill = $request->release_bill;
        $periodic->release_bill_type = $request->release_bill_type;
        $periodic->repeat_num = $request->repeat_num;
        $periodic->first_bill_date = $request->first_bill_date;
        $periodic->active = $request->active;
        $periodic->send_copy = $request->send_copy;
        $periodic->show_date = $request->show_date;
        $periodic->auto_pay = $request->auto_pay;
        $periodic->way = $request->way;
        $periodic->client_id = $request->client_id;
        $periodic->client_name = Client::where('id', $request->client_id)->first()->trade_name;
        $periodic->payment_conditions = $request->payment_conditions;
        $periodic->discount = $request->discount;
        $periodic->discount_type = $request->discount_type;
        $periodic->payment = $request->payment;
        $periodic->payment_type = $request->payment_type;
        if($request->hasFile('file')){
            $photo = $request->file('file');
            $filename = time() . '-' . $photo->getClientOriginalName();
            $location = public_path('images/PeriodicBills/'. $filename);

            Image::make($photo)->resize(200, 200)->save($location);
            $periodic->file = $filename;
        }
        $periodic->shipment_costs = $request->shipment_costs;
        $periodic->repo_id = $request->repo_id;
        $periodic->repo_name = Repo::where('id', $request->repo_id)->first()->name;
        $periodic->save();

        return response()->json([
          "status" => "success",
          "data" => $periodic
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
        $periodic = PeriodicBill::find($id);
        if(! $periodic){
            return response()->json([
              "status" => "error",
              "errors" => "Periodic Bill Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $periodic
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
        $periodic = PeriodicBill::find($id);
        if(! $periodic){
            return response()->json([
              "status" => "error",
              "errors" => "Periodic Bill Not Found"
            ]);

        }

        $rules = [
            'subscription' => "required|unique:periodic_bills,subscription,$id",
            'release_bill' => 'required|integer',
            'release_bill_type' => 'required',
            'repeat_num' => 'required|integer',
            'first_bill_date' => 'required|date',
            'active' => 'boolean',
            'send_copy' => 'boolean',
            'show_date' => 'boolean',
            'auto_pay' => 'boolean',
            'way' => 'required',
            'client_id' => 'required|integer',
            'payment_conditions' => 'required|integer',
            'discount' => 'required|integer',
            'discount_type' => 'required',
            'payment' => 'required|integer',
            'payment_type' => 'required',
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

        $periodic->subscription = $request->subscription;
        $periodic->release_bill = $request->release_bill;
        $periodic->release_bill_type = $request->release_bill_type;
        $periodic->repeat_num = $request->repeat_num;
        $periodic->first_bill_date = $request->first_bill_date;
        $periodic->active = $request->active;
        $periodic->send_copy = $request->send_copy;
        $periodic->show_date = $request->show_date;
        $periodic->auto_pay = $request->auto_pay;
        $periodic->way = $request->way;
        $periodic->client_id = $request->client_id;
        $periodic->client_name = Client::where('id', $request->client_id)->first()->trade_name;
        $periodic->payment_conditions = $request->payment_conditions;
        $periodic->discount = $request->discount;
        $periodic->discount_type = $request->discount_type;
        $periodic->payment = $request->payment;
        $periodic->payment_type = $request->payment_type;
        if($request->hasFile('file')){

            $path = public_path() . "/images/PeriodicBills/" . $periodic->file;
            unlink($path);

            $photo = $request->file('file');
            $filename = time() . '-' . $photo->getClientOriginalName();
            $location = public_path('images/PeriodicBills/'. $filename);

            Image::make($photo)->resize(200, 200)->save($location);
            $periodic->file = $filename;
        }
        $periodic->shipment_costs = $request->shipment_costs;
        $periodic->repo_id = $request->repo_id;
        $periodic->repo_name = Repo::where('id', $request->repo_id)->first()->name;
        $periodic->save();

        return response()->json([
          "status" => "success",
          "data" => $periodic
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
        $periodic = PeriodicBill::find($id);
        if(! $periodic){
            return response()->json([
              "status" => "error",
              "errors" => "Periodic Bill Not Found"
            ]);

        }

        $path = public_path() . "/images/PeriodicBills/" . $periodic->file;
        unlink($path);
        $periodic->delete();


        return response()->json([
          "status" => "success",
          "message" => "Periodic Bill deleted Successfully"
        ]);
    }
}
