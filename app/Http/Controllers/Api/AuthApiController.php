<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed'
            ]
        );
        $user =
            new User(['name' => $request->name, 'email' => $request->email, 'password' => bcrypt($request->password)]);

        $user->save();

        return response()->json(['message' => 'Successfully created user!'], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate(['username' => 'required|string', 'password' => 'required|string',]);

        $credentials = request(['username', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid login credentials provided'], 401);
        }

        $user = $request->user();

        //Check if the user is allowed to access the website
        if ($user->hasPermissionTo('website.access') === false) {
            return response()->json(
                ['message' => 'This account does not have the required permission to access the website.'],
                401
            );
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addMonths(1);
        }

        $token->save();

        return response()->json(
            [
                'token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toISOString()
            ]
        );
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param  Request  $request
     * @return JsonResponse [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * Get the authenticated User
     *
     * @param  Request  $request
     * @return JsonResponse [json] user object
     */
    public function user(Request $request)
    {
        return response()->json(User::with(['permissions', 'roles.permissions'])->find(Auth::id()), 200);
    }
}
