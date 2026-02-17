<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-navy">Course Downloads</h1>
        <p class="text-gray-500">Access course materials, study guides, and certificates for your approved classes.</p>
    </div>

    <!-- Empty State (Optional Logic) -->
    <!-- 
    <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-100 italic">
        <i data-lucide="folder-open" class="w-16 h-16 text-gray-200 mx-auto mb-4"></i>
        <h3 class="text-xl font-bold text-gray-400 font-bold uppercase italic">No Downloads Available</h3>
        <p class="text-gray-400 mt-2">Get approved for a course to see materials here.</p>
    </div> 
    -->

    <!-- Downloads List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Download Item 1 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all border-l-8 border-l-navy flex items-start justify-between group">
            <div class="flex gap-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-navy shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="file-text" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="font-bold text-navy text-lg leading-tight uppercase italic mb-1">PHP Advanced Study Guide</h3>
                    <p class="text-sm text-gray-500 mb-2">Class: <span class="text-navy font-semibold italic">Advanced PHP Mastery</span></p>
                    <div class="flex items-center gap-4">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-1 rounded">2.4 MB</span>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-1 rounded">PDF</span>
                    </div>
                </div>
            </div>
            <a href="#" class="bg-navy text-white p-3 rounded-xl hover:bg-navy-dark transition-all shadow-lg shadow-navy/20 self-center">
                <i data-lucide="download" class="w-5 h-5"></i>
            </a>
        </div>

        <!-- Download Item 2 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all border-l-8 border-l-navy flex items-start justify-between group">
            <div class="flex gap-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-navy shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="video" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="font-bold text-navy text-lg leading-tight uppercase italic mb-1">UI/UX Design Workflow VOD</h3>
                    <p class="text-sm text-gray-500 mb-2">Class: <span class="text-navy font-semibold italic">UI/UX Design Bundle</span></p>
                    <div class="flex items-center gap-4">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-1 rounded">128 MB</span>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-1 rounded">MP4</span>
                    </div>
                </div>
            </div>
            <a href="#" class="bg-navy text-white p-3 rounded-xl hover:bg-navy-dark transition-all shadow-lg shadow-navy/20 self-center">
                <i data-lucide="download" class="w-5 h-5"></i>
            </a>
        </div>

        <!-- Download Item 3 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all border-l-8 border-l-navy flex items-start justify-between group">
            <div class="flex gap-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-navy shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="archive" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="font-bold text-navy text-lg leading-tight uppercase italic mb-1">Asset Pack - Icons & Fonts</h3>
                    <p class="text-sm text-gray-500 mb-2">Class: <span class="text-navy font-semibold italic">UI/UX Design Bundle</span></p>
                    <div class="flex items-center gap-4">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-1 rounded">15 MB</span>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-1 rounded">ZIP</span>
                    </div>
                </div>
            </div>
            <a href="#" class="bg-navy text-white p-3 rounded-xl hover:bg-navy-dark transition-all shadow-lg shadow-navy/20 self-center">
                <i data-lucide="download" class="w-5 h-5"></i>
            </a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
