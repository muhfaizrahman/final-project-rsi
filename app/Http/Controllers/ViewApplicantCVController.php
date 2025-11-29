<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ViewApplicantCVController extends Controller
{
    public function index(Application $application) {
        $path = $application->cv_url;
        $url = Storage::disk('public')->url($path);
        return redirect($url);
    }
}
