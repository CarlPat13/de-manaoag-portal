<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Schedule;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class FacultyController extends Controller
{
    public function showLogin()
    {
        return view('auth.faculty-login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => ['required', new Recaptcha],
        ]);

        $field = filter_var($validated['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'faculty_id';

        if (Auth::guard('faculty')->attempt([
            $field => $validated['login'],
            'password' => $validated['password'],
        ])) {
            $request->session()->regenerate();
            return redirect()->route('faculty.dashboard')->with('success', 'Welcome, Faculty!');
        }

        return back()->withErrors(['login' => 'Invalid credentials.']);
    }

    public function dashboard()
    {
        $faculty = Auth::guard('faculty')->user();
        return view('faculty.dashboard', compact('faculty'));
    }

    public function profile()
    {
        return view('faculty.profile', ['faculty' => Auth::guard('faculty')->user()]);
    }

    public function subjects()
    {
        $faculty = Auth::guard('faculty')->user();
        return view('faculty.subjects', compact('faculty'));
    }

    public function students()
    {
        $faculty = Auth::guard('faculty')->user();
        return view('faculty.students', compact('faculty'));
    }

    public function grades(Request $request)
    {
        $faculty = Auth::guard('faculty')->user();
        return view('faculty.grades', compact('faculty'));
    }

    public function updateGrades(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string',
            'subject_code' => 'required|string',
            'midterm' => 'nullable|numeric|min:5|max:100',
            'final' => 'nullable|numeric|min:5|max:100',
        ]);

        // Update or create grade record
        Grade::updateOrCreate(
            ['student_id' => $validated['student_id'], 'subject_code' => $validated['subject_code']],
            ['midterm' => $validated['midterm'], 'final' => $validated['final']]
        );

        return back()->with('success', 'Grades updated successfully!');
    }

    public function schedule()
    {
        $faculty = Auth::guard('faculty')->user();
        return view('faculty.schedule', compact('faculty'));
    }

    public function logout(Request $request)
    {
        Auth::guard('faculty')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('faculty.login')->with('success', 'Logged out successfully.');
    }
}