<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        
        $jobsQuery = $user->bookmarks()->with(['company', 'workMethod']); 

        $jobs = $jobsQuery->latest()->get(); 
        
        $selectedJobId = $request->input('job_id');
        $selectedJob = null;

        if ($selectedJobId) {
            // Ambil detail pekerjaan yang dipilih dari daftar bookmark user
            $selectedJob = $user->bookmarks()->where('job_id', $selectedJobId)
                                            ->with(['company', 'workMethod', 'workType', 'industry'])
                                            ->first();
        }

        return view('pages.bookmark.index', [
            'jobs' => $jobs,
            'selectedJobId' => $selectedJobId,
            'selectedJob' => $selectedJob,
        ]);
    }

    public function toggle(Job $job) {
        $user = Auth::user();

        $user->bookmarks()->toggle($job->id);

        $isBookmarked = $user->bookmarks()->where('job_id', $job->id)->exists();

        
        return back()->with([
            'is_bookmarked' => $isBookmarked,
        ]);
    }
}