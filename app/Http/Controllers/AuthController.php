<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function forgotPassword() {
        return view('auth.forgot-password');
    }

    public function storeForgotPassword(Request $request) {
        $request->validate([
            'email' => 'required|string|email:rfc'
        ]);
        $user = User::where('email', $request->email)->first();
        if(!is_null($user)) {
            $token = urlencode(Str::random(64));
            DB::table('password_resets')->updateOrInsert(
                ['email' => $user->email],
                ['token' => Hash::make($token), 'created_at' => now()]
            );
            Mail::to($user->email)->queue(new ForgotPassword($user->email, $token));
            return redirect()->back()->with('success', 'Silahkan cek email untuk reset password');
        }
    }

    public function resetPassword(Request $request) {
        return view('auth.reset-password', [
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    public function storeResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'new_password' => 'required|string|confirmed|min:8|max:255',
            'email' => 'required|string|email:rfc'
        ]);
        $resetPassword = DB::table('password_resets')->where('email', $request->email)->first();
        if($resetPassword == null){
            return redirect()->back()->with('failed', 'Reset password failed!');
        }

        if (Hash::check(request()->token, $resetPassword->token)) {
            $user = User::where('email', $resetPassword->email)->first();
            $user->password = Hash::make($request->new_password);
            $user->save();
            DB::table('password_resets')->where('email', $request->email)->delete();
            return redirect()->back()->with('success', 'Password berhasil diubah');
        }
        return redirect()->back()->with('failed', 'Reset password gagal!');
    }


    public function logout() {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('index');
    }
}
