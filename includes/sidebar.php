<!-- Persistent Sidebar -->
<aside id="sidebar" class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 sidebar-transition z-40 w-64 bg-navy text-white min-h-screen flex flex-col shadow-2xl md:shadow-none pt-20 md:pt-6">
    <nav class="flex-1 px-4 space-y-2">
        <a href="dashboard.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'bg-white text-navy font-semibold shadow-lg' : 'hover:bg-navy-light text-gray-300 hover:text-white'; ?>">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="timetable.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (basename($_SERVER['PHP_SELF']) == 'timetable.php') ? 'bg-white text-navy font-semibold shadow-lg' : 'hover:bg-navy-light text-gray-300 hover:text-white'; ?>">
            <i data-lucide="calendar" class="w-5 h-5"></i>
            <span>Timetable</span>
        </a>

        <a href="classes.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (basename($_SERVER['PHP_SELF']) == 'classes.php') ? 'bg-white text-navy font-semibold shadow-lg' : 'hover:bg-navy-light text-gray-300 hover:text-white'; ?>">
            <i data-lucide="book-open" class="w-5 h-5"></i>
            <span>Classes</span>
        </a>

        <a href="my-registrations.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (basename($_SERVER['PHP_SELF']) == 'my-registrations.php') ? 'bg-white text-navy font-semibold shadow-lg' : 'hover:bg-navy-light text-gray-300 hover:text-white'; ?>">
            <i data-lucide="file-check" class="w-5 h-5"></i>
            <span>My Registrations</span>
        </a>

        <a href="downloads.php" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all <?php echo (basename($_SERVER['PHP_SELF']) == 'downloads.php') ? 'bg-white text-navy font-semibold shadow-lg' : 'hover:bg-navy-light text-gray-300 hover:text-white'; ?>">
            <i data-lucide="download" class="w-5 h-5"></i>
            <span>Downloads</span>
        </a>
    </nav>

    <div class="p-6">
        <div class="bg-navy-light bg-opacity-50 rounded-2xl p-4 text-center">
            <p class="text-xs text-blue-200 mb-2 font-medium">Need Help?</p>
            <button class="w-full bg-white text-navy py-2 rounded-lg text-sm font-bold hover:bg-blue-50 transition-colors">
                Contact Support
            </button>
        </div>
    </div>
</aside>

<!-- Main Content Area Wrapper -->
<main class="flex-1 p-4 md:p-8 overflow-y-auto">
