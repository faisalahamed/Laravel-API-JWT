<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|unique:users",
            "password" => "required|confirmed",
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            'message' => 'user sign up successful',
        ]);
    }
    public function login(Request $request)
    {

        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        $token = auth()->attempt(['email' => $request->email, 'password' => $request->password]);
        if (!$token) {
            return response()->json(['message' => 'failed']);
        }
        return response()->json(['message' => 'success', 'token' => $token]);
    }
    public function profile()
    {
        return response()->json(['message' => 'success', 'user' => auth()->user()]);
    }
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'log out success']);
    }
}
