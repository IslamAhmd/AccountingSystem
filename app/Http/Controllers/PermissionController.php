<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Validator;
use App\PermissionRole;

class PermissionController extends Controller
{
    public function assignRolePermissions(Request $request){

        $rules = [
            'name' => 'required|string',
            'admin' => 'boolean',
            'permission' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json($validator->errors(), 400);

        }

        $role = Role::create([
            'name' => $request->name,
            'admin' => $request->admin
        ]);


        $perms[] = $request->permission;
        // return $perms;
        foreach($perms as $perm){

            // return $perm;

            foreach($perm as $each_perm){

                $type = $each_perm["type"];
                $values = $each_perm["values"];

                // return $values;

                foreach($values as $value){

                    
                    $permission = Permission::where([
                            'type' => $type,
                            'permission' => $value
                    ])->first();



                    // return $role;
                    // return $permission;

                    PermissionRole::create([
                        'role_id' => $role->id,
                        'permission_id' => $permission->id
                    ]);
                }

            }

        }


        // return permissions ids in array
        $permission_id = PermissionRole::where('role_id', $role->id)->get()->pluck('permission_id');
        // return $permission_id;
       

       // return permissions names in array
        $permission_name = Permission::find($permission_id, ['permission']);
        // return $permission_name;


        return response()->json([
            "role_name" => $role->name,
            "permissions" => $permission_name
        ], 201);

    }

}

