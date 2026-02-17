<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="max-w-7xl mx-auto px-4">
    <!-- Filters row -->
    <div class="flex flex-col md:flex-row gap-4 mb-10">
        <div class="flex-1 relative">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input type="text" placeholder="Search by name, email or ID..." class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-100 bg-white focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all shadow-sm italic text-sm">
        </div>
        <div class="flex gap-4 items-center">
            <button class="bg-white border border-gray-100 p-4 rounded-2xl text-navy hover:bg-gray-50 transition-all shadow-sm relative">
                <i data-lucide="sliders-horizontal" class="w-5 h-5"></i>
            </button>
            <button class="bg-navy text-white px-8 py-4 rounded-2xl font-black uppercase italic tracking-widest text-xs shadow-xl shadow-navy/20">
                Export to Excel
            </button>
        </div>
    </div>

    <!-- Student List Table -->
    <div class="bg-white rounded-3xl shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-navy text-white">
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Full Name</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Contact Info</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Classes</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-navy text-white flex items-center justify-center font-black italic shadow-lg shadow-navy/20">JD</div>
                            <span class="font-bold text-navy italic">John Doe</span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs font-bold text-gray-600">john.doe@email.com</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter italic">+1 (415) 555-0100</p>
                        </td>
                        <td class="px-6 py-5">
                            <span class="bg-blue-50 text-navy px-3 py-1 rounded-full text-[10px] font-black uppercase border border-blue-100 italic">4 Enrolled</span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-2 text-green-600">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                <span class="text-[10px] font-black uppercase italic tracking-widest">Online</span>
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button class="p-2 text-navy hover:bg-navy hover:text-white rounded-xl transition-all border border-navy/10 shadow-sm" title="View Profile">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="p-2 text-amber-500 hover:bg-amber-500 hover:text-white rounded-xl transition-all border border-amber-100 shadow-sm" title="Disable Account">
                                    <i data-lucide="user-minus" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- More mock rows -->
                    <tr class="hover:bg-gray-50/50 transition-colors bg-gray-50/20">
                        <td class="px-6 py-5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-200 text-gray-500 flex items-center justify-center font-black italic">SM</div>
                            <span class="font-bold text-navy italic">Samantha Miller</span>
                        </td>
                        <td class="px-6 py-5 text-sm font-bold text-gray-600 italic">sam.mill@company.co</td>
                        <td class="px-6 py-5">
                            <span class="bg-gray-100 text-gray-400 px-3 py-1 rounded-full text-[10px] font-black uppercase italic">0 Enrolled</span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-2 text-gray-400">
                                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                <span class="text-[10px] font-black uppercase italic tracking-widest">Offline</span>
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button class="p-2 text-navy hover:bg-navy hover:text-white rounded-xl transition-all border border-navy/10 shadow-sm">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="p-2 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-red-100 shadow-sm">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
