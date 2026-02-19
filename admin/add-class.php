<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="max-w-4xl mx-auto px-4 pb-20">
    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
        <!-- Banner -->
        <div class="h-32 bg-navy relative overflow-hidden flex items-center px-10">
            <h2 class="text-2xl font-black text-white tracking-tight relative z-10">Course Information Details</h2>
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
        </div>

        <form action="#" method="POST" class="p-10 space-y-8">
            <!-- Grid 1 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest ml-1">Class Title</label>
                    <input type="text" placeholder="e.g. Master Laravel Framework" class="w-full px-6 py-4 bg-gray-50/50 rounded-2xl border-2 border-transparent focus:border-navy focus:bg-white focus:outline-none transition-all shadow-inner">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest ml-1">Select Instructor</label>
                    <select class="w-full px-6 py-4 bg-gray-50/50 rounded-2xl border-2 border-transparent focus:border-navy focus:bg-white focus:outline-none transition-all shadow-inner cursor-pointer appearance-none">
                        <option>Mark Smith</option>
                        <option>Sarah Johnson</option>
                        <option>David Chen</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label class="block text-[10px] font-black uppercase text-navy tracking-widest ml-1">Course Description</label>
                <textarea rows="4" placeholder="Brief overview of the curriculum and expected outcomes..." class="w-full px-6 py-4 bg-gray-50/50 rounded-2xl border-2 border-transparent focus:border-navy focus:bg-white focus:outline-none transition-all shadow-inner resize-none"></textarea>
            </div>

            <!-- Grid 2 -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest ml-1">Date</label>
                    <input type="date" class="w-full px-4 py-3.5 bg-gray-50/50 rounded-xl border-2 border-transparent focus:border-navy focus:bg-white focus:outline-none transition-all shadow-inner">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest ml-1">Start Time</label>
                    <input type="time" class="w-full px-4 py-3.5 bg-gray-50/50 rounded-xl border-2 border-transparent focus:border-navy focus:bg-white focus:outline-none transition-all shadow-inner">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest ml-1">Duration</label>
                    <input type="text" placeholder="2 Hours" class="w-full px-4 py-3.5 bg-gray-50/50 rounded-xl border-2 border-transparent focus:border-navy focus:bg-white focus:outline-none transition-all shadow-inner">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest ml-1">Price ($)</label>
                    <input type="number" step="0.01" placeholder="49.99" class="w-full px-4 py-3.5 bg-gray-50/50 rounded-xl border-2 border-transparent focus:border-navy focus:bg-white focus:outline-none transition-all shadow-inner">
                </div>
            </div>

            <!-- File Upload -->
            <div class="p-8 border-4 border-dashed border-gray-100 rounded-[2rem] bg-gray-50/30 group hover:border-navy/10 transition-colors">
                <div class="flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-navy text-white rounded-2xl flex items-center justify-center mb-4 shadow-xl shadow-navy/20 group-hover:scale-110 transition-transform">
                        <i data-lucide="upload-cloud" class="w-8 h-8 font-black"></i>
                    </div>
                    <label class="cursor-pointer">
                        <input type="file" class="hidden">
                        <p class="text-sm font-black text-navy uppercase tracking-widest mb-1">Upload Course Assets (ZIP)</p>
                        <p class="text-[10px] text-gray-400 font-bold">Max size 500MB • Study guides, Exercise files, etc.</p>
                    </label>
                </div>
            </div>

            <!-- Multi Button row -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit" class="flex-1 bg-navy text-white py-5 rounded-[2rem] font-black uppercase tracking-[0.2em] shadow-2xl shadow-navy/40 hover:bg-navy-dark active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                    <i data-lucide="zap" class="w-5 h-5"></i>
                    Publish Course Now
                </button>
                <button type="button" class="px-10 bg-white text-gray-400 border-2 border-gray-100 py-5 rounded-[2rem] font-black uppercase tracking-widest hover:border-red-400 hover:text-red-400 transition-all">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
