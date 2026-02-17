<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="max-w-7xl mx-auto">
    <!-- Welcome Section -->
    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100 mb-8 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-navy mb-2">Welcome back, John! 👋</h1>
                <p class="text-gray-500 max-w-md">You have 2 Courses today and 3 pending approvals. Keep up the great work and stay on track with your studies.</p>
                <div class="mt-6 flex flex-wrap gap-4">
                    <a href="Courses.php" class="bg-navy text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-navy-dark transition-all flex items-center gap-2 shadow-lg shadow-navy/20">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Register Course
                    </a>
                    <a href="timetable.php" class="bg-blue-50 text-navy px-6 py-2.5 rounded-xl font-semibold hover:bg-blue-100 transition-all">
                        View Schedule
                    </a>
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="w-48 h-48 bg-blue-50 rounded-full flex items-center justify-center border-4 border-white shadow-inner">
                    <i data-lucide="graduation-cap" class="w-24 h-24 text-navy opacity-80"></i>
                </div>
            </div>
        </div>
        <!-- Decorative blob -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-navy opacity-[0.03] rounded-full blur-3xl pointer-events-none group-hover:bg-navy-light group-hover:opacity-5 transition-all duration-700"></div>
    </div>

    <!-- Summary Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Courses -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-navy border-l border-r border-b border-gray-100 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-xl">
                    <i data-lucide="book-open" class="text-navy w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">+2 this week</span>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Total Registered</h3>
            <p class="text-3xl font-bold text-navy">12</p>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-amber-400 border-l border-r border-b border-gray-100 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 rounded-xl">
                    <i data-lucide="clock" class="text-amber-500 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Awaiting Review</span>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Pending Approvals</h3>
            <p class="text-3xl font-bold text-navy">3</p>
        </div>

        <!-- Approved Courses -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-green-500 border-l border-r border-b border-gray-100 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 rounded-xl">
                    <i data-lucide="check-circle" class="text-green-500 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">Successfully Joined</span>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Approved Courses</h3>
            <p class="text-3xl font-bold text-navy">9</p>
        </div>
    </div>

    <!-- Main Content Section (Split View) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Announcements/Timeline -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-navy">Recent Activity</h2>
                <button class="text-navy text-sm font-semibold hover:underline">View All</button>
            </div>
            <div class="space-y-6">
                <div class="flex gap-4">
                    <div class="mt-1 flex-shrink-0 w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-bold text-xs ring-4 ring-blue-50">
                        1
                    </div>
                    <div>
                        <h4 class="font-bold text-navy italic">"Introduction to UI/UX"</h4>
                        <p class="text-sm text-gray-500">Your registration for this Course has been approved. You can now access materials.</p>
                        <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400">2 hours ago</span>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="mt-1 flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-navy flex items-center justify-center font-bold text-xs">
                        2
                    </div>
                    <div>
                        <h4 class="font-bold text-navy italic">"Mathematics for Engineers"</h4>
                        <p class="text-sm text-gray-500">Payment receipt uploaded. Waiting for admin verification.</p>
                        <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400">Yesterday, 4:30 PM</span>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="mt-1 flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-navy flex items-center justify-center font-bold text-xs">
                        3
                    </div>
                    <div>
                        <h4 class="font-bold text-navy italic">"Advanced PHP Mastery"</h4>
                        <p class="text-sm text-gray-500">A new study guide has been added to your downloads folder.</p>
                        <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400">Feb 15, 2026</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Courses -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-navy">Upcoming Courses</h2>
                <button class="text-navy text-sm font-semibold hover:underline">Full Timetable</button>
            </div>
            <div class="space-y-4">
                <div class="p-4 rounded-xl border border-gray-50 bg-gray-50/50 flex items-center justify-between hover:border-blue-200 transition-colors cursor-pointer group">
                    <div class="flex gap-4 items-center">
                        <div class="text-center w-12 py-1 px-2 rounded-lg bg-navy text-white text-xs font-bold shadow-md">
                            <span class="block">FEB</span>
                            <span class="block text-lg">20</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-navy group-hover:text-blue-600 transition-colors">Python Fundamentals</h4>
                            <p class="text-xs text-gray-500">Room 101 • 09:00 AM - 11:00 AM</p>
                        </div>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:text-navy group-hover:translate-x-1 transition-all"></i>
                </div>

                <div class="p-4 rounded-xl border border-gray-50 bg-gray-50/50 flex items-center justify-between hover:border-blue-200 transition-colors cursor-pointer group">
                    <div class="flex gap-4 items-center">
                        <div class="text-center w-12 py-1 px-2 rounded-lg bg-navy text-white text-xs font-bold shadow-md">
                            <span class="block">FEB</span>
                            <span class="block text-lg">22</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-navy group-hover:text-blue-600 transition-colors">Graphic Design Basics</h4>
                            <p class="text-xs text-gray-500">Online • 02:00 PM - 03:30 PM</p>
                        </div>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:text-navy group-hover:translate-x-1 transition-all"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
