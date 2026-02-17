<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-navy mb-2">Available Classes</h1>
        <p class="text-gray-500">Explore and register for new courses to enhance your skills.</p>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <div class="flex-1 relative">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input type="text" placeholder="Search for courses, instructors..." class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition-all shadow-sm">
        </div>
        <div class="flex gap-4">
            <select class="px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy bg-white text-gray-600 shadow-sm cursor-pointer">
                <option>All Categories</option>
                <option>Programming</option>
                <option>Design</option>
                <option>Business</option>
            </select>
            <button class="bg-white p-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                <i data-lucide="sliders-horizontal" class="w-5 h-5 text-navy"></i>
            </button>
        </div>
    </div>

    <!-- Classes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Class Card 1 -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover-lift transition-all flex flex-col">
            <div class="aspect-video bg-navy relative">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=400" alt="PHP Mastery" class="w-full h-full object-cover mix-blend-overlay opacity-60">
                <span class="absolute top-4 left-4 bg-navy text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">Programming</span>
                <span class="absolute bottom-4 right-4 bg-white text-navy font-bold px-3 py-1 rounded-lg shadow-lg">$49.99</span>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <h3 class="text-xl font-bold text-navy mb-2 line-clamp-1">Advanced PHP Mastery</h3>
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://ui-avatars.com/api/?name=Mark+Smith&background=F3F4F6&color=0B3C5D" alt="Mark Smith" class="w-6 h-6 rounded-full">
                    <span class="text-sm text-gray-500">Instructor: <span class="text-navy font-semibold">Mark Smith</span></span>
                </div>
                
                <div class="space-y-2 mb-6">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <span>Starts: March 15, 2026</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span>Mon, Wed • 10:00 AM - 12:00 PM</span>
                    </div>
                </div>

                <div class="mt-auto flex items-center gap-4">
                    <a href="registration.php?id=1" class="flex-1 bg-navy text-white text-center py-3 rounded-xl font-bold hover:bg-navy-dark transition-all shadow-md shadow-navy/10 active:scale-95">
                        Register Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Class Card 2 -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover-lift transition-all flex flex-col">
            <div class="aspect-video bg-navy relative">
                <img src="https://images.unsplash.com/photo-1541462608141-ad4d01947f9d?auto=format&fit=crop&q=80&w=400" alt="UI/UX Design" class="w-full h-full object-cover mix-blend-overlay opacity-60">
                <span class="absolute top-4 left-4 bg-navy text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">Design</span>
                <span class="absolute bottom-4 right-4 bg-white text-navy font-bold px-3 py-1 rounded-lg shadow-lg">Free</span>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <h3 class="text-xl font-bold text-navy mb-2 line-clamp-1">UI/UX Design Principles</h3>
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=F3F4F6&color=0B3C5D" alt="Sarah Johnson" class="w-6 h-6 rounded-full">
                    <span class="text-sm text-gray-500">Instructor: <span class="text-navy font-semibold">Sarah Johnson</span></span>
                </div>
                
                <div class="space-y-2 mb-6">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <span>Starts: April 02, 2026</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span>Sat • 02:00 PM - 04:00 PM</span>
                    </div>
                </div>

                <div class="mt-auto flex items-center gap-4">
                    <a href="registration.php?id=2" class="flex-1 bg-navy text-white text-center py-3 rounded-xl font-bold hover:bg-navy-dark transition-all shadow-md shadow-navy/10 active:scale-95">
                        Register Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Class Card 3 -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover-lift transition-all flex flex-col">
            <div class="aspect-video bg-navy relative">
                <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&q=80&w=400" alt="Cyber Security" class="w-full h-full object-cover mix-blend-overlay opacity-60">
                <span class="absolute top-4 left-4 bg-navy text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">Network</span>
                <span class="absolute bottom-4 right-4 bg-white text-navy font-bold px-3 py-1 rounded-lg shadow-lg">$120.00</span>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <h3 class="text-xl font-bold text-navy mb-2 line-clamp-1">Cyber Security Fundamentals</h3>
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://ui-avatars.com/api/?name=David+Chen&background=F3F4F6&color=0B3C5D" alt="David Chen" class="w-6 h-6 rounded-full">
                    <span class="text-sm text-gray-500">Instructor: <span class="text-navy font-semibold">David Chen</span></span>
                </div>
                
                <div class="space-y-2 mb-6">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <span>Starts: March 20, 2026</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span>Tue, Thu • 06:00 PM - 08:00 PM</span>
                    </div>
                </div>

                <div class="mt-auto flex items-center gap-4">
                    <a href="registration.php?id=3" class="flex-1 bg-navy text-white text-center py-3 rounded-xl font-bold hover:bg-navy-dark transition-all shadow-md shadow-navy/10 active:scale-95">
                        Register Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
