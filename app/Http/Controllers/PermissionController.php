<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Validator;

class PermissionController extends Controller
{
    public function assignRolePermissions(Request $request){

        $rules = [
            'name' => 'required|string',
            'admin' => 'boolean',
            'type' => 'required|string',
            'permission' => 'required|string',
            'status' => 'boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json($validator->errors(), 400);

        }

        $role = Role::create([
            'name' => $request->name,
            'admin' => $request->admin
        ]);

        $permission = Permission::create([
            'type' => $request->type,
            'permission' => $request->permission,
            'status' => $request->status
        ]);

        $role->permissions()->sync($role);

        return response()->json([$role->name => $role->permissions()->permission], 201);

    }

}
