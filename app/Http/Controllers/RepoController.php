<?php

namespace App\Http\Controllers;
use App\Repo;
use Validator;
use App\EmployeeRepo;
use App\RepoRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Employee;
use App\Role;


class RepoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repos = Repo::get();

        $repos_id = $repos->pluck('id');

        $employeerepos = EmployeeRepo::whereIn('repo_id', $repos_id)->get();
        $reporoles = RepoRole::whereIn('repo_id', $repos_id)->get();

        return response()->json([
          "status" => "success",
          "data" => [
            'repos' => $repos,
            'employeerepos' => $employeerepos,
            'reporoles' => $reporoles
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
        $employee = new Employee;
        $role = new Role;

        $rules = [
            'name' => 'required|unique:repos',
            'location' => 'required',
            'active' => 'boolean',
            'primary' => 'boolean',
            'show' => 'required',
            'showEmployees' => 'required_if:show,Specific Staff Members',
            'showEmployees.*.emp' => [

                Rule::exists($employee->getTable(), $employee->getKeyName())
            ],
            'showRoles' => 'required_if:show,Specific Roles',
            'showRoles.*.role' => [

                Rule::exists($role->getTable(), $role->getKeyName())
            ],
            'bill' => 'required',
            'billEmployees' => 'required_if:bill,Specific Staff Members',
            'billEmployees.*.emp' => [

                Rule::exists($employee->getTable(), $employee->getKeyName())
            ],
            'billRoles' => 'required_if:bill,Specific Roles',
            'billRoles.*.role' => [

                Rule::exists($role->getTable(), $role->getKeyName())
            ],
            'store' => 'required',
            'storeEmployees' => 'required_if:store,Specific Staff Members',
            'storeEmployees.*.emp' => [

                Rule::exists($employee->getTable(), $employee->getKeyName())
            ],
            'storeRoles' => 'required_if:store,Specific Roles',
            'storeRoles.*.role' => [

                Rule::exists($role->getTable(), $role->getKeyName())
            ],
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }


        $repo = Repo::create($request->only('name', 'location', 'active', 'primary', 'show', 'bill', 'store'));
        // return $repo;

        $showEmployees = $request->showEmployees;
        foreach((array) $showEmployees as $showEmp){

            EmployeeRepo::create([

                'repo_id' => $repo->id,
                'show_employee_id' => $showEmp['emp'],
                'show_emp_name' => Employee::find($showEmp['emp'])->name

            ]);

        }


        $showRoles = $request->showRoles;
        foreach((array) $showRoles as $showRole){

            RepoRole::create([

                'repo_id' => $repo->id,
                'show_role_id' => $showRole['role'],
                'show_role_name' => Role::find($showRole['role'])->name
            ]);

        }


        $billEmployees = $request->billEmployees;
        foreach((array) $billEmployees as $billEmp){

            EmployeeRepo::create([

                'repo_id' => $repo->id,
                'bill_employee_id' => $billEmp['emp'],
                'bill_emp_name' => Employee::find($billEmp['emp'])->name

            ]);

        }


        $billRoles = $request->billRoles;
        foreach((array) $billRoles as $billRole){

            RepoRole::create([

                'repo_id' => $repo->id,
                'bill_role_id' => $billRole['role'],
                'bill_role_name' => Role::find($billRole['role'])->name
            ]);

        }



        $storeEmployees = $request->storeEmployees;
        foreach((array) $storeEmployees as $storeEmp){

            EmployeeRepo::create([

                'repo_id' => $repo->id,
                'store_employee_id' => $storeEmp['emp'],
                'store_emp_name' => Employee::find($storeEmp['emp'])->name

            ]);

        }


        $storeRoles = $request->storeRoles;
        foreach((array) $storeRoles as $storeRole){

            RepoRole::create([

                'repo_id' => $repo->id,
                'store_role_id' => $storeRole['role'],
                'store_role_name' => Role::find($storeRole['role'])->name
            ]);

        }


        $employeerepo = EmployeeRepo::where('repo_id', $repo->id)->get();
        $reporole = RepoRole::where('repo_id', $repo->id)->get();


        return response()->json([

          "status" => "success",
          "data" => [
            'repo' => $repo,
            'employeerepo' => $employeerepo,
            'reporole' => $reporole
          ]

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
        $repo = Repo::find($id);

        if(! $repo){
            return response()->json([
              "status" => "error",
              "errors" => "Repo Not Found"
            ]);
        }


        $employeerepo = EmployeeRepo::where('repo_id', $repo->id)->get();
        $reporole = RepoRole::where('repo_id', $repo->id)->get();

        return response()->json([
          "status" => "success",
          "data" => [

            'repo' => $repo,
            'employeerepo' => $employeerepo,
            'reporole' => $reporole

          ]
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
        $repo = Repo::find($id);

        if(! $repo){
            return response()->json([
              "status" => "error",
              "errors" => "Repo Not Found"
            ]);
        }

        $employee = new Employee;
        $role = new Role;

        $rules = [
            'name' => "required|unique:repos,name,$id",
            'location' => 'required',
            'active' => 'boolean',
            'primary' => 'boolean',
            'show' => 'required',
            'showEmployees' => 'required_if:show,Specific Staff Members',
            'showEmployees.*.emp' => [

                Rule::exists($employee->getTable(), $employee->getKeyName())
            ],
            'showRoles' => 'required_if:show,Specific Roles',
            'showRoles.*.role' => [

                Rule::exists($role->getTable(), $role->getKeyName())
            ],
            'bill' => 'required',
            'billEmployees' => 'required_if:bill,Specific Staff Members',
            'billEmployees.*.emp' => [

                Rule::exists($employee->getTable(), $employee->getKeyName())
            ],
            'billRoles' => 'required_if:bill,Specific Roles',
            'billRoles.*.role' => [

                Rule::exists($role->getTable(), $role->getKeyName())
            ],
            'store' => 'required',
            'storeEmployees' => 'required_if:store,Specific Staff Members',
            'storeEmployees.*.emp' => [

                Rule::exists($employee->getTable(), $employee->getKeyName())
            ],
            'storeRoles' => 'required_if:store,Specific Roles',
            'storeRoles.*.role' => [

                Rule::exists($role->getTable(), $role->getKeyName())
            ],
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);
        }

        $repo->update($request->only('name', 'location', 'active', 'primary', 'show', 'bill', 'store'));


        EmployeeRepo::where('repo_id', $repo->id)->delete();
        RepoRole::where('repo_id', $repo->id)->delete();

        $showEmployees = $request->showEmployees;
        foreach((array) $showEmployees as $showEmp){

            EmployeeRepo::create([

                'repo_id' => $repo->id,
                'show_employee_id' => $showEmp['emp'],
                'show_emp_name' => Employee::find($showEmp['emp'])->name

            ]);

        }


        $showRoles = $request->showRoles;
        foreach((array) $showRoles as $showRole){

            RepoRole::create([

                'repo_id' => $repo->id,
                'show_role_id' => $showRole['role'],
                'show_role_name' => Role::find($showRole['role'])->name
            ]);

        }


        $billEmployees = $request->billEmployees;
        foreach((array) $billEmployees as $billEmp){

            EmployeeRepo::create([

                'repo_id' => $repo->id,
                'bill_employee_id' => $billEmp['emp'],
                'bill_emp_name' => Employee::find($billEmp['emp'])->name

            ]);

        }


        $billRoles = $request->billRoles;
        foreach((array) $billRoles as $billRole){

            RepoRole::create([

                'repo_id' => $repo->id,
                'bill_role_id' => $billRole['role'],
                'bill_role_name' => Role::find($billRole['role'])->name
            ]);

        }



        $storeEmployees = $request->storeEmployees;
        foreach((array) $storeEmployees as $storeEmp){

            EmployeeRepo::create([

                'repo_id' => $repo->id,
                'store_employee_id' => $storeEmp['emp'],
                'store_emp_name' => Employee::find($storeEmp['emp'])->name

            ]);

        }


        $storeRoles = $request->storeRoles;
        foreach((array) $storeRoles as $storeRole){

            RepoRole::create([

                'repo_id' => $repo->id,
                'store_role_id' => $storeRole['role'],
                'store_role_name' => Role::find($storeRole['role'])->name
            ]);

        }


        $employeerepo = EmployeeRepo::where('repo_id', $repo->id)->get();
        $reporole = RepoRole::where('repo_id', $repo->id)->get();


        return response()->json([
          "status" => "success",
          "data" => [
            'repo' => $repo,
            'employeerepo' => $employeerepo,
            'reporole' => $reporole
          ]
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
        $repo = Repo::find($id);
        
        if(! $repo){
            return response()->json([
              "status" => "error",
              "errors" => "Repo Not Found"
            ]);

        }

        $repo->delete();

        return response()->json([
          "status" => "success",
          "message" => "Repo deleted Successfully"
        ]);
    }
}






