<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MemberAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.member-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('member')->attempt($credentials)) {
            return redirect()->route('member.dashboard');
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function logout()
    {
        Auth::guard('member')->logout();
        return redirect()->route('member.login.form');
    }
}
