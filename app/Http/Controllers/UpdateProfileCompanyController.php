<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;
use Storage;

class UpdateProfileCompanyController extends Controller
{
    public function index(User $user) {
        $viewer = Auth::user();
        $user->load('company'); 
        
        return view('company-pages.profile.index', [
            'profileUser' => $user,
        ]);
    }

    public function editCompany(User $user) { 
        // Cek otorisasi: Hanya pemilik yang boleh mengedit
        if (Auth::id() !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit profil ini.');
        }

        // Ambil objek Model PROFILE COMPANY
        $profile = $user->company;

        if (!$profile) {
             return redirect()->route('companyProfilePage', $user)->with('error', 'Silakan lengkapi data profil perusahaan.');
        }

        return view('company-pages.profile.edit.index', [
            'profile' => $profile, 
            'user' => $user
        ]);
    }

    public function updateCompany(Request $request, User $user) { 
        if (Auth::id() !== $user->id) {
            abort(403, 'Akses ditolak.');
        }
        
        $profile = $user->company;
        
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'about' => 'nullable|string',
            'profile_photo_url' => 'nullable|image|max:1024',
            'background_photo_url' => 'nullable|image|max:2048',
        ]);

        // Transaksi database
        DB::transaction(function () use ($profile, $data, $request) {
            
            $profilePhotoUrl = $profile->profile_photo_url;
            $backgroundPhotoUrl = $profile->background_photo_url;

            // Handle file upload
            if ($request->hasFile('profile_photo_url')) {
                // Hapus foto lama
                if ($profilePhotoUrl) { Storage::disk('public')->delete($profilePhotoUrl); }
                $profilePhotoUrl = $request->file('profile_photo_url')->store('company_profile_photos', 'public');
            }

            if ($request->hasFile('background_photo_url')) {
                // Hapus background lama
                if ($backgroundPhotoUrl) { Storage::disk('public')->delete($backgroundPhotoUrl); }
                $backgroundPhotoUrl = $request->file('background_photo_url')->store('company_background_photos', 'public');
            }
            
            $profile->update([
                'company_name' => $data['company_name'],
                'city' => $data['city'],
                'country' => $data['country'],
                'about' => $data['about'] ?? null,
                'profile_photo_url' => $profilePhotoUrl,
                'background_photo_url' => $backgroundPhotoUrl,
            ]);
        });

        return redirect()->route('companyProfilePage', $user)->with('success', 'Profil perusahaan berhasil diperbarui!');
    }
}
