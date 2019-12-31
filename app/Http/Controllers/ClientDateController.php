<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientDate;
use Validator;
use App\Client;
use App\Employee;
use Illuminate\Validation\Rule;
use App\DateEmployee;

// duration and time 


class ClientDateController extends Controller
{



    public function index(){

      $dates = ClientDate::get();

      $dates_id = $dates->pluck('id');

      $dateemployees = DateEmployee::whereIn('date_id', $dates_id)->select(['date_id', 'employee_id', 'employee_name'])->get();


    	return response()->json([
          "status" => "success",
          "data" => [

            'dates' => $dates,
            'dateemployees' => $dateemployees

          ] 
      ], 200);

    }




    public function store(Request $request){


    	  $rules = [

            'client_id' => [
              'required',
              Rule::exists(Client::getTable(), Client::getKeyName())
              ],
            'date' => 'required|date',
            'duration' => 'required',
            'time' => 'required',
            'action' => 'required',
            'notes' => 'required',
            'sharing' => 'Boolean',
            'repeated' => 'Boolean',
            'frequency' => 'required_if:repeated,1',
            'repeateddate' => 'required_if:repeated,1|date',
            'employee' => 'Boolean',
            'employees' => 'required_if:employee,1',
            'employees.*' => [
              'required',
              Rule::exists(Employee::getTable(), Employee::getKeyName())

            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $date = ClientDate::create([
          'client_id' => $request->client_id,
          'date' => $request->date,
          'duration' => $request->duration,
          'time' => $request->time,
          'action' => $request->action,
          'sharing' => $request->sharing,
          'repeated' => $request->repeated,
          'client_name' => Client::where('id', $request->client_id)->first()->trade_name,
          'notes' => $request->notes,
          'frequency' => $request->frequency,
          'repeateddate' => $request->repeateddate,
          'employee' => $request->employee
        ]);

        $employees = $request->employees;
        foreach((array) $employees as $emp){

            DateEmployee::create([

              'date_id' => $date->id,
              'employee_id' => $emp['emp'],
              'employee_name' => Employee::find($emp['emp'])->name

            ]);

        }

        $dateemployees = DateEmployee::where('date_id', $date->id)->select('employee_id', 'employee_name')->get();


        return response()->json([
          "status" => "success",
          "data" =>[

            'dates' => $date,
            'dateemployees' => $dateemployees

          ] 
        ], 201);

    }




     public function show($id)
     {

     	$date = ClientDate::find($id);
     	if(! $date){
     		return response()->json([
              "status" => "error",
              "errors" => "Date Not Found"
            ]);

     	}

      $dateemployee = DateEmployee::where('date_id', $date->id)->select(['date_id','employee_id', 'employee_name'])->get();

     	return response()->json([
          "status" => "success",
          "data" =>[

            'dates' => $date,
            'dateemployee' => $dateemployee

          ]
      ], 200);
    }


    public function update(Request $request, $id){

    	  $date = ClientDate::find($id);

        if(! $date){

            return response()->json([
              "status" => "error",
              "errors" => "Date Not Found"
            ]);

        }


        $rules = [

            'client_id' => [
              'required',
              Rule::exists(Client::getTable(), Client::getKeyName())
              ],
            'date' => 'required|date',
            'duration' => 'required',
            'time' => 'required',
            'action' => 'required',
            'notes' => 'required',
            'sharing' => 'Boolean',
            'repeated' => 'Boolean',
            'frequency' => 'required_if:repeated,1',
            'repeateddate' => 'required_if:repeated,1|date',
            'employee' => 'Boolean',
            'employees' => 'required_if:employee,1',
            'employees.*' => [
              'required',
              Rule::exists(Employee::getTable(), Employee::getKeyName())

            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }
        
    	 $date->update([
          'client_id' => $request->client_id,
          'date' => $request->date,
          'duration' => $request->duration,
          'time' => $request->time,
          'action' => $request->action,
          'sharing' => $request->sharing,
          'repeated' => $request->repeated,
          'client_name' => Client::where('id', $request->client_id)->first()->trade_name,
          'notes' => $request->notes,
          'frequency' => $request->frequency,
          'repeateddate' => $request->repeateddate,
          'employee' => $request->employee
        ]);


       DateEmployee::where('date_id', $date->id)->delete();

        $employees = $request->employees;
        foreach((array) $employees as $emp){

            DateEmployee::create([

              'date_id' => $date->id,
              'employee_id' => $emp['emp'],
              'employee_name' => Employee::find($emp['emp'])->name

            ]);

        }

        $dateemployees = DateEmployee::where('date_id', $date->id)->select('employee_id', 'employee_name')->get();


        return response()->json([
          "status" => "success",
          "data" => [

            'dates' => $date,
            'dateemployee' => $dateemployees
          ]
        ], 200);

    }

    public function destroy($id){

    	$date = ClientDate::find($id);

    	if(! $date){

     		return response()->json([
              "status" => "error",
              "errors" => "Date Not Found"
            ]);
     	}

     	$date->delete();

        return response()->json([
          "status" => "success",
          "message" => "Date deleted Successfully"
        ]);

    }

}
