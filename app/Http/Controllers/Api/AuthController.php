<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function register(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'iserror' => true,
                'data' => [],
                'message' => 'Validation Error',
                'errors' => $validateUser->errors()
            ]);
        } else {
            $user = User::create($request->except('_token', 'password') + [
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'iserror' => false,
                'data' => $user,
                'message' => 'Registration Completed Successfully!',
                'errors' => [],
                'token' => $user->createToken("REGISTER TOKEN")->plainTextToken
            ]);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function login(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );
        if ($validateUser->fails()) {
            return response()->json([
                'iserror' => true,
                'data' => [],
                'message' => 'Validation Error',
                'errors' => $validateUser->errors()
            ]);
        }
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'iserror' => true,
                'data' => [],
                'message' => 'Email & Password does not match with our record.',
                'errors' => ['password' => ['Email & Password does not match with our record.']]
            ]);
        }
        $user = User::where('email', $request->email)->first();

        return response()->json([
            'iserror' => false,
            'data' => $user,
            'message' => 'User Logged In Successfully!',
            'errors' => [],
            'token' => $user->createToken("LOGIN TOKEN")->plainTextToken
        ]);
    }
}
