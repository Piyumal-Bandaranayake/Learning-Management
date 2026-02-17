<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="max-w-7xl mx-auto px-4">
    <!-- Grid Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Students -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border-t-4 border-navy hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-2xl text-navy">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-green-600 font-black italic">+12% vs last month</span>
            </div>
            <p class="text-3xl font-black text-navy italic tracking-tighter">1,284</p>
            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest leading-none mt-1">Total Active Students</p>
        </div>

        <!-- Classes -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border-t-4 border-navy hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-2xl text-navy">
                    <i data-lucide="book-open" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-navy font-black italic">Active Courses</span>
            </div>
            <p class="text-3xl font-black text-navy italic tracking-tighter">48</p>
            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest leading-none mt-1">Classes in Catalog</p>
        </div>

        <!-- Pending -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border-t-4 border-amber-400 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 rounded-2xl text-amber-500">
                    <i data-lucide="clock-4" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-amber-600 font-black italic">Awaiting Approval</span>
            </div>
            <p class="text-3xl font-black text-navy italic tracking-tighter">14</p>
            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest leading-none mt-1">Pending Registrations</p>
        </div>

        <!-- Approved -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border-t-4 border-green-500 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 rounded-2xl text-green-500">
                    <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-green-600 font-black italic">Successfully Enrolled</span>
            </div>
            <p class="text-3xl font-black text-navy italic tracking-tighter">956</p>
            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest leading-none mt-1">Approved Enrollments</p>
        </div>
    </div>

    <!-- Recent Activity Tables Snippet -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Registrations -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-black text-navy uppercase italic text-sm tracking-widest">Newest Requests</h3>
                <a href="registrations.php" class="text-xs font-bold text-navy hover:underline">View All</a>
            </div>
            <div class="space-y-0">
                <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Alice+Wonder&background=F3F4F6&color=0B3C5D" class="w-10 h-10 rounded-xl" alt="Alice">
                        <div>
                            <p class="text-sm font-bold text-navy">Alice Wonder</p>
                            <p class="text-[10px] text-gray-400 uppercase font-black italic">Python Fundamentals</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-black uppercase text-amber-500 bg-amber-50 px-2 py-1 rounded">Pending</span>
                </div>
                <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Bob+Dylan&background=F3F4F6&color=0B3C5D" class="w-10 h-10 rounded-xl" alt="Bob">
                        <div>
                            <p class="text-sm font-bold text-navy">Bob Dylan</p>
                            <p class="text-[10px] text-gray-400 uppercase font-black italic">UI/UX Design</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-black uppercase text-green-500 bg-green-50 px-2 py-1 rounded">Approved</span>
                </div>
            </div>
        </div>

        <!-- System Alerts/Status -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 h-full">
            <h3 class="font-black text-navy uppercase italic text-sm tracking-widest mb-6">System Status</h3>
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-navy flex items-center justify-center shrink-0">
                        <i data-lucide="database" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-navy mb-1 italic">Database Backup</p>
                        <p class="text-xs text-gray-500 leading-relaxed italic">The last system backup was completed successfully on Feb 17, 03:00 AM.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                        <i data-lucide="shield" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-navy mb-1 italic">Security Scan</p>
                        <p class="text-xs text-gray-500 leading-relaxed italic">Firewall active. No vulnerabilities detected in the last hourly sweep.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
