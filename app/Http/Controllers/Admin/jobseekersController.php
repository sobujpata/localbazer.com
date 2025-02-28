<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class jobseekersController extends Controller
{
    public function JobseekersPage(){
        return view('pages.dashboard.jobseekers');
    }

    public function JobseekersList(){
        $jobseekers = JobApplication::with('user')->get();

        return response()->json($jobseekers);
    }
}
