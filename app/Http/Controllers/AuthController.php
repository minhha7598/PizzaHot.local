<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    //REGISTER
    public function register(RegisterRequest $request)
    {
        try{
            $user = User::create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'is_admin' => $request->is_admin,
            ]);
    
            $token = Auth::login($user);
            
            return response()->json([
                'status' => 'True',
                'message' => 'Register successfully',
                'data' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Register failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }

    //LOGIN
    public function login(LoginRequest $request)
    {
        try{
            $credentials = $request->only('email', 'password');
            $token = Auth::attempt($credentials);
            if (!$token) {
                return response()->json([
                    'status' => 'False',
                    'message' => 'Unauthorized',
                    'data' => 'No data!',
                    'error' => 'True'
                ], 401);
            }
    
            $user = Auth::user();
            
            return response()->json([
                'status' => 'True',
                'message' => 'Login Successfully',
                'data' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Login failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }

    //LOGOUT
    public function logout()
    {
        try{
            Auth::logout();
            
            return response()->json([
                'status' => 'True',
                'message' => 'Logout successfully',
                'data' => 'No data!',
                'error' => 'False',
            ],200);  
        }catch (Exception $e) {
            return response()->json([
                'status' => 'False',
                'message' => "Logout failed!" ,
                'data' => 'No data!',
                'error' => 'True', $e
            ],404);  
        }
    }
}