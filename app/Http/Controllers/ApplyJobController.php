<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Models\Job;

class ApplyJobController extends Controller
{
    public function index(Job $job) {
        return view('pages.apply.index', ['job' => $job]);
    }

    public function store(StoreApplicationRequest $request){
        $data = $request->validated();

        if ($request->hasFile('cv_url')) {
            $data['cv_url'] = $request->file('cv_url')->store('cvs', 'public');
        }

        Application::create([
            'user_id' => $data['user_id'],
            'job_id' => $data['job_id'],
            'applicant_email' => $data['applicant_email'],
            'applicant_phone' => $data['applicant_phone'],
            'cv_url' => $data['cv_url'],
        ]);

        return redirect()->route('homePage')->with('success', 'Lamaran berhasil dikirim. Terima kasih telah melamar!');
    }

}
