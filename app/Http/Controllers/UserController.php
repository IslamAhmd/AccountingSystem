<?php

namespace App\Http\Controllers;
use App\User;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Employee;
use Carbon\Carbon;

class UserController extends Controller
{
 
    public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');
            $user = Employee::where('email', $request->email)->first();
            if(! $user){
                return response()->json([
                "status" => "error",
                'error' => "User doesn't exist"
                 ]);
            }

            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString()
            ]);



            if (Auth::attempt($credentials)) {
                $token = JWTAuth::attempt($credentials);
                return response()->json([
                	"status" => "success",
                	"data" => [
                        "token" => $token,
                        "user" => $user
                    ]
                ], 200);
            }


            return response()->json([
                "status" => "error",
                'error' => 'invalid_credentials'
            ]);
            
        }

}
