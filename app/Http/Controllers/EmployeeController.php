<?php


namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Validator;
use App\Role;
use App\User;
use App\EmployeeRepo;
use App\Repo;
use Illuminate\Validation\Rule;


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

        $employees_id = $employees->pluck('id');

        $employeerepos = EmployeeRepo::whereIn('employee_id', $employees_id)->select('employee_id', 'repo_id', 'repo_name')->get();

        return response()->json([
          "status" => "success",
          "data" => [
            'Employees' => $employees,
            'employeerepo' => $employeerepos
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

        $role = new Role;
        $repo = new Repo;
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
            'role_id' => [

                'required',
                Rule::exists($role->getTable(), $role->getKeyName())
            ],
            'repo_id' => [
              // 'required',
                Rule::exists($repo->getTable(), $repo->getKeyName())
            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);
        }

        $employee = Employee::create([
          'name' => $request->name,
          'mobile' => $request->mobile,
          'phone' => $request->phone,
          'first_address' => $request->first_address,
          'sec_address' => $request->sec_address,
          'governorate' => $request->governorate,
          'postal_code' => $request->postal_code,
          'country' => $request->country,
          'city' => $request->city,
          'language' => $request->language,
          'email' => $request->email,
          'notes' => $request->notes,
          'role_id' => $request->role_id,
          'role_name' => Role::find($request->role_id)->name
        ]);


        User::create([
            "name" => $employee->name,
            'employee_id' => $employee->id,
            "email" => $employee->email,
            "password" => bcrypt('123456')
        ]);

        if(Repo::where('id', $request->repo_id)->exists()){

            EmployeeRepo::create([

              'employee_id' => $employee->id,
              'repo_id' => $request->repo_id,
              'repo_name' => Repo::find($request->repo_id)->name

            ]);

        }
        

        $employeerepo = EmployeeRepo::where('employee_id', $employee->id)->select('repo_id', 'repo_name')->get();

        return response()->json([
          "status" => "success",
          "data" => [
            'Employee' => $employee,
            'employeerepo' => $employeerepo
          ]
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

        $employeerepo = EmployeeRepo::where('employee_id', $employee->id)->select('repo_id', 'repo_name')->get();

        return response()->json([
          "status" => "success",
          "data" => [

            'Employee' => $employee,
            'employeerepo' => $employeerepo
          ]
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

        $role = new Role;
        $repo = new Repo;
        $rules = [
            'name' => "required|unique:employees,name,$id",
            'mobile' => 'required|integer',
            'phone' => 'required|integer',
            'first_address' => 'required',
            'sec_address' => 'required',
            'governorate' => 'required',
            'postal_code' => 'required|integer',
            'country' => 'required',
            'city' => 'required',
            'language' => 'required',
            'email' => "required|email|unique:employees,email,$id",
            'notes' => 'required',
            'role_id' => [

                'required',
                Rule::exists($role->getTable(), $role->getKeyName())
            ],
            'repo_id' => [

                Rule::exists($repo->getTable(), $repo->getKeyName())
            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);
        }


        $employee->update($request->all());


        User::where('employee_id', $employee->id)->delete();
        User::create([
            "name" => $employee->name,
            'employee_id' => $employee->id,
            "email" => $employee->email,
            "password" => bcrypt('123456')
        ]);

        
        EmployeeRepo::where('employee_id', $employee->id)->delete();
        if(EmployeeRepo::where('repo_id', $request->repo_id)->exists()){

          EmployeeRepo::create([

            'employee_id' => $employee->id,
            'repo_id' => $request->repo_id,
            'repo_name' => Repo::find($request->repo_id)->name

          ]);

        }
        $employeerepo = EmployeeRepo::where('employee_id', $employee->id)->select('repo_id', 'repo_name')->get();


        return response()->json([
          "status" => "success",
          "data" => [
            'Employee' => $employee,
            'employeerepo' => $employeerepo
          ]
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
