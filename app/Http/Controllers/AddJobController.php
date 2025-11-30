<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Job;
use App\Models\WorkMethod;
use App\Models\WorkType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddJobController extends Controller
{
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
        $company = Auth::user()->company;

        if (!$company) {
            // Handle jika user tidak memiliki profil perusahaan
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Anda harus melengkapi profil perusahaan sebelum membuat lowongan.');
        }

        // 2. LENGKAPI DATA SEBELUM DISIMPAN
        
        // company_id: ID perusahaan user yang sedang login
        $validatedData['company_id'] = Auth::user()->company->id; 
        
        // city & country: Diambil dari company (Asumsi relasi company ada kolom city dan country)
        $validatedData['city'] = $company->city ?? 'Belum Diatur'; 
        $validatedData['country'] = $company->country ?? 'Belum Diatur';
        
        // is_active: Default ke true saat pembuatan (sesuai permintaan)
        $validatedData['is_active'] = true;

        try {
            // 3. SIMPAN DATA KE DATABASE
            $job = Job::create($validatedData);

            // 4. KEMBALIKAN RESPONS (REDIRECT)
            return redirect()
                ->route('companyDashboardPage') 
                ->with('success', 'Lowongan pekerjaan "' . $job->title . '" berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput() 
                ->with('error', 'Gagal membuat lowongan pekerjaan. Error: ' . $e->getMessage());
        }
    }
}
