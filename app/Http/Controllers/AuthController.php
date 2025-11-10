<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;

class AuthController extends Controller
{
    public function showRegistrationForm() {
        return view('register.index');
    }

    public function register(Request $request) {
        $request->validate([
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Kirim email verifikasi
        event(new Registered($user));

        // Redirect ke halaman verifikasi
        return redirect()->route('verification.notice')->with('success', 'Registrasi berhasil! Silakan verifikasi email kamu.');
    }

    public function showLoginForm() {
        return view('login.index');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Cek apakah email sudah terverifikasi
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()->with('error', 'Email belum terverifikasi. Silakan periksa email kamu.');
            }

            return redirect()->route('homePage');
        }

        return back()->with('loginError', 'Login gagal.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showVerificationNotice() {
        return view('email.verify.index');
    }

    public function verifyEmail(Request $request) {
        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan.');
        }

        if (! hash_equals((string) $request->route('hash'),
            sha1($user->getEmailForVerification()))) {
            return redirect('/login')->with('error', 'Link verifikasi tidak valid.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/login')->with('message', 'Email sudah diverifikasi. Silakan login.');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect('/login')->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    public function resendVerificationEmail(Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/home');
        }

        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi baru telah dikirim ke email kamu.');
    }
}