<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        return view('dashboards.student', compact('student'));
    }
}
