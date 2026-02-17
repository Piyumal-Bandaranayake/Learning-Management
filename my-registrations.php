<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-navy">My Registrations</h1>
            <p class="text-gray-500">Track the status of your course applications and payments.</p>
        </div>
        <div class="flex gap-3">
            <button class="bg-white border border-gray-200 px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 hover:bg-gray-50 transition-colors">
                <i data-lucide="filter" class="w-4 h-4"></i>
                Filter
            </button>
            <button class="bg-white border border-gray-200 px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 hover:bg-gray-50 transition-colors">
                <i data-lucide="download" class="w-4 h-4"></i>
                Export
            </button>
        </div>
    </div>

    <!-- Registration Table Container -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-navy uppercase tracking-widest">Class Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-navy uppercase tracking-widest">Date Applied</th>
                        <th class="px-6 py-4 text-xs font-bold text-navy uppercase tracking-widest">Payment Receipt</th>
                        <th class="px-6 py-4 text-xs font-bold text-navy uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-navy uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-navy">
                                    <i data-lucide="code" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <span class="block font-bold text-navy">Advanced PHP Mastery</span>
                                    <span class="text-xs text-gray-500">ID: #REG-9912</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-600 font-medium italic">Feb 15, 2026</td>
                        <td class="px-6 py-5">
                            <button class="text-navy bg-blue-50 px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-2 hover:bg-navy hover:text-white transition-all">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                View Receipt
                            </button>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600 border border-green-100">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                Approved
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <button class="p-2 text-gray-400 hover:text-navy hover:bg-white rounded-lg transition-all">
                                <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-navy">
                                    <i data-lucide="palette" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <span class="block font-bold text-navy">UI/UX Design Bundle</span>
                                    <span class="text-xs text-gray-500">ID: #REG-9945</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-600 font-medium italic">Feb 16, 2026</td>
                        <td class="px-6 py-5">
                            <button class="text-navy bg-blue-50 px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-2 hover:bg-navy hover:text-white transition-all">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                View Receipt
                            </button>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                Pending
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <button class="p-2 text-gray-400 hover:text-navy hover:bg-white rounded-lg transition-all">
                                <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-navy">
                                    <i data-lucide="database" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <span class="block font-bold text-navy">SQL for Beginners</span>
                                    <span class="text-xs text-gray-500">ID: #REG-9812</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-600 font-medium italic">Feb 10, 2026</td>
                        <td class="px-6 py-5 text-xs text-gray-400 font-medium">No Receipt</td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                Rejected
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <button class="p-2 text-gray-400 hover:text-navy hover:bg-white rounded-lg transition-all">
                                <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs font-medium text-gray-500 italic">Showing 3 of 12 registrations</span>
            <div class="flex gap-2">
                <button class="p-2 rounded-lg border border-gray-200 text-gray-400 hover:bg-white disabled:opacity-50" disabled>
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button class="p-2 rounded-lg border border-gray-200 text-navy hover:bg-white active:bg-gray-50">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
