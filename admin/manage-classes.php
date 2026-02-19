<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="max-w-7xl mx-auto px-4">
    <!-- Header Actions & Search -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-10">
        <div class="flex-1 w-full relative">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input type="text" id="adminSearchInput" placeholder="Search by class title, instructor or status..." class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-100 bg-white focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all shadow-sm text-sm">
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <a href="add-class.php" class="flex-1 md:flex-none bg-navy text-white px-8 py-4 rounded-2xl font-black text-xs shadow-xl shadow-navy/20 hover:bg-navy-dark transition-all flex items-center justify-center gap-2 uppercase tracking-widest">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                New Course
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-navy text-white">
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em]">Class Title</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em]">Instructor</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em]">Date & Time</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em]">Price</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em]">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-navy/5 flex items-center justify-center text-navy font-black text-xs">P01</div>
                                <span class="font-bold text-navy">Python Fundamentals</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-600 font-medium">Mark Smith</td>
                        <td class="px-6 py-5">
                            <span class="block text-xs font-bold text-navy">Feb 20, 2026</span>
                            <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter">09:00 AM - 11:00 AM</span>
                        </td>
                        <td class="px-6 py-5 font-black text-navy">$45.00</td>
                        <td class="px-6 py-5">
                            <span class="text-[10px] uppercase font-black px-2 py-0.5 rounded bg-green-50 text-green-600 border border-green-100 tracking-widest">Active</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button class="p-2 text-navy hover:bg-navy hover:text-white rounded-lg transition-all border border-navy/10 shadow-sm">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <button class="p-2 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all border border-red-100 shadow-sm">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="bg-gray-50/30 hover:bg-gray-50/50 transition-colors group text-sm">
                        <td class="px-6 py-5 font-bold text-navy">UI/UX Advanced Mastery</td>
                        <td class="px-6 py-5 text-gray-600">Sarah Johnson</td>
                        <td class="px-6 py-5">
                            <span class="block text-xs font-bold text-navy">Feb 22, 2026</span>
                            <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter">03:00 PM - 05:00 PM</span>
                        </td>
                        <td class="px-6 py-5 font-black text-navy">$75.00</td>
                        <td class="px-6 py-5">
                            <span class="text-[10px] uppercase font-black px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100 tracking-widest">Draft</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button class="p-2 text-navy hover:bg-navy hover:text-white rounded-lg transition-all border border-navy/10 shadow-sm">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <button class="p-2 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all border border-red-100 shadow-sm">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50/30 flex justify-between items-center text-xs font-bold text-gray-400 uppercase tracking-widest">
            <span>Showing 2 of 48 courses</span>
            <div class="flex gap-2">
                <button class="px-3 py-1 bg-white border border-gray-100 rounded-lg text-navy shadow-sm">Prev</button>
                <button class="px-3 py-1 bg-navy text-white rounded-lg shadow-md shadow-navy/20">Next</button>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
