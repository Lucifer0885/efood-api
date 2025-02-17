<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Device;
use App\Enums\RoleCode;
use App\Models\Role;
use App\Models\RoleUser;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        if($request->role && $request->role == 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'page not found',
            ], 404);
        }

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'string',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'phone' => isset($fields['phone'] ) ?? $fields['phone'],
        ]);

        if($request->role){
            $role = Role::find(RoleCode::{$request->role});
            if($role){
                RoleUser::create([
                    'user_id' => $user->id,
                    'role_id' => $role->id,
                ]);
            }
        }

        $token = $user->createToken(Device::tokenName())->plainTextToken;

        $response = [
            'status' => true,
            'message' => 'User created successfully',
            'data' => [
              'user' => $user,
              'token' => $token
            ]
        ];

        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Bad creds'
            ], 401);
        }

        if (!Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Bad creds'
            ], 401);
        }

        if ($request->role){
            $role = $user->roles()->where('role_id', RoleCode::{$request->role})->first();
            if (!$role) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }        
        }

        $token = $user->createToken(Device::tokenName())->plainTextToken;

        $response = [
            'status' => true,
            'message' => 'User login',
            'data' => [
              'user' => $user,
              'token' => $token,
              'role' => $request->role,
            ]
        ];

        return response()->json($response);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out'
        ]);
    }
}