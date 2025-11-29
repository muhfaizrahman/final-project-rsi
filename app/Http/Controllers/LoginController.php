<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ===== LOGIN =====
    public function index() {
        return view('pages.login.index');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()->with('error', 'Email belum terverifikasi.');
            }

            // Redirect sesuai role masing-masing
            return $this->redirectByRole($user);
        }

        return back()->with('loginError', 'Login gagal.');
    }

    private function redirectByRole($user) {
        if ($user->role === 'pelamar') {
            return redirect()->route('homePage');
        }

        if ($user->role === 'perusahaan') {
            return redirect()->route('companyDashboardPage');
        }

        return redirect()->route('homePage'); 
    }
}
