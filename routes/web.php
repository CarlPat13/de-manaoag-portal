<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortalController;

// === PUBLIC ROUTES ===
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/register', [PortalController::class, 'showRegistration'])->name('register');
Route::post('/register', [PortalController::class, 'register']);
Route::get('/login', [PortalController::class, 'showLogin'])->name('login');
Route::post('/login', [PortalController::class, 'login']);
Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

// === PROTECTED ROUTES ===
Route::middleware('auth')->group(function () {
    // Student & Common Routes
    Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PortalController::class, 'profile'])->name('profile');
    Route::get('/schedule', [PortalController::class, 'schedule'])->name('schedule');
    Route::get('/grades', [PortalController::class, 'grades'])->name('grades');
    Route::get('/subjects', [PortalController::class, 'subjects'])->name('subjects');
    Route::get('/announcements', [PortalController::class, 'announcements'])->name('announcements');
    
    Route::get('/change-password', [PortalController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [PortalController::class, 'updatePassword'])->name('password.update');
    
    // Faculty Routes
    Route::get('/faculty/dashboard', [PortalController::class, 'facultyDashboard'])->name('faculty.dashboard');
    Route::get('/faculty/schedule', [PortalController::class, 'facultySchedule'])->name('faculty.schedule');
    Route::get('/faculty/announcements', function () {
        return view('faculty.announcements', [
            'announcements' => \App\Models\Announcement::latest()->get()
        ]);
    })->name('faculty.announcements');
    
    // Admin Routes
    Route::get('/admin/dashboard', [PortalController::class, 'adminDashboard'])->name('admin.dashboard');
    
    Route::get('/admin/users', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        return view('admin.users', [
            'students' => \App\Models\Student::with('user')->latest()->get(),
            'faculties' => \App\Models\Faculty::with('user')->latest()->get(),
            'admins' => \App\Models\Admin::with('user')->latest()->get()
        ]);
    })->name('admin.users');
    
    Route::get('/admin/subjects', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        return view('admin.subjects', ['subjects' => \App\Models\Subject::latest()->get()]);
    })->name('admin.subjects');
    
    Route::post('/admin/subjects', function (\Illuminate\Http\Request $request) {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        $validated = $request->validate([
            'code'        => 'required|string|max:50|unique:subjects,code',
            'name'        => 'required|string|max:255',
            'units'       => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
        ]);
        \App\Models\Subject::create($validated);
        return redirect()->route('admin.subjects')->with('success', 'Subject added successfully!');
    })->name('admin.subjects.store');
    
    Route::put('/admin/subjects/{subject}', function (\Illuminate\Http\Request $request, \App\Models\Subject $subject) {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        $validated = $request->validate([
            'code'        => 'required|string|max:50|unique:subjects,code,'.$subject->id,
            'name'        => 'required|string|max:255',
            'units'       => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
        ]);
        $subject->update($validated);
        return redirect()->route('admin.subjects')->with('success', 'Subject updated successfully!');
    })->name('admin.subjects.update');
    
    Route::delete('/admin/subjects/{subject}', function (\App\Models\Subject $subject) {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        $subject->delete();
        return redirect()->route('admin.subjects')->with('success', 'Subject deleted successfully!');
    })->name('admin.subjects.destroy');
    
    // ✅ FIXED: Tinanggal ang enrollments sa with() — sanhi ng 500 error!
    Route::get('/admin/classes', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        return view('admin.classes', [
            'classes'   => \App\Models\ClassModel::with(['subject', 'faculty'])->latest()->get(),
            'subjects'  => \App\Models\Subject::latest()->get(),
            'faculties' => \App\Models\Faculty::latest()->get()
        ]);
    })->name('admin.classes');
    
    Route::post('/admin/classes', function (\Illuminate\Http\Request $request) {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        $validated = $request->validate([
            'code'        => 'required|string|max:50',
            'subject_id'  => 'required|exists:subjects,id',
            'faculty_id'  => 'required|exists:faculties,id',
            'room'        => 'nullable|string|max:100',
            'schedule'    => 'nullable|string',
            'year_level'  => 'required|integer|min:1|max:4',
            'description' => 'nullable|string',
        ]);
        \App\Models\ClassModel::create($validated);
        return redirect()->route('admin.classes')->with('success', 'Class created successfully!');
    })->name('admin.classes.store');
    
    Route::get('/admin/enrollments', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        return view('admin.enrollments', [
            'classes'     => \App\Models\ClassModel::with(['subject', 'faculty'])->latest()->get(),
            'students'    => \App\Models\Student::latest()->get(),
            'faculties'   => \App\Models\Faculty::latest()->get(),
            'enrollments' => \App\Models\Enrollment::with(['student', 'class.faculty'])->latest()->get()
        ]);
    })->name('admin.enrollments');
    
    Route::post('/admin/enrollments', function (\Illuminate\Http\Request $request) {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,id',
            'class_id'    => 'required|exists:classes,id',
            'faculty_id'  => 'nullable|exists:faculties,id',
        ]);
        $class = \App\Models\ClassModel::findOrFail($validated['class_id']);
        $finalFacultyId = $validated['faculty_id'] ?? $class->faculty_id;
        \App\Models\Enrollment::firstOrCreate(
            ['student_id' => $validated['student_id'], 'class_id' => $validated['class_id']]
        );
        if ($finalFacultyId && !$class->faculty_id) {
            $class->update(['faculty_id' => $finalFacultyId]);
            $message = 'Student enrolled & instructor assigned!';
        } elseif ($finalFacultyId && $class->faculty_id != $finalFacultyId) {
            $class->update(['faculty_id' => $finalFacultyId]);
            $message = 'Student enrolled & instructor updated!';
        } else {
            $message = 'Student enrolled successfully!';
        }
        return redirect()->route('admin.enrollments')->with('success', $message);
    })->name('admin.enrollments.store');
    
    Route::delete('/admin/enrollments/{enrollment}', function (\App\Models\Enrollment $enrollment) {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        $enrollment->delete();
        return redirect()->route('admin.enrollments')->with('success', 'Enrollment removed.');
    })->name('admin.enrollments.destroy');
    
    Route::get('/admin/announcements', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        return view('admin.announcements', ['announcements' => \App\Models\Announcement::latest()->get()]);
    })->name('admin.announcements');
    
    Route::get('/admin/announcements/create', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        return view('admin.announcement-create');
    })->name('admin.announcements.create');
    
    Route::post('/admin/announcements', function (\Illuminate\Http\Request $request) {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string'
        ]);
        \App\Models\Announcement::create([
            'title'     => $validated['title'],
            'content'   => $validated['content'],
            'admin_id'  => auth()->id()
        ]);
        return redirect()->route('admin.announcements')->with('success', 'Announcement posted successfully!');
    })->name('admin.announcements.store');
    
    Route::get('/admin/announcements/{announcement}/edit', function (\App\Models\Announcement $announcement) {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        return view('admin.announcement-edit', compact('announcement'));
    })->name('admin.announcements.edit');
    
    Route::put('/admin/announcements/{announcement}', function (\Illuminate\Http\Request $request, \App\Models\Announcement $announcement) {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string'
        ]);
        $announcement->update($validated);
        return redirect()->route('admin.announcements')->with('success', 'Announcement updated successfully!');
    })->name('admin.announcements.update');
    
    Route::delete('/admin/announcements/{announcement}', function (\App\Models\Announcement $announcement) {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }
        $announcement->delete();
        return redirect()->route('admin.announcements')->with('success', 'Announcement deleted successfully!');
    })->name('admin.announcements.destroy');
});