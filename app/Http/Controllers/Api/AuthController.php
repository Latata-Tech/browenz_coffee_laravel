<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login(Request $request) {
        if(Auth::attempt(['email'=> $request->email, 'password' => $request->password])) {
            $token = Auth::user()->createToken('user_token_'.\auth()->user()->name);
            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'data' => [
                    'access_token' => $token->plainTextToken,
                ]
            ]);
        }
        return response()->json([
            'code' => 400,
            'status' => 'BAD_REQUEST',
            'message' => 'Email atau Password yang dimasukan salah'
        ]);
    }

    function user() {
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => \auth()->user()->id,
                'name' => \auth()->user()->name,
                'email' => \auth()->user()->email,
                'role_id' => \auth()->user()->role_id
            ]
        ]);
    }

    function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'code' => 200,
            'status' => 'OK',
            'message' => 'Berhasil logout'
        ]);
    }
}
