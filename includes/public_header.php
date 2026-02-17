<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Professional Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .nav-link { position: relative; }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #0B3C5D;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.03); }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#0B3C5D',
                            light: '#1d4e6f',
                            dark: '#082d46',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-gray-800">

    <!-- Public Navbar -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="index.php" class="flex items-center gap-2">
                    <div class="bg-navy p-1.5 rounded-lg text-white">
                        <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                    </div>
                    <span class="text-2xl font-bold text-navy tracking-tight">LMS<span class="text-blue-500">Core</span></span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="index.php" class="nav-link text-navy font-semibold">Home</a>
                    <a href="about.php" class="nav-link text-navy font-semibold">About</a>
                    <a href="public-timetable.php" class="nav-link text-navy font-semibold">Timetable</a>
                    <a href="all-classes.php" class="nav-link text-navy font-semibold">Classes</a>
                    <div class="h-6 w-px bg-gray-200 mx-2"></div>
                    <a href="login.php" class="text-navy font-bold hover:text-navy-light transition-colors">Login</a>
                    <a href="register.php" class="bg-navy text-white px-6 py-2.5 rounded-xl font-bold hover:bg-navy-dark transition-all shadow-lg shadow-navy/20">Register</a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button onclick="toggleMobileMenu()" class="p-2 text-navy">
                        <i data-lucide="menu" id="menu-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-gray-100 absolute w-full left-0 shadow-xl transition-all">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="index.php" class="block px-4 py-3 text-navy font-bold hover:bg-gray-50 rounded-xl">Home</a>
                <a href="about.php" class="block px-4 py-3 text-navy font-bold hover:bg-gray-50 rounded-xl">About</a>
                <a href="public-timetable.php" class="block px-4 py-3 text-navy font-bold hover:bg-gray-50 rounded-xl">Timetable</a>
                <a href="all-classes.php" class="block px-4 py-3 text-navy font-bold hover:bg-gray-50 rounded-xl">Classes</a>
                <hr class="my-4 border-gray-100">
                <a href="login.php" class="block px-4 py-3 text-navy font-bold">Login</a>
                <a href="register.php" class="block px-4 py-3 bg-navy text-white text-center font-bold rounded-xl mt-4">Register Now</a>
            </div>
        </div>
    </nav>
