<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error'], 400);
        }
        $request['password'] = Hash::make($request["password"]);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->all());
        $token = $user->createToken('PrivateTBankJawaban')->plainTextToken;
        $response = ['token' => $token, 'status' => 'success'];
        return (new UserResponse($user))->additional($response);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error'], 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found', 'status' => 'error'], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Password is incorrect', 'status' => 'error'], 401);
        }
        $user->tokens()->delete();
        $token = $user->createToken('PrivateTBankJawaban')->plainTextToken;
        $response = ['token' => $token, 'status' => 'success'];
        return (new UserResponse($user))->additional($response);
    }
}
