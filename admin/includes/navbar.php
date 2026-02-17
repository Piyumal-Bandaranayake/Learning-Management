<?php
$title_map = [
    'dashboard.php' => 'Dashboard Overview',
    'manage-courses.php' => 'Manage Course Catalog',
    'add-course.php' => 'Create New Course',
    'registrations.php' => 'Student Enrollment Requests',
    'students.php' => 'Student Directory',
    'reports.php' => 'Analytics & Reports'
];
$page_title = $title_map[basename($_SERVER['PHP_SELF'])] ?? 'Admin Panel';
?>
<div class="flex-1 flex flex-col min-w-0">
    <!-- Top Navbar -->
    <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-4 md:px-8 sticky top-0 z-40 shadow-sm">
        <div class="flex items-center gap-4">
            <button onclick="toggleAdminSidebar()" class="lg:hidden p-2 text-navy hover:bg-gray-50 rounded-lg">
                <i data-lucide="menu"></i>
            </button>
            <h1 class="text-xl font-extrabold text-navy italic tracking-tight hidden sm:block"><?php echo $page_title; ?></h1>
        </div>

        <div class="flex items-center gap-4">
            <button class="p-2 text-gray-400 hover:text-navy hover:bg-gray-50 rounded-lg transition-colors relative">
                <i data-lucide="bell" class="w-5 h-5"></i>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
            </button>
            
            <div class="hidden sm:block text-right mr-2">
                <p class="text-sm font-black text-navy leading-none mb-1 uppercase italic tracking-tighter"><?php echo htmlspecialchars($_SESSION['name'] ?? 'Admin User'); ?></p>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest"><?php echo ucfirst($_SESSION['role'] ?? 'staff'); ?> Account</p>
            </div>

            <div class="relative group">
                <button class="w-10 h-10 rounded-xl bg-navy border-2 border-white shadow-md flex items-center justify-center text-white font-bold text-sm ring-1 ring-gray-100 overflow-hidden group-hover:scale-110 transition-transform">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['name'] ?? 'A'); ?>&background=0B3C5D&color=FFFFFF" alt="Admin">
                </button>
                <!-- Dropdown -->
                <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 py-3 hidden group-hover:block transition-all transform origin-top-right">
                    <div class="px-4 py-2 border-b border-gray-50 mb-2">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Administrator</p>
                        <p class="text-xs font-bold text-navy italic">@<?php echo htmlspecialchars($_SESSION['username'] ?? 'admin'); ?></p>
                    </div>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-navy/5 hover:text-navy transition-colors font-bold italic">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        Admin Profile
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-navy/5 hover:text-navy transition-colors font-bold italic">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                        Global Settings
                    </a>
                    <hr class="my-2 border-gray-50">
                    <a href="/Learning-Mangment/auth/logout.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors font-bold italic">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Logout Session
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area Scrollable -->
    <main class="p-4 md:p-8 flex-1 overflow-y-auto bg-gray-50/50">
