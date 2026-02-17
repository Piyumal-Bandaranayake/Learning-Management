<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Admin Sidebar -->
<aside id="admin-sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-navy text-white sidebar-transition transform -translate-x-full lg:translate-x-0 flex flex-col shadow-2xl lg:shadow-none">
    <!-- Branding -->
    <div class="h-20 flex items-center px-6 border-b border-white/10 shrink-0">
        <div class="bg-white p-1.5 rounded-lg mr-3 shadow-lg shadow-black/20">
            <i data-lucide="shield-check" class="text-navy w-6 h-6"></i>
        </div>
        <span class="text-xl font-bold tracking-tight">LMS<span class="text-blue-400">Admin</span></span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5 custom-scrollbar">
        <div class="text-[10px] uppercase tracking-[0.2em] font-black text-blue-400/50 px-4 mb-2 italic">Main Menu</div>
        
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

        <div class="text-[10px] uppercase tracking-[0.2em] font-black text-blue-400/50 px-4 mt-8 mb-2 italic">Students & Fees</div>

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

        <div class="text-[10px] uppercase tracking-[0.2em] font-black text-blue-400/50 px-4 mt-8 mb-2 italic">Timetable</div>

        <a href="manage-timetable.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'manage-timetable.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="calendar" class="w-5 h-5"></i>
            <span>Manage Timetable</span>
        </a>

        <a href="add-timetable.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page == 'add-timetable.php' ? 'bg-white text-navy font-bold shadow-xl shadow-black/10' : 'hover:bg-white/10 text-blue-100/70 hover:text-white'; ?>">
            <i data-lucide="calendar-plus" class="w-5 h-5"></i>
            <span>Add Timetable Entry</span>
        </a>

        <div class="text-[10px] uppercase tracking-[0.2em] font-black text-blue-400/50 px-4 mt-8 mb-2 italic">Website Settings</div>

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
        <a href="../auth/logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:bg-red-500/10 hover:text-red-400 transition-all font-bold italic">
            <i data-lucide="log-out" class="w-5 h-5"></i>
            <span>Log Out Admin</span>
        </a>
    </div>
</aside>
