<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('auth.index');
    }

    public function login(LoginRequest $request) {
        if(Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
        return back()->withErrors('Email atau Password yang anda masukan salah');
    }
}