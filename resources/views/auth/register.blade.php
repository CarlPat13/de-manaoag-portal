<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - De Manaoag University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            min-height: 100vh;
            background:
                linear-gradient(rgba(15, 23, 42, 0.78),
                                rgba(15, 23, 42, 0.85)),
                url("{{ asset('images/bg-campus.jpg') }}")
                center/cover no-repeat fixed;
        }
        .register-card {
            width: min(1100px, 95%);
            margin: 30px auto;
            display: grid;
            grid-template-columns: 0.85fr 1.4fr;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        }
        .university-panel {
            background: linear-gradient(145deg, #172554, #1e40af);
            color: white;
            padding: 40px 28px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .university-logo {
            width: 155px;
            height: 155px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            margin-bottom: 25px;
        }
        .form-panel {
            padding: 30px 35px;
        }
        .form-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }
        @media (max-width: 700px) {
            .register-card {
                grid-template-columns: 1fr;
                margin: 15px auto;
            }
            .university-panel {
                padding: 25px 20px;
            }
            .university-logo {
                width: 100px;
                height: 100px;
                margin-bottom: 12px;
            }
            .form-panel {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body class="flex items-center justify-center">
    <main class="register-card">
        <!-- LEFT PANEL: UNIVERSITY INFORMATION -->
        <section class="university-panel">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="De Manaoag University Logo"
                class="university-logo"
            >
            <h1 class="text-2xl font-bold tracking-wide">
                DE MANAOAG UNIVERSITY
            </h1>
            <div class="w-20 h-1 bg-white rounded-full my-5"></div>
            <h2 class="text-lg font-semibold mb-3">
                Student Registration
            </h2>
            <p class="text-sm text-blue-100 leading-6 max-w-xs">
                Welcome to De Manaoag University. Create your student
                account to begin your academic journey with us.
            </p>
            <div class="mt-8 text-xs text-blue-200">
                QUALITY EDUCATION • EXCELLENCE • SERVICE
            </div>
        </section>

        <!-- RIGHT PANEL: REGISTRATION FORM -->
        <section class="form-panel">
            <div class="mb-5">
                <h2 class="text-2xl font-bold text-blue-950">
                    Create Your Account
                </h2>
                <p class="text-gray-500 text-sm mt-1">
                    Fill in your details to register.
                    Fields marked with * are required.
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700
                            p-3 rounded-lg mb-4 text-sm">
                    @foreach ($errors->all() as $error)
                        <p class="mb-1">⚠️ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3">
                    <!-- FIRST NAME -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            First Name *
                        </label>
                        <input
                            type="text"
                            name="first_name"
                            required
                            autocomplete="given-name"
                            value="{{ old('first_name') }}"
                            class="form-input"
                            placeholder="Enter first name"
                        >
                    </div>

                    <!-- MIDDLE NAME -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Middle Name
                        </label>
                        <input
                            type="text"
                            name="middle_name"
                            autocomplete="additional-name"
                            value="{{ old('middle_name') }}"
                            class="form-input"
                            placeholder="Enter middle name"
                        >
                    </div>

                    <!-- LAST NAME -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Last Name *
                        </label>
                        <input
                            type="text"
                            name="last_name"
                            required
                            autocomplete="family-name"
                            value="{{ old('last_name') }}"
                            class="form-input"
                            placeholder="Enter last name"
                        >
                    </div>

                    <!-- PHONE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number
                        </label>
                        <input
                            type="tel"
                            name="phone"
                            autocomplete="tel"
                            value="{{ old('phone') }}"
                            pattern="09[0-9]{9}"
                            maxlength="11"
                            class="form-input"
                            placeholder="09XXXXXXXXX"
                        >
                    </div>

                    <!-- EMAIL -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email Address *
                        </label>
                        <input
                            type="email"
                            name="email"
                            required
                            autocomplete="email"
                            value="{{ old('email') }}"
                            class="form-input"
                            placeholder="Enter your email address"
                        >
                    </div>

                    <!-- COURSE — DROPDOWN -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Course *
                        </label>
                        <select
                            name="course"
                            required
                            class="form-input bg-white"
                        >
                            <option value="">Select Your Course</option>
                            <option value="BSIT" {{ old('course') == 'BSIT' ? 'selected' : '' }}>
                                Bachelor of Science in Information Technology (BSIT)
                            </option>
                            <option value="BSCS" {{ old('course') == 'BSCS' ? 'selected' : '' }}>
                                Bachelor of Science in Computer Science (BSCS)
                            </option>
                            <option value="BSBA" {{ old('course') == 'BSBA' ? 'selected' : '' }}>
                                Bachelor of Science in Business Administration (BSBA)
                            </option>
                            <option value="BEEd" {{ old('course') == 'BEEd' ? 'selected' : '' }}>
                                Bachelor of Elementary Education (BEEd)
                            </option>
                            <option value="BSEd" {{ old('course') == 'BSEd' ? 'selected' : '' }}>
                                Bachelor of Secondary Education (BSEd)
                            </option>
                            <option value="BSHM" {{ old('course') == 'BSHM' ? 'selected' : '' }}>
                                Bachelor of Science in Hospitality Management (BSHM)
                            </option>
                            <option value="BSCrim" {{ old('course') == 'BSCrim' ? 'selected' : '' }}>
                                Bachelor of Science in Criminology (BSCrim)
                            </option>
                            <option value="AB" {{ old('course') == 'AB' ? 'selected' : '' }}>
                                Bachelor of Arts in Political Science (AB PolSci)
                            </option>
                            <option value="OTHER" {{ old('course') == 'OTHER' ? 'selected' : '' }}>
                                Other / Not Listed
                            </option>
                        </select>
                    </div>

                    <!-- YEAR LEVEL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Year Level *
                        </label>
                        <select
                            name="year_level"
                            required
                            class="form-input bg-white"
                        >
                            <option value="">Select Year Level</option>
                            <option value="1" {{ old('year_level') == '1' ? 'selected' : '' }}>
                                1st Year
                            </option>
                            <option value="2" {{ old('year_level') == '2' ? 'selected' : '' }}>
                                2nd Year
                            </option>
                            <option value="3" {{ old('year_level') == '3' ? 'selected' : '' }}>
                                3rd Year
                            </option>
                            <option value="4" {{ old('year_level') == '4' ? 'selected' : '' }}>
                                4th Year
                            </option>
                        </select>
                    </div>

                    <!-- ADDRESS -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Complete Address
                        </label>
                        <textarea
                            name="address"
                            rows="2"
                            autocomplete="street-address"
                            class="form-input resize-none"
                            placeholder="House number, barangay, municipality, province"
                        >{{ old('address') }}</textarea>
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password *
                        </label>
                        <input
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            minlength="8"
                            class="form-input"
                            placeholder="Create a password"
                        >
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm Password *
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            minlength="8"
                            class="form-input"
                            placeholder="Confirm password"
                        >
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <div
                        class="g-recaptcha"
                        data-sitekey="6Lcbl_wtAAAAAKQkrZu8ZUUhWCZYT06UrkLL59NQ">
                    </div>
                </div>

                <!-- REGISTER BUTTON -->
                <button
                    type="submit"
                    class="w-full mt-4 bg-blue-900 text-white py-3
                           rounded-lg font-semibold text-sm
                           hover:bg-blue-800 transition duration-200
                           shadow-md"
                >
                    REGISTER ACCOUNT
                </button>
            </form>

            <p class="text-center mt-4 text-sm text-gray-600">
                Already have an account?
                <a
                    href="{{ route('login') }}"
                    class="text-blue-900 font-semibold hover:underline"
                >
                    Login here
                </a>
            </p>
        </section>
    </main>
</body>
</html>