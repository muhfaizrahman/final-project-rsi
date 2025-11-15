<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index() {
        $jobs = Job::with('company')->latest()->get();
        return view('pages.home.index', ['jobs' => $jobs]);
    }
}
