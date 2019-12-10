<?php

namespace App\Http\Controllers;
use App\User;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Employee;

class UserController extends Controller
{
 
    public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');
            // $user = Employee::where('email', $request->email)->first();


            if (Auth::attempt($credentials)) {
                $token = JWTAuth::attempt($credentials);
                return response()->json([
                	"status" => "success",
                	"data" => [
                        "token" => $token,
                        "user" => "bla"
                    ]
                ], 200);
            }

            return response()->json(['error' => 'invalid_credentials'], 400);
            
        }

}
