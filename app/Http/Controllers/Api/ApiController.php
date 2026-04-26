<?php

namespace App\Http\Controllers\Api;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ApiController extends Controller
{
  public function Register(Request $request)
  {
    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:6', 'confirmed'],
      'role' => ['required', 'in:user,admin'],
    ]);

    $user = \App\Models\User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),

    ]);
    $user->assignRole($validated['role']);
    // jika berhasil kembali kan reponse dalam bentuk json
    return response()->json([
      'status' => true,
      'message' => 'User registrated  Successs',
      'user' => $user

    ]);
  }
  public function Login(Request $request)
  {
    $credentials = $request->only('email', 'password');
    if (!Auth::attempt($credentials)) {
      return response()->json([
        'status' => false,
        'message' => 'User registrated  Successs',
      ], 401);
    }
    $user = Auth::user();
    $token = JWTAuth::fromUser($user);
    return response()->json([
      'status' => true,
      'message' => 'login sukses',
      'token' => $token,
      'user' => $user,

    ]);
  }
  public function Logout(Request $request)
  {
    $request->user()->currentAccessToken()->delete();
    return response()->json([
      'message' => 'success log out'

    ]);
  }
}
