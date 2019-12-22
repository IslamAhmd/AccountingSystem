<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill;
use App\Repo;
use App\Client;
use App\Employee;
use Validator;
use Image;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bill::get();

        return response()->json([
          "status" => "success",
          "data" => $bills
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
            'bill_num' => 'required|unique:bills',
            'employee_id' => 'required|integer',
            'billdate' => 'required|date',
            'releasedate' => 'required|date',
            'payment_conditions' => 'required|integer',
            'discount' => 'required|integer',
            'discount_type' => 'required',
            'payment' => 'required|integer',
            'payment_type' => 'required',
            'file' => 'required|image|mimes:jpg,png,jpeg',
            'paid' => 'boolean',
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
  

        $bill = new Bill;
        $bill->client_id = $request->client_id;
        $bill->client_name = Client::where('id', $request->client_id)->first()->trade_name;
        $bill->way = $request->way;
        $bill->bill_num = $request->bill_num;
        $bill->employee_id = $request->employee_id;
        $bill->employee_name = Employee::where('id', $request->employee_id)->first()->name;
        $bill->billdate = $request->billdate;
        $bill->releasedate = $request->releasedate;
        $bill->payment_conditions = $request->payment_conditions;
        $bill->discount = $request->discount;
        $bill->discount_type = $request->discount_type;
        $bill->payment = $request->payment;
        $bill->payment_type = $request->payment_type;
        if($request->hasFile('file')){
            $photo = $request->file('file');
            $filename = time().'-'. $photo->getClientOriginalName();
            $location = public_path('images/bills/'. $filename);
            
            Image::make($photo)->resize(200, 200)->save($location);
            $bill->file = $filename;
        }
        $bill->paid = $request->paid;
        $bill->shipment_costs = $request->shipment_costs;
        $bill->repo_id = $request->repo_id;
        $bill->repo_name = Repo::where('id', $request->repo_id)->first()->name;
        $bill->save();

        // return $request->all();



        return response()->json([
          "status" => "success",
          "data" => $bill
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
        $bill = Bill::find($id);
        if(! $bill){
            return response()->json([
              "status" => "error",
              "errors" => "Bill Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $bill
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
        $bill = Bill::find($id);

        if(! $bill){
            return response()->json([
              "status" => "error",
              "errors" => "Bill Not Found"
            ]);

        }


        $rules = [
            'client_id' => 'required|integer',
            'way' => 'required',
            'bill_num' => "required|unique:bills,bill_num,$id",
            'employee_id' => 'required|integer',
            'billdate' => 'required|date',
            'releasedate' => 'required|date',
            'payment_conditions' => 'required|integer',
            'discount' => 'required|integer',
            'discount_type' => 'required',
            'payment' => 'required|integer',
            'payment_type' => 'required',
            'file' => 'required|image|mimes:jpg,png,jpeg',
            'paid' => 'boolean',
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
  

        $bill->client_id = $request->client_id;
        $bill->client_name = Client::where('id', $request->client_id)->first()->trade_name;
        $bill->way = $request->way;
        $bill->bill_num = $request->bill_num;
        $bill->employee_id = $request->employee_id;
        $bill->employee_name = Employee::where('id', $request->employee_id)->first()->name;
        $bill->billdate = $request->billdate;
        $bill->releasedate = $request->releasedate;
        $bill->payment_conditions = $request->payment_conditions;
        $bill->discount = $request->discount;
        $bill->discount_type = $request->discount_type;
        $bill->payment = $request->payment;
        $bill->payment_type = $request->payment_type;
        if($request->hasFile('file')){
          // unlink old pic to delete it
            $path = public_path()."/images/bills/".$bill->file;
            unlink($path);
            // add the new one
            $photo = $request->file('file');
            $filename = time().'-'. $photo->getClientOriginalName();
            $location = public_path('images/bills/'. $filename);
            
            Image::make($photo)->resize(200, 200)->save($location);
            $bill->file = $filename;
        }
        $bill->paid = $request->paid;
        $bill->shipment_costs = $request->shipment_costs;
        $bill->repo_id = $request->repo_id;
        $bill->repo_name = Repo::where('id', $request->repo_id)->first()->name;
        $bill->save();

        // return $request->all();



        return response()->json([
          "status" => "success",
          "data" => $bill
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
        $bill = Bill::find($id);

        if(! $bill){

            return response()->json([
              "status" => "error",
              "errors" => "Bill Not Found"
            ]);
        }

        $bill->delete();

        return response()->json([
          "status" => "success",
          "message" => "Bill deleted Successfully"
        ]);
    }
}
