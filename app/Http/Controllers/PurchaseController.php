<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Supplier;
use Validator;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::get();

        return response()->json([
          "status" => "success",
          "data" => $purchases
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
            'supplier_id' => 'required',
            'purchase_num' => 'required|unique:purchases|integer',
            'date' => 'required|date',
            'payment_conditions' => 'required|integer',
            'discount' => 'required|integer',
            'discount_type' => 'required',
            'payment' => 'required|integer',
            'payment_type' => 'required',
            'paymeny_check' => 'required|boolean',
            'received' => 'required|boolean'

        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $purchase = Purchase::create([
            'supplier_id' => $request->supplier_id,
            'supplier_name' => Supplier::where('id', $request->supplier_id)->first()->trade_name,
            'purchase_num' => $request->purchase_num,
            'date' => $request->date,
            'payment_conditions' => $request->payment_conditions,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'payment' => $request->payment,
            'payment_type' => $request->payment_type,
            'paymeny_check' => $request->paymeny_check,
            'received' => $request->received,
            'pay_way' => $request->pay_way,
            'pay_id' => $request->pay_id
        ]);

        return response()->json([
          "status" => "success",
          "data" => $purchase
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
        $purchase = Purchase::find($id);
        if(! $purchase){
            return response()->json([
              "status" => "error",
              "errors" => "purchase Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $purchase
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
        $purchase = Purchase::find($id);

        if(! $purchase){

            return response()->json([
              "status" => "error",
              "errors" => "Purchase Not Found"
            ]);

        }


        $rules = [
            'supplier_id' => 'required',
            'purchase_num' => "required|unique:purchases,purchase_num,$id|integer",
            'date' => 'required|date',
            'payment_conditions' => 'required|integer',
            'discount' => 'required|integer',
            'discount_type' => 'required',
            'payment' => 'required|integer',
            'payment_type' => 'required',
            'paymeny_check' => 'required|boolean',
            'received' => 'required|boolean'

        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $purchase->update([
            'supplier_id' => $request->supplier_id,
            'supplier_name' => Supplier::where('id', $request->supplier_id)->first()->trade_name,
            'purchase_num' => $request->purchase_num,
            'date' => $request->date,
            'payment_conditions' => $request->payment_conditions,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'payment' => $request->payment,
            'payment_type' => $request->payment_type,
            'paymeny_check' => $request->paymeny_check,
            'received' => $request->received,
            'pay_way' => $request->pay_way,
            'pay_id' => $request->pay_id
        ]);

        return response()->json([
          "status" => "success",
          "data" => $purchase
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
        $purchase = Purchase::find($id);

        if(! $purchase){

            return response()->json([
              "status" => "error",
              "errors" => "Purchase Not Found"
            ]);

        }

        $purchase->delete();

        return response()->json([
          "status" => "success",
          "message" => "Purchase deleted Successfully"
        ]); 
    }
}
