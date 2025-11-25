<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ProfileCompany;
use DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;

class AuthController extends Controller
{
    public function showRegistrationForm() {
        return view('pages.register.index');
    }

    public function register(Request $request) {
        $request->validate([
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required',
            'role' => 'required|in:pelamar,perusahaan',
        ]);
        try {
            DB::beginTransaction();
            
            $user = User::create([
                'name' => $request->name ?? 'User',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
    
            if ($request->role === 'perusahaan') {
                ProfileCompany::create([
                    'user_id' => $user->id,
                    'company_name' => 'Belum Diatur',
                    'city' => 'Belum Diatur',
                    'country' => 'Belum Diatur',
                ]);
            }
    
            DB::commit();
    
            event(new Registered($user));
    
            return redirect()->route('verification.notice')
                ->with('success', 'Registrasi berhasil! Silakan verifikasi email kamu.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }

    // ===== LOGIN =====
    public function showLoginForm() {
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

    private function redirectByRole($user)
    {
        if ($user->role === 'pelamar') {
            return redirect()->route('homePage');
        }

        if ($user->role === 'perusahaan') {
            return redirect()->route('companyDashboardPage');
        }

        return redirect()->route('homePage'); // fallback
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showVerificationNotice() {
        return view('pages.email.verify.index');
    }

    public function verifyEmail(Request $request) {
        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan.');
        }

        if (!hash_equals((string) $request->route('hash'),
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