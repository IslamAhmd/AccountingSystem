<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Validator;
use App\PermissionRole;

class RolesController extends Controller
{

    public function index(){

        $roles = Role::get();


        return response()->json([
          "status" => "success",
          "data" => $roles
        ], 200);

    }


    public function store(Request $request){

            $rules = [
            'name' => 'required|string|unique:roles',
            'admin' => 'boolean',
            'type' => 'required',
            'permission' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);


        }

        $role = Role::create([
            'name' => $request->name,
            'admin' => $request->admin
        ]);

        $types = $request->type;
        // return $types;
        // return $types[1]['name'];
        $permissions = $request->permission;
        // return $permissions;
        // return $permissions[2]['type'];
        foreach($types as $type){

            foreach ($permissions as $permission) {

                if($type['name'] == $permission['type']){

                    // return $type['name'];
                    $value = $permission['value'];
                    // return $value;

                    $permission = Permission::where([
                            'type' => $type['name'],
                            'viewname' => $value
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
            "status" => "success",
            "data" => [
            "role_name" => $role->name,
            "permissions" => $permission_name
            ]
        ], 201);
        
    }






    public function update(Request $request, $id){

        $rules = [
            'name' => 'required|string',
            'admin' => 'boolean',
            'permission' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
              "status" => "error",
              "errors" => $validator->errors()
            ]);

        }

        $role = Role::find($id);

        if(! $role){

            return response()->json([
              "status" => "error",
              "errors" => "Role Not Found"
            ]);

            
        }

        PermissionRole::where('role_id', $role->id)->delete();

        $role->update([
            'name' => $request->name,
            'admin' => $request->admin
        ]);

         $types = $request->type;
        // return $types;
        // return $types[1]['name'];
        $permissions = $request->permission;
        // return $permissions;
        // return $permissions[2]['type'];
        foreach($types as $type){

            foreach ($permissions as $permission) {

                if($type['name'] == $permission['type']){

                    // return $type['name'];
                    $value = $permission['value'];
                    // return $value;

                    $permission = Permission::where([
                            'type' => $type['name'],
                            'viewname' => $value
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
            "status" => "success",
            "data" => [
            "role_name" => $role->name,
            "permissions" => $permission_name
            ]
        ], 201);

    }


    public function destroy($id){

        $role = Role::find($id);
        if(! $role){
            
            return response()->json([
              "status" => "error",
              "errors" => "Role Not Found"
            ]);
        }

        $role->delete();

        return response()->json([
          "status" => "success",
          "message" => "Client deleted Successfully"
        ]);
    }

}

