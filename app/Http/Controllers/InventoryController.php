<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Repo;
use Validator;

class InventoryController extends Controller
{
    public function store(Request $request){

    	$rules = [
    		'repo_id' => 'required|integer',
    		'inventory_num' => 'required|unique:inventories|integer',
    		'date' => 'required|date',
    		'notes' => 'required',
    		'discount' => 'required|integer',
            'discount_type' => 'required',
            'payment' => 'required|integer',
            'payment_type' => 'required',
    	];

    	$validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $inventory = Inventory::create([
        	'repo_id' => $request->repo_id,
        	'repo_name' => Repo::where('id', $request->repo_id)->first()->name,
        	'inventory_num' => $request->inventory_num,
        	'date' => $request->date,
        	'notes' => $request->notes,
        	'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'payment' => $request->payment,
            'payment_type' => $request->payment_type
        ]);

        return response()->json([
          "status" => "success",
          "data" => $inventory
        ], 201);
    }
}
