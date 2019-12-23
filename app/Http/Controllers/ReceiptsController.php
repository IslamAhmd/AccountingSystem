<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receipt;
use App\Employee;
use Validator;
use Image;

class ReceiptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = Receipt::get();

        return response()->json([
          "status" => "success",
          "data" => $receipts
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
            'amount' => 'required|integer',
            'type' => 'required',
            'desc' => 'required',
            'file' => 'required|image|mimes:jpg,png,jpeg',
            'code_num' => 'required|unique:receipts|integer',
            'date' => 'required|date',
            'employee_id' => 'required|integer',
            'category' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $receipt = new Receipt;
        $receipt->amount = $request->amount;
        $receipt->type = $request->type;
        $receipt->desc = $request->desc;
        if($request->hasFile('file')){
            $photo = $request->file('file');
            $filename = time() . '-' . $photo->getClientOriginalName();
            $location = public_path('images/receipts/' . $filename);

            Image::make($photo)->resize(200,200)->save($location);
            $receipt->file = $filename; 
        }
        $receipt->code_num = $request->code_num;
        $receipt->date = $request->date;
        $receipt->employee_id = $request->employee_id;
        $receipt->employee_name = Employee::where('id', $request->employee_id)->first()->name;
        $receipt->category = $request->category;
        $receipt->save();

        return response()->json([
          "status" => "success",
          "data" => $receipt
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
        $receipt = Receipt::find($id);
        if(! $receipt){
            return response()->json([
              "status" => "error",
              "errors" => "Receipt Not Found"
            ]);

        }

        return response()->json([
          "status" => "success",
          "data" => $receipt
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
        $receipt = Receipt::find($id);
        if(! $receipt){
            return response()->json([
              "status" => "error",
              "errors" => "Receipt Not Found"
            ]);

        }

        $rules = [
            'amount' => 'required|integer',
            'type' => 'required',
            'desc' => 'required',
            'file' => 'required|image|mimes:jpg,png,jpeg',
            'code_num' => "required|unique:receipts,code_num,$id|integer",
            'date' => 'required|date',
            'employee_id' => 'required|integer',
            'category' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $receipt->amount = $request->amount;
        $receipt->type = $request->type;
        $receipt->desc = $request->desc;
        if($request->hasFile('file')){

            $path = public_path() . "/images/receipts/" . $receipt->file;
            unlink($path);

            $photo = $request->file('file');
            $filename = time() . '-' . $photo->getClientOriginalName();
            $location = public_path('images/receipts/' . $filename);

            Image::make($photo)->resize(200,200)->save($location);
            $receipt->file = $filename; 
        }
        $receipt->code_num = $request->code_num;
        $receipt->date = $request->date;
        $receipt->employee_id = $request->employee_id;
        $receipt->employee_name = Employee::where('id', $request->employee_id)->first()->name;
        $receipt->category = $request->category;
        $receipt->save();

        return response()->json([
          "status" => "success",
          "data" => $receipt
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
        $receipt = Receipt::find($id);
        if(! $receipt){
            return response()->json([
              "status" => "error",
              "errors" => "Receipt Not Found"
            ]);

        }

        $path = public_path() . "/images/receipts/" . $receipt->file;
        unlink($path);
        $receipt->delete();


        return response()->json([
          "status" => "success",
          "message" => "Receipt deleted Successfully"
        ]);
    }
}
