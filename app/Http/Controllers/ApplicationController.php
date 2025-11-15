<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(StoreApplicationRequest $request){
        $data = $request->validated();

        if ($request->hasFile('cv')) {
            $data['cv_url'] = $request->file('cv')->store('cvs', 'public');
        }

        Application::create([
            'user_id' => $data['user_id'],
            'job_id' => $data['job_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'applicant_email' => $data['applicant_email'],
            'applicant_phone' => $data['applicant_phone'],
            'domicile' => $data['domicile'],
            'cv_url' => $data['cv_url'],
        ]);

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim. Terima kasih telah melamar!');
    }

    public function showApplicationForm(Job $job) {
        return view('pages.apply.index', ['job' => $job]);
    }

}
