<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Validator;
use App\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'treasury' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $employee = Employee::where('name' , $request->name)
                                ->where('email', $request->email)
                                ->first();
        if(! $employee){

            return ["message" => "employee not found"];
        }

        return $employee;
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

            'name' => 'required',
            'mobile' => 'required|integer',
            'phone' => 'required|integer',
            'first_address' => 'required|string',
            'sec_address' => 'required|string',
            'governorate' => 'required|string',
            'postal_code' => 'required|integer',
            'country' => 'required|string',
            'city' => 'required|string',
            'language' => 'string',
            'email' => 'string|email',
            'notes' => 'required',
            'role_name' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $employee = Employee::create($request->all());
        return response()->json($employee, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if(! $employee){
            return response()->json([
                "Message" => "Employee Not Found"
            ]);
        }

        return response()->json($employee, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if(! $employee){
            return response()->json([
                "Message" => "Employee Not Found"
            ]);
        }

        $employee->update($request->all());

        return response()->json($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        
        if(! $employee){
            return response()->json([
                "Message" => "Employee Not Found"
            ]);
        }

        $employee->delete();

        return response()->json([
            "message" => "Employee deleted successfully"]
        );
    }

}
