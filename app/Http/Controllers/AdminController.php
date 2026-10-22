<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Announcement;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => ['required', new Recaptcha],
        ]);

        $field = filter_var($validated['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'admin_id';

        if (Auth::guard('admin')->attempt([
            $field => $validated['login'],
            'password' => $validated['password'],
        ])) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Welcome, Administrator!');
        }

        return back()->withErrors(['login' => 'Invalid credentials.']);
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        $stats = [
            'students' => Student::count(),
            'faculty' => Faculty::count(),
            'announcements' => Announcement::count(),
        ];
        return view('admin.dashboard', compact('admin', 'stats'));
    }

    public function users()
    {
        return view('admin.users');
    }

    public function students()
    {
        return view('admin.students');
    }

    public function faculty()
    {
        return view('admin.faculty');
    }

    public function courses()
    {
        return view('admin.courses');
    }

    public function announcements()
    {
        return view('admin.announcements');
    }

    public function storeAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Announcement published!');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}