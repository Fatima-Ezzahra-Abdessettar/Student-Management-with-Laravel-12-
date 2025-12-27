<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $latestStudents = Student::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalStudents', 'latestStudents'));
    }
}
