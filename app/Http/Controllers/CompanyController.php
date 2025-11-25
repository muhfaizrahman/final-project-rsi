<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Job;
use App\Models\WorkMethod;
use App\Models\WorkType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    public function index() {
        return view('company-pages.lowongan.index', [

        ]);
    }

    public function indexCreate() {
        $workMethods = WorkMethod::all();
        $workTypes = WorkType::all();
        $industries = Industry::all();

        return view('company-pages.create-lowongan.index', compact('workMethods','workTypes','industries'));
    }

    public function createJob(Request $request) {
        // 1. VALIDASI DATA
        $rules = [
            'work_type_id' => 'required|integer|exists:work_types,id',
            'work_method_id' => 'required|integer|exists:work_methods,id',
            'industry_id' => 'required|integer|exists:industries,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
        ];

        $validatedData = $request->validate($rules);
        
        // Dapatkan profil perusahaan dari user yang sedang login
        $companyProfile = Auth::user()->companyProfile;

        if (!$companyProfile) {
            // Handle jika user tidak memiliki profil perusahaan
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Anda harus melengkapi profil perusahaan sebelum membuat lowongan.');
        }

        // 2. LENGKAPI DATA SEBELUM DISIMPAN
        
        // company_id: ID perusahaan user yang sedang login
        $validatedData['company_id'] = Auth::user()->id; 
        
        // city & country: Diambil dari companyProfile (Asumsi relasi CompanyProfile ada kolom city dan country)
        $validatedData['city'] = $companyProfile->city ?? 'N/A'; 
        $validatedData['country'] = $companyProfile->country ?? 'N/A';
        
        // is_active: Default ke true saat pembuatan (sesuai permintaan)
        $validatedData['is_active'] = true;

        try {
            // 3. SIMPAN DATA KE DATABASE
            $job = Job::create($validatedData);

            // 4. KEMBALIKAN RESPONS (REDIRECT)
            return redirect()
                ->route('companyDashboardPage') // Ganti dengan route yang sesuai (misalnya: jobs.detail, jobs.index)
                ->with('success', 'Lowongan pekerjaan "' . $job->title . '" berhasil dibuat!');

        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat penyimpanan
            // Anda bisa log $e->getMessage() untuk debugging
            return redirect()
                ->back()
                ->withInput() 
                ->with('error', 'Gagal membuat lowongan pekerjaan. Error: ' . $e->getMessage());
        }
    }
}
