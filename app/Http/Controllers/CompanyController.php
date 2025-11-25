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
        $jobs = Job::where('company_id', Auth::user()->company->id)->get();

        return view('company-pages.lowongan.index', [
            'jobs' => $jobs,
        ]);
    }

    public function indexCreate() {
        $workMethods = WorkMethod::all();
        $workTypes = WorkType::all();
        $industries = Industry::all();

        return view('company-pages.create-lowongan.index', compact('workMethods','workTypes','industries'));
    }

    public function indexApplicants(Job $job) {
        // Pastikan job tersebut milik perusahaan user yang sedang login
        if ($job->company_id !== Auth::user()->company->id) {
            return redirect()
                ->route('companyDashboardPage')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Muat aplikasi beserta data pelamar
        $applications = $job->applications()->with('user')->get();

        return view('company-pages.pelamar.index', [
            'job' => $job,
            'applications' => $applications,
        ]);
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

    public function toggleStatus(Request $request, Job $job)
    {
        if (Auth::user()->company->id !== $job->company_id) { 
            abort(403, 'Anda tidak diizinkan mengubah status lowongan ini.');
        }

        $request->validate([
            'is_active' => 'required|boolean',
        ]);
        
        $newStatus = $request->input('is_active');
        $oldTitle = $job->title;

        try {
            $job->update([
                'is_active' => $newStatus,
            ]);

            $message = $newStatus 
                       ? "Lowongan '{$oldTitle}' berhasil diaktifkan."
                       : "Lowongan '{$oldTitle}' berhasil dinonaktifkan.";

            return redirect()
                ->back()
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengubah status lowongan: ' . $e->getMessage());
        }
    }
}
