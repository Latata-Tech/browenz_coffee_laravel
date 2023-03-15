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

    function logout() {

    }
}
