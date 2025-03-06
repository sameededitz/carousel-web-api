<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function LoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $loginType = filter_var($request->name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $user = User::where($loginType, $request->name)->first();
        if (!$user) {
            return back()->withErrors([
                'name' => "We couldn't find an account with that " . ($loginType == 'email' ? 'email' : 'username') . ".",
            ]);
        }

        if ($user->role !== 'admin') {
            return back()->withErrors([
                'name' => "You are not an admin.",
            ]);
        }

        $credentials = [
            $loginType => $request->name,
            'password' => $request->password,
        ];
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            return redirect()->route('admin-home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
