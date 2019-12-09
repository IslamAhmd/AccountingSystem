<?php

namespace App\Http\Controllers;
use App\User;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
 
    public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');
            

            if (Auth::attempt($credentials)) {
                $token = JWTAuth::attempt($credentials);
                return response()->json([
                	"status" => "success",
                	"data" => compact('token')
                ], 200);
            }

            return response()->json(['error' => 'invalid_credentials'], 400);
            
        }

}
