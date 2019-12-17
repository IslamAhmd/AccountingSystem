<?php


namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Validator;
use App\Role;
use App\User;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::get();

        return response()->json([
          "status" => "success",
          "data" => $employees
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
            'name' => 'required|unique:employees',
            'mobile' => 'required|integer',
            'phone' => 'required|integer',
            'first_address' => 'required',
            'sec_address' => 'required',
            'governorate' => 'required',
            'postal_code' => 'required|integer',
            'country' => 'required',
            'city' => 'required',
            'language' => 'required',
            'email' => 'required|email|unique:employees',
            'notes' => 'required',
            'role_name' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);
        }

        $employee = Employee::create($request->all());

        // return $employee->id;

        $user = User::create([
            "name" => $employee->name,
            'employee_id' => $employee->id,
            "email" => $employee->email,
            "password" => bcrypt('123456')
        ]);

        return response()->json([
          "status" => "success",
          "data" => $employee
        ], 201);

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
              "status" => "error",
              "errors" => "Employee Not Found"
            ]);
        }

        return response()->json([
          "status" => "success",
          "data" => $employee
        ], 200);
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
              "status" => "error",
              "errors" => "Employee Not Found"
            ]);
        }

        $rules = [
            'name' => 'required|unique:employees,name,$id',
            'mobile' => 'required|integer',
            'phone' => 'required|integer',
            'first_address' => 'required',
            'sec_address' => 'required',
            'governorate' => 'required',
            'postal_code' => 'required|integer',
            'country' => 'required',
            'city' => 'required',
            'language' => 'required',
            'email' => 'required|email|unique:employees,email,$id',
            'notes' => 'required',
            'role_name' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);
        }

        $employee->update($request->all());

        return response()->json([
          "status" => "success",
          "data" => $employee
        ], 200);
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
              "status" => "error",
              "errors" => "Employee Not Found"
            ]);

        }

        $employee->delete();

        return response()->json([
          "status" => "success",
          "message" => "Employee deleted Successfully"
        ]);
    }

}
