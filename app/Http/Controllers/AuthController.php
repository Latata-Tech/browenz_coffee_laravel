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
            if(auth()->user()->role_id === 2) return back()->withErrors('Maaf anda tidak bisa login');
            if (!auth()->user()->status) return back()->withErrors('User sudah tidak aktif lagi');
            return redirect()->route('dashboard');
        }
        return back()->withErrors('Email atau Password yang anda masukan salah');
    }

    public function logout() {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('index');
    }
}
