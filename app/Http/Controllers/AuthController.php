<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Register a new company and manager
    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create company
        $company = Company::create([
            'name' => $request->name . " Company",
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        // Create roles
        $role = Role::where('name', 'Manager')->first();

        // Create manager (user)
        $user = User::create([
            'company_id' => $company->id,
            'role_id' => $role->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        // Create token for the manager
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
        ], 201);
    }

    // Login user and return JWT token
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if ($token = JWTAuth::attempt($credentials)) {
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}