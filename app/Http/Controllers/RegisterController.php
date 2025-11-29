<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfileCompany;
use App\Models\User;
use DB;
use Exception;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index() {
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
            } else if ($request->role === 'pelamar') {
                Profile::create([
                    'user_id' => $user->id,
                    'full_name' => 'Default Name',
                ]);
            }
    
            DB::commit();
    
            event(new Registered($user));
    
            return redirect()->route('verification.notice')
                ->with('success', 'Registrasi berhasil! Silakan verifikasi email kamu.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
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
