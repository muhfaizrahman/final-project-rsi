<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Job;
use App\Models\ProfileCompany;
use App\Models\WorkMethod;
use App\Models\WorkType;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class JobSearchAndFilterController extends Controller
{
    public function index(Request $request) 
    {
        // --- 1. Ambil Input & Opsi Filter ---
        $keyword = $request->input('keyword');
        $selectedJobId = $request->input('job_id'); 
        
        // Ambil input filter
        $filterWorkTypeId = $request->input('work_type_id');
        $filterWorkMethodId = $request->input('work_method_id');
        $filterCity = $request->input('city');
        $filterIndustryId = $request->input('industry_id');
        
        // Ambil daftar opsi untuk dropdown filter (hanya kota unik dari jobs yang ada)
        $availableCities = ProfileCompany::select('city')->distinct()->pluck('city');
        $workTypes = WorkType::all();
        $workMethods = WorkMethod::all();
        $industries = Industry::all();

        // --- 2. Bangun Query Pekerjaan ---
        $jobsQuery = Job::with(['company', 'workMethod', 'workType', 'industry'])->latest(); 
        $jobsQuery->join('profile_companies as pc', 'jobs.company_id', '=', 'pc.id');
        $jobsQuery->where('jobs.is_active', true);
        
        $userId = Auth::id();
        $jobsQuery->whereDoesntHave('applications', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        // Terapkan filter keyword
        if ($keyword) {
            $jobsQuery->where('title', 'like', '%' . $keyword . '%');
        }


        // Terapkan filter kategori
        if ($filterWorkTypeId) {
            $jobsQuery->where('work_type_id', $filterWorkTypeId);
        }
        if ($filterWorkMethodId) {
            $jobsQuery->where('work_method_id', $filterWorkMethodId);
        }
        if ($filterCity) {
            $jobsQuery->where('pc.city', $filterCity); 
        }
        if ($filterIndustryId) {
            $jobsQuery->where('industry_id', $filterIndustryId);
        }
        
        $jobs = $jobsQuery->select('jobs.*')->get();
        
        // --- 3. Logika Detail Pekerjaan ---
        $selectedJob = null;
        if ($selectedJobId) {
            $selectedJob = Job::with(['company', 'workMethod', 'workType', 'industry'])->find($selectedJobId);
        }
        
        // --- 4. Kirim Data ke View ---
        return view('pages.home.index', [
            'jobs' => $jobs,
            'search' => $keyword,
            'selectedJobId' => $selectedJobId,
            'selectedJob' => $selectedJob,
            
            // Variabel Filter Tambahan
            'workTypes' => $workTypes,
            'workMethods' => $workMethods,
            'industries' => $industries,
            'availableCities' => $availableCities,

            // Input Filter yang Sedang Aktif
            'filterWorkTypeId' => $filterWorkTypeId,
            'filterWorkMethodId' => $filterWorkMethodId,
            'filterCity' => $filterCity,
            'filterIndustryId' => $filterIndustryId,
        ]);
    }
}
