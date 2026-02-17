<?php include 'includes/public_header.php'; ?>

<section class="py-20 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-12 text-center max-w-2xl mx-auto">
            <h1 class="text-4xl font-extrabold text-navy mb-4 italic tracking-tight">Academic <span class="text-blue-600">Timetable</span></h1>
            <p class="text-gray-500 italic">Explore our upcoming class schedule and plan your learning path effectively. All times are in GMT+0.</p>
        </div>

        <!-- Timetable Controls -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <button class="bg-navy text-white px-6 py-2 rounded-xl font-bold text-sm shadow-lg shadow-navy/20">All Categories</button>
                <button class="text-gray-400 hover:text-navy px-6 py-2 rounded-xl font-bold text-sm transition-colors">Development</button>
                <button class="text-gray-400 hover:text-navy px-6 py-2 rounded-xl font-bold text-sm transition-colors">Business</button>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-400 italic">
                <i data-lucide="info" class="w-4 h-4"></i>
                <span>Schedule updated: <?php echo date('M d, Y'); ?></span>
            </div>
        </div>

        <!-- Table Desktop -->
        <div class="hidden md:block bg-white rounded-3xl shadow-xl shadow-navy/5 overflow-hidden border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-navy text-white">
                        <th class="px-8 py-6 text-sm font-bold uppercase tracking-widest italic">Class Name</th>
                        <th class="px-8 py-6 text-sm font-bold uppercase tracking-widest italic">Instructor</th>
                        <th class="px-8 py-6 text-sm font-bold uppercase tracking-widest italic">Date</th>
                        <th class="px-8 py-6 text-sm font-bold uppercase tracking-widest italic">Time</th>
                        <th class="px-8 py-6 text-sm font-bold uppercase tracking-widest italic">Duration</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-blue-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="block font-bold text-navy group-hover:text-blue-600 transition-colors italic">Advanced PHP Frameworks</span>
                            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-tighter">Code: DEV-PHP02</span>
                        </td>
                        <td class="px-8 py-6 text-gray-600 font-medium">Mark Smith</td>
                        <td class="px-8 py-6 text-gray-600 font-medium">Feb 20, 2026</td>
                        <td class="px-8 py-6 text-gray-600 font-medium">09:00 AM</td>
                        <td class="px-8 py-6">
                            <span class="bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full font-bold">2 Hours</span>
                        </td>
                    </tr>
                    <tr class="bg-gray-50/30 hover:bg-blue-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="block font-bold text-navy group-hover:text-blue-600 transition-colors italic">Graphic Design 101</span>
                            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-tighter">Code: DES-UIUX1</span>
                        </td>
                        <td class="px-8 py-6 text-gray-600 font-medium">Sarah Johnson</td>
                        <td class="px-8 py-6 text-gray-600 font-medium">Feb 22, 2026</td>
                        <td class="px-8 py-6 text-gray-600 font-medium">02:30 PM</td>
                        <td class="px-8 py-6">
                            <span class="bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full font-bold">1.5 Hours</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-blue-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="block font-bold text-navy group-hover:text-blue-600 transition-colors italic">Cyber Security Ethics</span>
                            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-tighter">Code: SEC-CBE</span>
                        </td>
                        <td class="px-8 py-6 text-gray-600 font-medium">David Chen</td>
                        <td class="px-8 py-6 text-gray-600 font-medium">Feb 24, 2026</td>
                        <td class="px-8 py-6 text-gray-600 font-medium">11:00 AM</td>
                        <td class="px-8 py-6">
                            <span class="bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full font-bold">3 Hours</span>
                        </td>
                    </tr>
                    <tr class="bg-gray-50/30 hover:bg-blue-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="block font-bold text-navy group-hover:text-blue-600 transition-colors italic">Digital Marketing Strategy</span>
                            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-tighter">Code: MKT-DMS</span>
                        </td>
                        <td class="px-8 py-6 text-gray-600 font-medium">Emma Wilson</td>
                        <td class="px-8 py-6 text-gray-600 font-medium">Feb 25, 2026</td>
                        <td class="px-8 py-6 text-gray-600 font-medium">05:00 PM</td>
                        <td class="px-8 py-6">
                            <span class="bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full font-bold">2 Hours</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile Table (Cards) -->
        <div class="md:hidden space-y-4">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="font-bold text-navy text-lg italic italic">Advanced PHP</h3>
                    <span class="bg-navy text-white text-[10px] px-2 py-1 rounded font-bold uppercase tracking-widest">Mark</span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-xs text-gray-500">
                    <div>
                        <p class="font-bold text-gray-400 uppercase mb-1">Date</p>
                        <p class="text-navy font-bold italic">Feb 20, 2026</p>
                    </div>
                    <div>
                        <p class="font-bold text-gray-400 uppercase mb-1">Time</p>
                        <p class="text-navy font-bold italic">09:00 AM</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="font-bold text-navy text-lg italic italic">Graphic Design</h3>
                    <span class="bg-navy text-white text-[10px] px-2 py-1 rounded font-bold uppercase tracking-widest">Sarah</span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-xs text-gray-500">
                    <div>
                        <p class="font-bold text-gray-400 uppercase mb-1">Date</p>
                        <p class="text-navy font-bold italic">Feb 22, 2026</p>
                    </div>
                    <div>
                        <p class="font-bold text-gray-400 uppercase mb-1">Time</p>
                        <p class="text-navy font-bold italic">02:30 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/public_footer.php'; ?>
