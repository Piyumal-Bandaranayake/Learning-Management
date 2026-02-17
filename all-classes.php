<?php include 'includes/public_header.php'; ?>

<section class="py-20 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="mb-16 text-center lg:text-left flex flex-col lg:flex-row lg:items-end justify-between gap-8">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-extrabold text-navy mb-4 italic tracking-tight">Explore <span class="text-blue-600">Courses</span></h1>
                <p class="text-gray-500 text-lg italic leading-relaxed">Discover a wide range of professional courses designed to help you achieve your career goals. Join our community of learners today.</p>
            </div>
            <div class="flex gap-4 self-center lg:self-end">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                    <input type="text" placeholder="Search courses..." class="pl-12 pr-6 py-3 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition-all w-full lg:w-80 shadow-inner">
                </div>
            </div>
        </div>

        <!-- Featured Message -->
        <div class="bg-blue-50 border-l-4 border-navy p-6 rounded-2xl mb-12 flex items-center gap-4">
            <div class="bg-navy text-white p-2 rounded-xl">
                <i data-lucide="info" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-navy font-bold italic">Not a member yet?</p>
                <p class="text-sm text-gray-600">Please <a href="login.php" class="text-navy font-black underline">login</a> to register for these classes and access learning materials.</p>
            </div>
        </div>

        <!-- Classes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <!-- Class 1 -->
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 group overflow-hidden flex flex-col">
                <div class="aspect-[16/10] overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=600" alt="PHP Frameworks" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                        <span class="text-white font-bold italic">Intermediate Level</span>
                    </div>
                </div>
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-blue-50 text-navy text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest border border-blue-100">Development</span>
                        <span class="text-2xl font-black text-navy">$89.00</span>
                    </div>
                    <h3 class="text-2xl font-extrabold text-navy mb-3 line-clamp-1 italic">Advanced PHP Frameworks</h3>
                    <p class="text-gray-400 text-sm mb-6 line-clamp-2 italic leading-relaxed">Master modern PHP frameworks like Laravel and Symfony with professional-grade architecture patterns.</p>
                    
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center gap-3 text-sm text-gray-500 italic">
                            <i data-lucide="user" class="w-4 h-4 text-navy"></i>
                            <span>Instructor: <span class="font-bold text-navy">Mark Smith</span></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-500 italic">
                            <i data-lucide="clock" class="w-4 h-4 text-navy"></i>
                            <span>24+ Hours of Content</span>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <a href="login.php" class="block w-full text-center bg-navy text-white py-4 rounded-2xl font-bold hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-95 flex items-center justify-center gap-2">
                            Register Now
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Class 2 -->
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 group overflow-hidden flex flex-col">
                <div class="aspect-[16/10] overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1541462608141-ad4d01947f9d?auto=format&fit=crop&q=80&w=600" alt="UI/UX" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                        <span class="text-white font-bold italic">Beginner Level</span>
                    </div>
                </div>
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-blue-50 text-navy text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest border border-blue-100">Design</span>
                        <span class="text-2xl font-black text-navy">$59.00</span>
                    </div>
                    <h3 class="text-2xl font-extrabold text-navy mb-3 line-clamp-1 italic">Graphic Design 101</h3>
                    <p class="text-gray-400 text-sm mb-6 line-clamp-2 italic leading-relaxed">Learn the fundamentals of color theory, typography, and layout using industry-standard tools.</p>
                    
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center gap-3 text-sm text-gray-500 italic">
                            <i data-lucide="user" class="w-4 h-4 text-navy"></i>
                            <span>Instructor: <span class="font-bold text-navy">Sarah Johnson</span></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-500 italic">
                            <i data-lucide="clock" class="w-4 h-4 text-navy"></i>
                            <span>18+ Hours of Content</span>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <a href="login.php" class="block w-full text-center bg-navy text-white py-4 rounded-2xl font-bold hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-95 flex items-center justify-center gap-2">
                            Register Now
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Class 3 -->
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 group overflow-hidden flex flex-col">
                <div class="aspect-[16/10] overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&q=80&w=600" alt="Security" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                        <span class="text-white font-bold italic">Beginner Level</span>
                    </div>
                </div>
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-blue-50 text-navy text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest border border-blue-100">Security</span>
                        <span class="text-2xl font-black text-navy">$120.00</span>
                    </div>
                    <h3 class="text-2xl font-extrabold text-navy mb-3 line-clamp-1 italic">Cyber Security Ethics</h3>
                    <p class="text-gray-400 text-sm mb-6 line-clamp-2 italic leading-relaxed">Protect digital infrastructures and understand the ethical responsibilities of a security professional.</p>
                    
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center gap-3 text-sm text-gray-500 italic">
                            <i data-lucide="user" class="w-4 h-4 text-navy"></i>
                            <span>Instructor: <span class="font-bold text-navy">David Chen</span></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-500 italic">
                            <i data-lucide="clock" class="w-4 h-4 text-navy"></i>
                            <span>30+ Hours of Content</span>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <a href="login.php" class="block w-full text-center bg-navy text-white py-4 rounded-2xl font-bold hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-95 flex items-center justify-center gap-2">
                            Register Now
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/public_footer.php'; ?>
