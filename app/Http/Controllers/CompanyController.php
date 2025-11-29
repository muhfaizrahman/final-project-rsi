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
}
