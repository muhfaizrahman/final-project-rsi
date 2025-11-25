<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function index() {
        return view('company-pages.lowongan.index', [

        ]);
    }

    public function indexCreate() {
        return view('company-pages.create-lowongan.index');
    }

    public function createJob() {
        
    }
}
