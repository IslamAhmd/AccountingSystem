<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Validator;
use App\PriceService;
use App\ServiceTax;
use Illuminate\Validation\Rule;
use App\Supplier;
use App\Price;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::get();

        $services_ids = $services->pluck('id');

        $priceservices = PriceService::whereIn('service_id', $services_ids)->get(['service_id', 'price_id', 'price_name']);

        $servicetaxes = ServiceTax::whereIn('service_id', $services_ids)->get(['service_id', 'tax_id', 'tax_name']);

        return response()->json([
          "status" => "success",
          "data" => [

            'services' => $services,
            'priceservices' => $priceservices,
            'servicetaxes' => $servicetaxes

          ]
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
        $supplier = new Supplier;
        $price = new Price;
        $tax = new Tax;

        $rules = [
            'name' => 'required|unique:services',
            'desc' => 'required',
            'unit_price' => 'required|integer',
            'purchase_price' => 'required|integer',
            'service_code' => 'required|unique:services',
            'category' => 'required',
            'notes' => 'required',
            'disabled' => 'boolean',
            'tag' => 'required',
            'supplier_id' => [
              'required',
              Rule::exists($supplier->getTable(), $supplier->getKeyName())
            ],
            'price_id' => [
              'required',
              Rule::exists($price->getTable(), $price->getKeyName())
            ],
            'taxes.*.tax' => [

              Rule::exists($tax->getTable(), $tax->getKeyName())
            ],
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $service = Service::create($request->except(['taxes', 'price_id']));


        $taxes = $request->taxes;
        // return $taxes;
        foreach((array) $taxes as $ta){
          // return $ta['tax'];
          ServiceTax::create([

              'service_id' => $service->id,
              'service_name' => $service->name,
              'tax_id' => $ta['tax'],
              'tax_name' => Tax::where('id', $ta['tax'])->first()->name

          ]);
        }



        $ids = ServiceTax::where('service_id', $service->id)->pluck('tax_id');
        
        $values = Tax::find($ids, ['value']);
        
        $taxesVales = 0;
        for($i = 0; $i < count($values); $i++){ 
          
          $taxesVales += ( ($values[$i]['value']/100) * $service->unit_price );

        }

        $service->unit_price = $service->unit_price + $taxesVales;
  

        $service->supplier_name = $supplier->where('id', $service->supplier_id)->first()->trade_name;

        if($service->disabled === '1') {

          $service->status = "غير نشط";

        }
        $service->save();

        PriceService::create([

          'service_id' => $service->id,
          'service_name' => $service->name,
          'price_id' => $request->price_id,
          'price_name' => $price->where('id', $request->price_id)->first()->name

        ]);

        $servicetax = ServiceTax::where('service_id', $service->id)->get(['tax_id', 'tax_name']);
        
         
        $priceservice = PriceService::where('service_id', $service->id)->first(['price_id', 'price_name']);

        return response()->json([
          "status" => "success",
          "data" => [
            'service' => $service,
            'servicetaxes' => $servicetax,
            'serviceprice' => $priceservice
          ]
        ], 201);

    }

    public function show($id){

      $service = Service::find($id);

      if (! $service) {
        
          return response()->json([
              "status" => "error",
              "errors" => "Service Not Found"
          ]);

      }

      $servicetax = ServiceTax::where('service_id', $service->id)->get(['tax_id', 'tax_name']);
        
         
      $priceservice = PriceService::where('service_id', $service->id)->first(['price_id', 'price_name']);

      return response()->json([
          "status" => "success",
          "data" => [

            'service' => $service,
            'servicetaxes' => $servicetax,
            'serviceprice' => $priceservice
          ]
      ], 200);
    }

    public function update(Request $request, $id){

        $service = Service::find($id);

          if (! $service) {
        
            return response()->json([
              "status" => "error",
              "errors" => "Service Not Found"
            ]);

          }

        $supplier = new Supplier;
        $price = new Price;
        $tax = new Tax;

        $rules = [
            'name' => "required|unique:services,name,$id",
            'desc' => 'required',
            'unit_price' => 'required|integer',
            'purchase_price' => 'required|integer',
            'service_code' => "required|unique:services,service_code,$id",
            'category' => 'required',
            'notes' => 'required',
            'disabled' => 'boolean',
            'tag' => 'required',
            'supplier_id' => [
              'required',
              Rule::exists($supplier->getTable(), $supplier->getKeyName())
            ],
            'price_id' => [
              'required',
              Rule::exists($price->getTable(), $price->getKeyName())
            ],
            'taxes.*.tax' => [

              Rule::exists($tax->getTable(), $tax->getKeyName())
            ],
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $service->update($request->except(['taxes', 'price_id']));

        $servicetax = ServiceTax::where('service_id', $service->id)->delete();
        
         
        $priceservice = PriceService::where('service_id', $service->id)->delete();


        $taxes = $request->taxes;
        // return $taxes;
        foreach((array) $taxes as $ta){
          // return $ta['tax'];
          ServiceTax::create([

              'service_id' => $service->id,
              'service_name' => $service->name,
              'tax_id' => $ta['tax'],
              'tax_name' => Tax::where('id', $ta['tax'])->first()->name

          ]);
        }



        $ids = ServiceTax::where('service_id', $service->id)->pluck('tax_id');
        
        $values = Tax::find($ids, ['value']);
        
        $taxesVales = 0;
        for($i = 0; $i < count($values); $i++){ 
          
          $taxesVales += ( ($values[$i]['value']/100) * $service->unit_price );

        }

        $service->unit_price = $service->unit_price + $taxesVales;
  

        $service->supplier_name = $supplier->where('id', $service->supplier_id)->first()->trade_name;

        if($service->disabled === '1') {

          $service->status = "غير نشط";

        }
        $service->save();

        PriceService::create([

          'service_id' => $service->id,
          'service_name' => $service->name,
          'price_id' => $request->price_id,
          'price_name' => $price->where('id', $request->price_id)->first()->name

        ]);

        $servicetax = ServiceTax::where('service_id', $service->id)->get(['tax_id', 'tax_name']);
        
         
        $priceservice = PriceService::where('service_id', $service->id)->first(['price_id', 'price_name']);

        return response()->json([
          "status" => "success",
          "data" => [
            'service' => $service,
            'servicetaxes' => $servicetax,
            'serviceprice' => $priceservice
          ]
        ], 201);

    }

    public function destroy(){

          $service = Service::find($id);

          if (! $service) {
        
            return response()->json([
              "status" => "error",
              "errors" => "Service Not Found"
            ]);

          }

          $service->delete();

          return response()->json([
            "status" => "success",
            "message" => "Service deleted Successfully"
          ]);
    }
}
