<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Auth
 *
 * Authorization endpoints
 */

class AuthController extends Controller
{
    /**
     * api/auth/login
     *
     * Login user using credentials
     *
     * @bodyParam nickname string required
     * @bodyParam password string required
     */
    public function login(Request $request){
        $request->validate([
            'nickname' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = request(['nickname', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'data' => [
                'access_token' => 'Bearer '.$tokenResult->accessToken,
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]
        ]);
    }

    /**
     * api/auth/register
     *
     * Registers new user
     *
     * @bodyParam  nickname string required
     * @bodyParam  email email required
     * @bodyParam  password string required
     * @bodyParam  password_confirmation string required
     */
    public function register(Request $request){
        $request->validate([
            'nickname' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User([
            'nickname' => $request->get('nickname'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 200);
    }
    /**
     * api/logout
     *
     * removes token from database disabling login possibility
     *
     */
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * api/me
     *
     * return user data based on sended token
     */
    public function me(){
        $user = User::with(['reports','reports.position', 'reports.photo'])->where('id', '=', Auth::id())->first();
//        $user = Auth::user()->;
        return response()->json(['data' => ['user' => $user]]);
    }

}
