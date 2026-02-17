<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="max-w-7xl mx-auto px-4">
    <!-- Registration Stats Mini -->
    <div class="flex gap-4 mb-8 overflow-x-auto pb-4 scrollbar-hide">
        <div class="bg-navy text-white px-6 py-4 rounded-3xl flex items-center gap-4 shrink-0 shadow-xl shadow-navy/20">
            <span class="text-3xl font-black italic">14</span>
            <span class="text-[10px] uppercase font-bold tracking-widest leading-none">New <br> Requests</span>
        </div>
        <div class="bg-white border border-gray-100 px-6 py-4 rounded-3xl flex items-center gap-4 shrink-0 shadow-sm">
            <span class="text-3xl font-black italic text-navy">956</span>
            <span class="text-[10px] uppercase font-bold tracking-widest leading-none text-gray-400">Total <br> Approved</span>
        </div>
        <div class="bg-white border border-gray-100 px-6 py-4 rounded-3xl flex items-center gap-4 shrink-0 shadow-sm">
            <span class="text-3xl font-black italic text-red-500">23</span>
            <span class="text-[10px] uppercase font-bold tracking-widest leading-none text-gray-400">Rejected <br> Requests</span>
        </div>
    </div>

    <!-- Main Table -->
    <div class="bg-white rounded-3xl shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-navy text-white">
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Student Details</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Desired Course</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Receipt</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Final Status</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic text-center">Admin Controls</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Emma+Stone&background=F3F4F6&color=0B3C5D" class="w-10 h-10 rounded-xl" alt="Emma">
                                <div>
                                    <p class="font-bold text-navy italic">Emma Stone</p>
                                    <p class="text-[10px] text-gray-400 font-bold">emma.s@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="block text-sm font-bold text-navy">Python Essentials</span>
                            <span class="text-[10px] text-gray-400 font-black uppercase italic">Applied: Feb 16, 2026</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <button class="bg-blue-50 text-navy p-2.5 rounded-xl hover:bg-navy hover:text-white transition-all shadow-sm">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                            </button>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase italic border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                Awaiting Check
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button class="bg-green-500 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase italic shadow-lg shadow-green-500/20 hover:scale-105 transition-transform active:scale-95">Approve</button>
                                <button class="bg-red-500 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase italic shadow-lg shadow-red-500/20 hover:scale-105 transition-transform active:scale-95">Reject</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/50 transition-colors bg-gray-50/20">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Jack+Frost&background=F3F4F6&color=0B3C5D" class="w-10 h-10 rounded-xl">
                                <div>
                                    <p class="font-bold text-navy italic">Jack Frost</p>
                                    <p class="text-[10px] text-gray-400 font-bold">jack.frozen@site.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm font-bold text-navy">UI/UX Advanced</td>
                        <td class="px-6 py-5 text-center italic text-xs text-gray-400 font-black">N/A</td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-black uppercase italic border border-green-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                Confirmed
                            </span>
                        </td>
                        <td class="px-6 py-5 flex items-center justify-center pt-8">
                            <button class="text-gray-400 hover:text-navy font-bold text-[10px] uppercase italic">Archived Activity</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
