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
            'paid' => 'required|boolean',
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

        // $filename = null;
        $photo = $request->file('file');
        $filename = time().'-'. $photo->getClientOriginalName();
        $location = public_path('images/'. $filename);
            
        Image::make($photo)->resize(200, 200)->save($location);



        $bill = Bill::create([
            'client_id' => $request->client_id,
            'client_name' => Client::where('id', $request->client_id)->first()->trade_name,
            'way' => $request->way,
            'bill_num' => $request->bill_num,
            'employee_id' => $request->employee_id,
            'employee_name' => Employee::where('id', $request->employee_id)->first()->name,
            'billdate' => $request->billdate,
            'releasedate' => $request->releasedate,
            'payment_conditions' => $request->payment_conditions,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'payment' => $request->payment,
            'payment_type' => $request->payment_type,
            'file' => $filename,
            'paid' => $request->paid,
            'shipment_costs' => $request->shipment_costs,
            'repo_id' => $request->repo_id,
            'repo_name' => Repo::where('id', $request->repo_id)->first()->name
        ]);

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
        //
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
