<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student LMS - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        .hover-lift {
            transition: transform 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
        }
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
<body class="bg-gray-50 text-gray-800">
    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

    <!-- Top Navbar -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-navy text-white flex items-center justify-between px-4 md:px-6 z-50 shadow-md">
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()" class="p-2 hover:bg-navy-light rounded-lg md:hidden">
                <i data-lucide="menu"></i>
            </button>
            <div class="flex items-center gap-2">
                <div class="bg-white p-1 rounded-lg">
                    <i data-lucide="graduation-cap" class="text-navy w-6 h-6"></i>
                </div>
                <span class="text-xl font-bold tracking-tight">LMS<span class="text-blue-300">Student</span></span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden md:flex flex-col items-end mr-2 text-sm">
                <span class="font-semibold uppercase leading-none">John Doe</span>
                <span class="text-blue-200 text-xs">Student ID: #ST-12345</span>
            </div>
            
            <div class="relative group">
                <button class="flex items-center gap-2 p-1 border-2 border-transparent hover:border-blue-300 rounded-full transition-all">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=FFFFFF&color=0B3C5D" alt="Profile" class="w-8 h-8 rounded-full border border-gray-200">
                    <i data-lucide="chevron-down" class="w-4 h-4 hidden md:block"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 hidden group-hover:block transition-all transform origin-top-right">
                    <a href="profile.php" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-navy transition-colors">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span>My Profile</span>
                    </a>
                    <a href="settings.php" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-navy transition-colors">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                        <span>Settings</span>
                    </a>
                    <hr class="my-2 border-gray-100">
                    <a href="logout.php" class="flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="flex min-h-screen pt-16">
