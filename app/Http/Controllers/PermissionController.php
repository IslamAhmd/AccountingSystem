<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Validator;
use PermissionRole;

class PermissionController extends Controller
{
    public function assignRolePermissions(Request $request){

        $rules = [
            'name' => 'required|string',
            'admin' => 'boolean',
            'type' => 'required|string',
            'name' => 'required',
            'viewname' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json($validator->errors(), 400);

        }

        $role = Role::create([
            'name' => $request->name,
            'admin' => $request->admin
        ]);

        $permission = [];
        $permission = Permission::where([
            'type' => $request->type,
            'viewname' => $request->viewname
        ])->get();

        dd($permission);

        for($i = 0; $i < count($permission); $i++){
            
            $permission_role = PermissionRole::create([
                'role_id' => $role->id,
                'permission_id' => $permission
            ]);

        }
        

        dd($permission_role);
        

        // return response()->json([], 201);

    }

}
