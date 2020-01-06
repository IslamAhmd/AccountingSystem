<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Validator;
use Illuminate\Validation\Rule;
use App\PriceProduct;
use App\ProductTax;
use App\Repo;
use App\Supplier;
use App\Tax;
use App\Price;

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

        $repo = new Repo;
        $supplier = new Supplier;
        $tax = new Tax;
        $price = new Price;

        $rules = [
            'name' => 'required|unique:products',
            'desc' => 'required',
            'selling_price' => 'required|integer',
            'purchase_price' => 'required|integer',
            'product_code' => 'required|unique:products',
            'brand' => 'required',
            'barcode' => 'required|unique:products',
            'category' => 'required',
            'notes' => 'required',
            'repo' => 'Boolean',
            'repo_quantity' => 'required_if:repo,1',
            'repo_id' => [
              'required_if:repo,1',
              Rule::exists($repo->getTable(), $repo->getKeyName())
            ],
            'least_quantity' => 'required_if:repo,1',
            'disabled' => 'Boolean',
            'supplier_id' => [
              'required',
              Rule::exists($supplier->getTable(), $supplier->getKeyName())
            ],
            'tag' => 'required',
            'taxes' => 'required',
            'taxes.*.tax' => [

              Rule::exists($tax->getTable(), $tax->getKeyName())
            ],
            'price_id' => [

                Rule::exists($price->getTable(), $price->getKeyName())

            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }


        $product = Product::create($request->except(['taxes', 'price_id']));


        $taxes = $request->taxes;
        // return $taxes;
        foreach((array) $taxes as $ta){
          // return $ta['tax'];
          ProductTax::create([

              'product_id' => $product->id,
              'product_name' => $product->name,
              'tax_id' => $ta['tax'],
              'tax_name' => Tax::where('id', $ta['tax'])->first()->name,
              'tax_value' => Tax::where('id', $ta['tax'])->first()->value

          ]);
        }



        $ids = ProductTax::where('product_id', $product->id)->pluck('tax_id');
        // return $ids;
        $values = Tax::find($ids, ['value']);
        // return $values[0]['value'];
        $product->selling_price = $product->selling_price + ( ($values[0]['value']/100) * $product->selling_price ) + ( ($values[1]['value']/100) * $product->selling_price );

        $product->supplier_name = $supplier->where('id', $product->supplier_id)->first()->trade_name;

        $product->repo_name = $repo->where('id', $product->repo_id)->first()->name;

        if($product->repo_quantity > $product->least_quantity && $product->disabled === '0'){

          $product->status = "متاح";

        } elseif ($product->repo_quantity === $product->least_quantity && $product->disabled === '0') {
          
          $product->status = "مخزون منخفض";

        } elseif ($product->repo_quantity < $product->least_quantity && $product->disabled === '0') {
          
          $product->status = "مخزون نفذ";

        } elseif ($product->disabled === '1') {

          $product->status = "غير نشط";

        }
        $product->save();


        PriceProduct::create([

          'product_id' => $product->id,
          'product_name' => $product->name,
          'price_id' => $request->price_id,
          'price_name' => $price->where('id', $request->price_id)->first()->name

        ]);

        $producttax = ProductTax::where('product_id', $product->id)->get(['tax_id', 'tax_name']);
        // return $producttax;
         
        $priceproduct = PriceProduct::where('product_id', $product->id)->first(['price_id', 'price_name']);

        return response()->json([
          "status" => "success",
          "data" => [

            'product' => $product,
            'producttaxes' => $producttax,
            'productprice' => $priceproduct
          ]
        ], 201);
    }

}
