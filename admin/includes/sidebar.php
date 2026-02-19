<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Admin Sidebar -->
<aside id="admin-sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-navy text-white sidebar-transition transform -translate-x-full lg:translate-x-0 flex flex-col shadow-2xl lg:shadow-none">
    <!-- Branding -->
    <div class="h-24 flex items-center px-6 border-b border-white/10 shrink-0 gap-4 group/logo">
        <div class="relative w-12 h-12 bg-white/10 rounded-2xl border border-white/10 shadow-2xl flex flex-col items-center justify-center overflow-hidden backdrop-blur-md transition-all duration-300 group-hover/logo:bg-white/20">
            <!-- Graduation Cap (Top Part) -->
            <div class="relative z-20 mb-[-4px] transition-transform duration-500 group-hover/logo:-translate-y-1">
                <i data-lucide="graduation-cap" class="w-7 h-7 text-white drop-shadow-md"></i>
            </div>
            
            <!-- 3D Pedestal Blocks (Bottom Part) -->
            <div class="relative z-10 flex flex-col items-center gap-[1px]">
                <div class="flex gap-[1px]">
                    <div class="w-2.5 h-2.5 bg-[#4CAF50] rounded-[1px] shadow-sm"></div>
                    <div class="w-2.5 h-2.5 bg-[#2196F3] rounded-[1px] shadow-sm"></div>
                </div>
                <div class="w-2.5 h-2.5 bg-[#FF9800] rounded-[1px] shadow-sm"></div>
            </div>
        </div>
        
        <div class="flex flex-col">
            <span class="text-xl font-black text-white tracking-tighter uppercase leading-none mb-1">
                GUIDEWAY
            </span>
            <div class="bg-[#E31E24] px-1.5 py-0.5 rounded-sm flex items-center justify-between">
                <span class="text-[7px] font-black text-white tracking-[0.2em] uppercase whitespace-nowrap">
                    Admin Panel
                </span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5 custom-scrollbar">
        <div class="text-[10px] uppercase tracking-[0.2em] font-black text-blue-400/50 px-4 mb-2">Main Menu</div>
        
        <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'dashboard.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span>Dashboard</span>
        </a>

        <a href="manage-courses.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'manage-courses.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="book-copy" class="w-5 h-5"></i>
            <span>Manage Courses</span>
        </a>

        <a href="add-course.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'add-course.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="plus-square" class="w-5 h-5"></i>
            <span>Add New Course</span>
        </a>

        <div class="text-[10px] uppercase tracking-[0.2em] font-black text-blue-400/50 px-4 mt-8 mb-2">Students & Fees</div>

        <a href="registrations.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'registrations.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="list-checks" class="w-5 h-5"></i>
            <span>Registrations</span>
            <?php 
            if (isset($db)) {
                $pending_nav_count = $db->query("SELECT COUNT(*) FROM registrations WHERE status = 'pending'")->fetchColumn();
                if ($pending_nav_count > 0) {
                    echo '<span class="ml-auto bg-amber-500 text-[10px] px-1.5 py-0.5 rounded-full text-white">' . $pending_nav_count . '</span>';
                }
            }
            ?>
        </a>

        <a href="students.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'students.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="users" class="w-5 h-5"></i>
            <span>Students List</span>
        </a>

        <div class="text-[10px] uppercase tracking-[0.2em] font-black text-blue-400/50 px-4 mt-8 mb-2">Timetable</div>

        <a href="manage-timetable.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'manage-timetable.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="calendar" class="w-5 h-5"></i>
            <span>Manage Timetable</span>
        </a>

        <a href="add-timetable.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'add-timetable.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="calendar-plus" class="w-5 h-5"></i>
            <span>Add Timetable Entry</span>
        </a>

        <div class="text-[10px] uppercase tracking-[0.2em] font-black text-blue-400/50 px-4 mt-8 mb-2">Website Settings</div>

        <a href="manage-banners.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'manage-banners.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="images" class="w-5 h-5"></i>
            <span>Manage Banners</span>
        </a>

        <a href="add-banner.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'add-banner.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="image-plus" class="w-5 h-5"></i>
            <span>Add Banner</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-white/10">
        <a href="../auth/logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:bg-red-500/10 hover:text-red-400 transition-all font-bold">
            <i data-lucide="log-out" class="w-5 h-5"></i>
            <span>Log Out Admin</span>
        </a>
    </div>
</aside>
