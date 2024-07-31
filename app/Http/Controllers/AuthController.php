<?php

namespace App\Http\Controllers;

use App\Helpers\JwtHelper;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    use ApiResponses;
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);

        $jwt = JwtHelper::generateJwt([
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);

        return $this->ok(
            'Authenticated',
            [
                'jwt' => $jwt
            ]
        );

    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $request->validated($request->all());
        } catch (\Exception $e) {
            return $this->error('Incorrect credentials!', 401);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
        } catch (\Exception $e) {
            return $this->error('Email found in database!', 409);
        }

        return $this->ok('User created succsefully!', [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $user->createToken('auth_token')->plainTextToken
        ]);
    }
}
