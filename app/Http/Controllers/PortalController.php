<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Admin;
use App\Models\Announcement;
use App\Models\ClassModel;
use App\Models\Enrollment;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    // === AUTHENTICATION ===
    public function showRegistration()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email|max:100',
            'phone'      => 'nullable|string|digits:11|starts_with:09',
            'course'     => 'required|string|max:100',
            'year_level' => 'required|integer|min:1|max:4',
            'address'    => 'nullable|string|max:500',
            'password'   => 'required|string|min:8|confirmed',
            'g-recaptcha-response' => ['required', new Recaptcha],
        ], [
            'year_level.max' => 'Year Level can only be from 1st to 4th Year.',
            'email.unique'   => 'This email is already registered.',
        ]);

        $latestStudent = Student::orderByDesc('student_id')->first();
        $nextNumber = ($latestStudent && preg_match('/(\d+)$/', $latestStudent->student_id, $m))
            ? intval($m[1]) + 1
            : 1;

        $studentId = date('Y') . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        $fullName = trim($validated['first_name'] . ' '
            . ($validated['middle_name'] ? $validated['middle_name'].' ' : '')
            . $validated['last_name']);

        $user = User::create([
            'name' => $fullName,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $user->id,
            'student_id' => $studentId,
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'course' => $validated['course'],
            'year_level' => $validated['year_level'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('login')
            ->with('success', "Registration successful! Your Student ID: {$studentId}. Please login.");
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:student,faculty,admin',
            'g-recaptcha-response' => ['required', new Recaptcha],
        ], [
            'role.required' => 'Please select your role.',
        ]);

        $isEmail = filter_var($validated['login'], FILTER_VALIDATE_EMAIL);
        
        if ($isEmail) {
            $credentials = [
                'email' => $validated['login'],
                'password' => $validated['password'],
                'role' => $validated['role']
            ];
        } else {
            $record = null;
            $notFoundMsg = '';
            
            if ($validated['role'] === 'student') {
                $record = Student::where('student_id', $validated['login'])->first();
                $notFoundMsg = 'Student ID not found.';
            } elseif ($validated['role'] === 'faculty') {
                $record = Faculty::where('faculty_id', $validated['login'])->first();
                $notFoundMsg = 'Faculty ID not found.';
            } elseif ($validated['role'] === 'admin') {
                $record = Admin::where('admin_id', $validated['login'])->first();
                $notFoundMsg = 'Admin ID not found.';
            }

            if (!$record) {
                return back()->withErrors(['login' => $notFoundMsg]);
            }

            $credentials = [
                'id' => $record->user_id,
                'password' => $validated['password'],
                'role' => $validated['role']
            ];
        }

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            $route = match(Auth::user()->role) {
                'student' => 'dashboard',
                'faculty' => 'faculty.dashboard',
                'admin'   => 'admin.dashboard',
                default   => 'login'
            };
            
            $message = match(Auth::user()->role) {
                'student' => 'Welcome, Student!',
                'faculty' => 'Welcome, Faculty Member!',
                'admin'   => 'Welcome, Administrator!',
                default   => 'Welcome!'
            };
            
            return redirect()->route($route)->with('success', $message);
        }

        return back()->withErrors(['login' => 'Incorrect credentials or selected role.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    // === CHANGE PASSWORD ===
    public function showChangePassword()
    {
        return view('portal.change-password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ], [
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.confirmed' => 'New password confirmation does not match.',
        ]);

        $user = Auth::user();
        
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        $redirectRoute = match($user->role) {
            'student' => 'profile',
            'faculty' => 'faculty.dashboard',
            'admin'   => 'admin.dashboard',
            default   => 'login'
        };

        return redirect()->route($redirectRoute)
            ->with('success', 'Password changed successfully!');
    }

    // === STUDENT PAGES ===
    public function dashboard()
    {
        $user = Auth::user();
        
        if (!$user || !$user->student) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['login' => 'Student account not found.']);
        }

        $enrollments = Enrollment::where('student_id', $user->student->id)
            ->with(['class.subject', 'class.faculty'])
            ->latest()
            ->get();

        $announcements = Announcement::latest()->limit(3)->get();

        return view('portal.dashboard', [
            'user' => $user,
            'student' => $user->student,
            'enrollments' => $enrollments,
            'announcements' => $announcements
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->student) {
            return view('portal.profile', ['student' => $user->student, 'user' => $user]);
        } elseif ($user->faculty) {
            return view('faculty.profile', ['faculty' => $user->faculty, 'user' => $user]);
        } elseif ($user->admin) {
            return view('admin.profile', ['admin' => $user->admin, 'user' => $user]);
        }

        return redirect()->route('login');
    }

    public function schedule()
    {
        $student = Auth::user()->student;
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['class.subject', 'class.faculty'])
            ->get();

        return view('portal.schedule', [
            'student' => $student,
            'enrollments' => $enrollments
        ]);
    }

    public function grades()
    {
        $student = Auth::user()->student;
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['class.subject', 'class.faculty'])
            ->get();

        return view('portal.grades', [
            'student' => $student,
            'enrollments' => $enrollments
        ]);
    }

    public function subjects()
    {
        $student = Auth::user()->student;
        
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['class.subject', 'class.faculty'])
            ->get();

        $mySubjects = $enrollments->map(function ($enroll) {
            $class = $enroll->class;
            
            if (!$class) {
                return [
                    'code'     => 'N/A',
                    'name'     => 'Class Not Found',
                    'units'    => 3,
                    'schedule' => '-',
                    'room'     => '-',
                    'faculty'  => 'Not Assigned',
                    'status'   => 'Ongoing',
                    'grade'    => null,
                ];
            }

            $subject = $class->subject;
            $faculty = $class->faculty;

            return [
                'code'     => $subject?->code ?? 'N/A',
                'name'     => $subject?->name ?? 'N/A',
                'units'    => $subject?->units ?? 3,
                'schedule' => $class->schedule ?? '-',
                'room'     => $class->room ?? 'Not Assigned',
                'faculty'  => $faculty ? $faculty->first_name . ' ' . $faculty->last_name : 'Not Assigned',
                'status'   => $enroll->grade ? 'Completed' : 'Ongoing',
                'grade'    => $enroll->grade,
            ];
        });

        return view('portal.subjects', compact('mySubjects'));
    }

    public function announcements()
    {
        return view('portal.announcements', [
            'announcements' => Announcement::latest()->get()
        ]);
    }

    // === FACULTY PAGES ===
    public function facultyDashboard()
    {
        $user = Auth::user();
        
        $faculty = Faculty::where('user_id', $user->id)->first();
        
        if (!$faculty) {
            return "⚠️ No Faculty record found for this account. Please contact Admin.";
        }
        
        $classes = ClassModel::where('faculty_id', $faculty->id)
            ->with(['subject'])
            ->latest()
            ->get();
        
        return view('faculty.dashboard', compact('faculty', 'classes'));
    }

    public function classStudents($classId)
    {
        try {
            $user = Auth::user();
            
            if (!$user || $user->role !== 'faculty') {
                return redirect()->route('login')->withErrors(['login' => 'Faculty account required.']);
            }
            
            $faculty = Faculty::where('user_id', $user->id)->first();
            if (!$faculty) {
                return "⚠️ Faculty record not found.";
            }
            
            $class = ClassModel::where('id', $classId)
                ->where('faculty_id', $faculty->id)
                ->with(['enrollments.student'])
                ->firstOrFail();
            
            return view('faculty.class-students', compact('class'));
            
        } catch (\Exception $e) {
            return "🔥 Error: " . $e->getMessage();
        }
    }

    public function storeGrade(Request $request, $enrollmentId)
    {
        $validated = $request->validate([
            'grade' => 'nullable|numeric|min:1.0|max:5.0',
        ], [
            'grade.min' => 'Grade must be at least 1.0.',
            'grade.max' => 'Grade must not exceed 5.0.',
        ]);

        $user = Auth::user();
        
        if (!$user || $user->role !== 'faculty') {
            return redirect()->route('login');
        }
        
        $faculty = Faculty::where('user_id', $user->id)->first();
        if (!$faculty) {
            return "⚠️ Faculty record not found.";
        }
        
        $enrollment = Enrollment::findOrFail($enrollmentId);
        $enrollment->load('class');
        
        if (!$enrollment->class || $enrollment->class->faculty_id !== $faculty->id) {
            abort(403, 'Not authorized.');
        }
        
        $enrollment->grade = $validated['grade'];
        $enrollment->remarks = $validated['grade']
            ? ($validated['grade'] <= 3.0 ? 'Passed' : 'Failed')
            : null;
        
        $enrollment->save();
        
        return back()->with('success', 'Grade saved successfully! ✅');
    }

    // === ADMIN DASHBOARD ===
    public function adminDashboard()
    {
        try {
            $user = Auth::user();
            
            if (!$user || $user->role !== 'admin') {
                auth()->logout();
                return redirect()->route('login')->withErrors(['login' => 'Admin account required.']);
            }
            
            $admin = Admin::where('user_id', $user->id)->first();
            if (!$admin) {
                return "⚠️ Admin record not found. User ID: {$user->id}";
            }
            
            return view('admin.dashboard', [
                'admin' => $admin,
                'stats' => [
                    'students' => Student::count(),
                    'faculty'  => Faculty::count(),
                    'admins'   => Admin::count(),
                ]
            ]);
            
        } catch (\Exception $e) {
            return "🔥 Error: " . $e->getMessage();
        }
    }
}