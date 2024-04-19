<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //login api
    public function login(Request $request)
    {
        //validate the request...
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //check if the user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        //check if the password is correct
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        //generate token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function register(Request $request)
    {

        $request->validate(
            [
                'name' => 'required',
                'hp' => 'required|numeric',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
            ]
        );
        $user = new User();
        $user->name = $request->name;
        $user->hp = $request->hp;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/users', $user->id . '.' . $image->getClientOriginalExtension());
            $user->image = 'storage/users/' . $user->id . '.' . $image->getClientOriginalExtension();
            $user->save();
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged Out'], 200);
    }
}
