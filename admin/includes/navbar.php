<?php
$title_map = [
    'dashboard.php' => 'Dashboard Overview',
    'manage-courses.php' => 'Manage Course Catalog',
    'add-course.php' => 'Create New Course',
    'registrations.php' => 'Student Enrollment Requests',
    'students.php' => 'Student Directory',
    'reports.php' => 'Analytics & Reports',
    'change-password.php' => 'Security Settings'
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
            <h1 class="text-xl font-extrabold text-navy tracking-tight hidden sm:block"><?php echo $page_title; ?></h1>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden sm:block text-right mr-2">
                <p class="text-sm font-black text-navy leading-none mb-1 uppercase tracking-tighter"><?php echo htmlspecialchars($_SESSION['name'] ?? 'Admin User'); ?></p>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest"><?php echo ucfirst($_SESSION['role'] ?? 'staff'); ?> Account</p>
            </div>

            <div class="relative">
                <button id="profileDropdownBtn" class="w-10 h-10 rounded-xl bg-navy border-2 border-white shadow-md flex items-center justify-center text-white font-bold text-sm ring-1 ring-gray-100 overflow-hidden hover:scale-105 active:scale-95 transition-all">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['name'] ?? 'A'); ?>&background=0B3C5D&color=FFFFFF" alt="Admin">
                </button>
                <!-- Dropdown List -->
                <div id="profileDropdown" class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 hidden opacity-0 translate-y-2 transition-all duration-200 z-50 origin-top-right">
                    <div class="px-5 py-3 border-b border-gray-50 mb-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Administrator</p>
                        <p class="text-xs font-bold text-navy">@<?php echo htmlspecialchars($_SESSION['username'] ?? 'admin'); ?></p>
                    </div>

                    <div class="px-2">
                        <a href="change-password.php" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-600 hover:bg-navy/5 hover:text-navy rounded-xl transition-all font-bold">
                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center">
                                <i data-lucide="key-round" class="w-4 h-4 text-gray-400 group-hover:text-navy"></i>
                            </div>
                            Password Reset
                        </a>
                        
                        <a href="/Learning-Mangment/auth/logout.php" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-red-600 hover:bg-red-50 rounded-xl transition-all font-bold">
                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                                <i data-lucide="log-out" class="w-4 h-4 text-red-500"></i>
                            </div>
                            Logout Session
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area Scrollable -->
    <main class="p-4 md:p-8 flex-1 overflow-y-auto bg-gray-50/50">
