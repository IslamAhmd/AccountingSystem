<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();

        return response()->json([
          "status" => "success",
          "data" => $products
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
            'name' => 'required|unique:products',
            'desc' => 'required',
            'selling_price' => 'required|integer',
            'first_tax' => 'required|integer',
            'sec_tax' => 'required|integer',
            'purchase_price' => 'required|integer',
            'product_code' => 'required|unique:products',
            'brand' => 'required',
            'barcode' => 'required|unique:products',
            'category' => 'required',
            'notes' => 'required',
            'repo' => 'required|boolean',
            'disabled' => 'required|boolean',
            'repo_quantity' => 'required|integer',
            'least_quantity' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $product = Product::create($request->all());

        return response()->json([
          "status" => "success",
          "data" => $product
        ], 201);
    }

}
