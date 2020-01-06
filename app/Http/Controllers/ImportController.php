<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Import;
use Validator;
use App\Client;
use App\Employee;
use App\EmployeeImport;
use Illuminate\Validation\Rule;


class ImportController extends Controller
{

    // اوامر الاستيراد
	public function index(){

        $imports = Import::get();

        $imports_id = $imports->pluck('id');

        $employeeimports = EmployeeImport::whereIn('import_id', $imports_id)->select('import_id', 'employee_id', 'employee_name')->get();


		return response()->json([
          "status" => "success",
          "data" => [

            'imports' => $imports,
            'employeeimports' => $employeeimports

          ]
        ], 200);
		
	}


    public function store(Request $request){

        $client = Client::where('id', $request->client_id)->first();

        $employee = new Employee;

    	$rules = [

            'client_id' => [

                'required',
                Rule::exists($client->getTable(), $client->getKeyName())
            ],
    		'name' => 'required|unique:imports',
    		'starts_at' => 'required|date',
    		'ends_at' => 'required|date',
    		'budget' => 'required',
            'budget_type' => 'required',
            'desc' => 'required',
            'tag' => 'required',
    		'shipment_num' => 'required|integer',
    		'container_data' => 'required',
    		'shipment_date' => 'required|date',
    		'arrival_date' => 'required|date',
    		'abstract_name' => 'required',
    		'abstract_num' => 'required|integer',
    		'shipment_location' => 'required',
    		'doc_credit_num' => 'required|integer',
    		'gurantee_letter_num' => 'required|integer',
            'employee' => 'Boolean',
            'employees' => 'required_if:employee,1',
            'employees.*.emp' => [

                Rule::exists($employee->getTable(), $employee->getKeyName())
            ]
    	];


    	$validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }


        $client = Client::where('id', $request->client_id)->first();
        
        $type = $client->type;
        switch($type){
          case "business": 
            $clientName = $client->trade_name;
          break;
          case "individual":
            $clientName = $client->full_name;
          break;
        }


        $import = Import::create($request->except('employees'));

        $import->client_name = $clientName;
        $import->save();

        $employees = $request->employees;
        foreach((array) $employees as $emp){

            EmployeeImport::create([

                'import_id' => $import->id,
                'employee_id' => $emp['emp'],
                'employee_name' => $employee->find($emp['emp'])->name

            ]);

        }

        $employeeimport = $import->employees()->get(['employee_id', 'employee_name']);

    	return response()->json([

          "status" => "success",
          "data" => [
            'import' => $import,
            'employeeimport' => $employeeimport
          ]

        ], 201);

    }

    public function show($id){

        $import = Import::find($id);
        if(! $import){

            return response()->json([
              "status" => "error",
              "errors" => "Import Not Found"
            ]);

        }

        $employeeimport = $import->employees()->get(['employee_id', 'employee_name']);

        return response()->json([

          "status" => "success",
          "data" => [
            'import' => $import,
            'employeeimport' => $employeeimport
          ]

        ], 200);

    }


    public function update(Request $request, $id){

        $import = Import::find($id);
        if(! $import){

            return response()->json([
              "status" => "error",
              "errors" => "Import Not Found"
            ]);

        }


        $client = Client::where('id', $import->client_id)->first();

        $employee = new Employee;

        $rules = [

            'client_id' => [

                'required',
                Rule::exists($client->getTable(), $client->getKeyName())
            ],
            'name' => 'required|unique:imports',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
            'budget' => 'required',
            'budget_type' => 'required',
            'desc' => 'required',
            'tag' => 'required',
            'shipment_num' => 'required|integer',
            'container_data' => 'required',
            'shipment_date' => 'required|date',
            'arrival_date' => 'required|date',
            'abstract_name' => 'required',
            'abstract_num' => 'required|integer',
            'shipment_location' => 'required',
            'doc_credit_num' => 'required|integer',
            'gurantee_letter_num' => 'required|integer',
            'employee' => 'Boolean',
            'employees' => 'required_if:employee,1',
            'employees.*.emp' => [

                Rule::exists($employee->getTable(), $employee->getKeyName())
            ]
        ];


        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $type = $client->type;
        switch($type){
          case "business": 
            $clientName = $client->trade_name;
          break;
          case "individual":
            $clientName = $client->full_name;
          break;
        }

        $import->update($request->except('employees'));
        $import->client_name = $clientName;
        $import->save();

        EmployeeImport::where('import_id', $import->id)->delete();
        
        $employees = $request->employees;
        foreach((array) $employees as $emp){

            EmployeeImport::create([

                'import_id' => $import->id,
                'employee_id' => $emp['emp'],
                'employee_name' => $employee->find($emp['emp'])->name

            ]);

        }

        $employeeimport = $import->employees()->get(['employee_id', 'employee_name']);

        return response()->json([

          "status" => "success",
          "data" => [
            'import' => $import,
            'employeeimport' => $employeeimport
          ]

        ], 200);

    }

    public function destroy($id){

        $import = Import::find($id);
        if(! $import){

            return response()->json([
              "status" => "error",
              "errors" => "Import Not Found"
            ]);

        }

        $import->delete();

        return response()->json([
          "status" => "success",
          "message" => "Import deleted Successfully"
        ]);
    }


}
