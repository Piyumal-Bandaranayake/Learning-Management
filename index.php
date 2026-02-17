<?php include 'includes/public_header.php'; ?>

<!-- Hero Section -->
<section class="relative min-h-[85vh] flex items-center bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <span class="inline-block bg-navy/5 text-navy px-4 py-2 rounded-full text-sm font-bold uppercase tracking-widest mb-6 border border-navy/10">Welcome to LMS Core</span>
                <h1 class="text-5xl lg:text-7xl font-extrabold text-navy leading-[1.1] mb-6">
                    Upgrade Your <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-navy to-blue-600">Learning</span> Experience
                </h1>
                <p class="text-gray-500 text-lg lg:text-xl max-w-xl mx-auto lg:mx-0 mb-10 leading-relaxed">
                    Join thousands of students mastering new skills with our professional, flexible, and interactive platform. Start your journey today!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="all-classes.php" class="bg-navy text-white px-10 py-4 rounded-2xl font-bold hover:bg-navy-dark transition-all shadow-2xl shadow-navy/30 text-lg flex items-center justify-center gap-2">
                        View Classes
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                    <a href="register.php" class="bg-white text-navy border-2 border-navy px-10 py-4 rounded-2xl font-bold hover:bg-navy hover:text-white transition-all text-lg flex items-center justify-center">
                        Create Account
                    </a>
                </div>
                
                <div class="mt-12 flex items-center justify-center lg:justify-start gap-8 opacity-60">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-navy">15K+</p>
                        <p class="text-xs uppercase font-bold text-gray-400">Students</p>
                    </div>
                    <div class="w-px h-8 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-navy">450+</p>
                        <p class="text-xs uppercase font-bold text-gray-400">Courses</p>
                    </div>
                    <div class="w-px h-8 bg-gray-200"></div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-navy">99%</p>
                        <p class="text-xs uppercase font-bold text-gray-400">Success</p>
                    </div>
                </div>
            </div>

            <!-- Hero Image/Graphic -->
            <div class="relative hidden lg:block">
                <div class="relative z-10 bg-white p-4 rounded-3xl shadow-2xl border border-gray-100 rotate-2 hover:rotate-0 transition-transform duration-500">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=600" alt="Students Learning" class="rounded-2xl shadow-inner">
                    <div class="absolute -bottom-6 -left-6 bg-navy text-white p-6 rounded-2xl shadow-xl flex items-center gap-4 animate-bounce">
                        <div class="bg-white/20 p-2 rounded-lg">
                            <i data-lucide="award" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Top Rated Platform</p>
                            <p class="text-xs opacity-70">Best Excellence 2026</p>
                        </div>
                    </div>
                </div>
                <!-- Background decorations -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-navy-light/5 rounded-full blur-3xl -z-10"></div>
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-navy/10 rounded-full blur-2xl"></div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <h2 class="text-4xl font-extrabold text-navy mb-4 italic">Why Students Choose Us?</h2>
            <p class="text-gray-500 leading-relaxed">We provide a high-end educational experience designed to provide the best tools for your professional growth.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Feature 1 -->
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-2xl hover-scale transition-all group">
                <div class="w-16 h-16 bg-blue-50 text-navy rounded-2xl flex items-center justify-center mb-8 group-hover:bg-navy group-hover:text-white transition-colors duration-500">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-navy mb-4">Expert Instructors</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">Learn from industry veterans and academic experts committed to your success in every module.</p>
                <a href="#" class="text-navy font-bold flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                    Learn More <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-2xl hover-scale transition-all group">
                <div class="w-16 h-16 bg-blue-50 text-navy rounded-2xl flex items-center justify-center mb-8 group-hover:bg-navy group-hover:text-white transition-colors duration-500">
                    <i data-lucide="calendar" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-navy mb-4">Flexible Timetable</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">Classes scheduled to fit your busy lifestyle, with both live sessions and recorded backups available.</p>
                <a href="#" class="text-navy font-bold flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                    Learn More <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-2xl hover-scale transition-all group">
                <div class="w-16 h-16 bg-blue-50 text-navy rounded-2xl flex items-center justify-center mb-8 group-hover:bg-navy group-hover:text-white transition-colors duration-500">
                    <i data-lucide="download-cloud" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-navy mb-4">Offline Access</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">Download course materials and watch videos offline, allowing you to learn anytime, anywhere.</p>
                <a href="#" class="text-navy font-bold flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                    Learn More <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-navy rounded-[3rem] p-12 md:p-20 relative overflow-hidden text-center shadow-2xl shadow-navy/40">
            <!-- Decorative Graphics -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
            
            <div class="relative z-10 max-w-3xl mx-auto">
                <h2 class="text-4xl md:text-6xl font-extrabold text-white mb-8 italic">Ready to transform your future?</h2>
                <p class="text-blue-100/70 text-lg mb-12 leading-relaxed">
                    Join our vibrant community of learners today and take the first step towards a successful career. Your potential is limitless.
                </p>
                <a href="register.php" class="bg-white text-navy px-12 py-5 rounded-2xl font-bold hover:bg-blue-50 transition-all text-xl shadow-xl flex items-center justify-center gap-3 w-fit mx-auto">
                    Register Now
                    <i data-lucide="user-plus" class="w-6 h-6"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/public_footer.php'; ?>
