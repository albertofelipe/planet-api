<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\EmailAlreadyExistsException;
use App\Exceptions\EmailNotFoundException;
use App\Exceptions\PasswordIncorrectException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(AuthRegisterRequest $request)
    {
        if(User::where('email', $request->email)->exists()) {
            throw new EmailAlreadyExistsException();
        }

        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User registered successfully.',
            'user'    => $user
        ], 201);
    }

    public function login(AuthLoginRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            throw new EmailNotFoundException();
        }
        if(!Hash::check($request->password, $user->password)) {
            throw new PasswordIncorrectException();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token'   => $token,
            'user'    => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful.'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
