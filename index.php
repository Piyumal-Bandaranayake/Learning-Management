<?php 
require_once 'config/database.php';
$db = getDBConnection();

// Fetch 3 featured courses
try {
    $stmt = $db->query("SELECT * FROM courses ORDER BY RAND() LIMIT 3");
    $featured_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $featured_courses = [];
}

// Fetch Banners
try {
    $stmt = $db->query("SELECT * FROM banners ORDER BY display_order ASC, created_at DESC LIMIT 3");
    $banners = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $banners = [];
}
include 'includes/public_header.php'; 
?>

<!-- Hero Section -->
<section class="relative min-h-[80vh] flex items-center bg-navy overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Content -->
            <div class="lg:col-span-6 text-center lg:text-left order-2 lg:order-1">
                <div class="max-w-xl mx-auto lg:mx-0">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-blue-200 text-[10px] font-black uppercase tracking-[0.2em] italic mb-6 backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                        Welcome to Guideway Learning Network
                    </span>
                    <h1 class="text-5xl lg:text-6xl xl:text-7xl font-black text-white leading-[1.1] mb-6 italic uppercase tracking-tighter">
                        Upgrade Your <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-blue-200 to-white">Learning</span> <br>
                        Experience
                    </h1>
                    <p class="text-blue-100/60 text-lg mb-10 leading-relaxed font-medium">
                        Join thousands of students mastering new skills with our professional, flexible, and interactive platform. Start your journey today!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start items-center">
                        <a href="courses.php" class="bg-white text-navy px-10 py-4 rounded-2xl font-black uppercase italic tracking-widest hover:bg-blue-50 transition-all shadow-xl shadow-black/20 text-xs flex items-center justify-center gap-2 group whitespace-nowrap">
                            View Courses
                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="register.php" class="bg-white/5 text-white border-2 border-white/10 px-10 py-4 rounded-2xl font-black uppercase italic tracking-widest hover:bg-white hover:text-navy transition-all text-xs flex items-center justify-center whitespace-nowrap">
                            Create Account
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Image/Graphic -->
            <div class="lg:col-span-6 relative order-1 lg:order-2">
                <div class="relative z-10 bg-white/5 p-4 rounded-[3rem] shadow-2xl border border-white/10 -rotate-2 hover:rotate-0 transition-all duration-700 overflow-hidden h-[420px] lg:h-[480px] group mx-auto">
                    <!-- Slides Container -->
                    <div id="hero-slideshow" class="relative h-full w-full">
                        <?php if (empty($banners)): ?>
                            <!-- Fallback Slide 1 -->
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=800" 
                                class="hero-slide absolute inset-0 w-full h-full object-cover rounded-[3rem] transition-opacity duration-1000 opacity-100" alt="Students Learning">
                            
                            <!-- Fallback Slide 2 -->
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800" 
                                class="hero-slide absolute inset-0 w-full h-full object-cover rounded-[3rem] transition-opacity duration-1000 opacity-0" alt="Collaborative Learning">
                            
                            <!-- Fallback Slide 3 -->
                            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=800" 
                                class="hero-slide absolute inset-0 w-full h-full object-cover rounded-[3rem] transition-opacity duration-1000 opacity-0" alt="Creative Studio">
                        <?php else: ?>
                            <?php foreach ($banners as $index => $banner): ?>
                                <img src="<?php echo htmlspecialchars($banner['image']); ?>" 
                                     class="hero-slide absolute inset-0 w-full h-full object-cover rounded-[3rem] transition-opacity duration-1000 <?php echo $index === 0 ? 'opacity-100' : 'opacity-0'; ?>" 
                                     alt="<?php echo htmlspecialchars($banner['title'] ?: 'LMS Banner'); ?>">
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>



                    <!-- Overlay Shadow -->
                    <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                
                <!-- Background Glows -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140%] h-[140%] bg-blue-500/10 rounded-full blur-[100px] -z-10"></div>
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/5 rounded-full blur-[80px]"></div>
            </div>
        </div>
    </div>
</section>

<!-- Slideshow Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.hero-slide');
        let currentSlide = 0;

        function nextSlide() {
            if (slides.length === 0) return;
            
            // Hide current
            slides[currentSlide].classList.replace('opacity-100', 'opacity-0');
            
            // Increment
            currentSlide = (currentSlide + 1) % slides.length;
            
            // Show new
            slides[currentSlide].classList.replace('opacity-0', 'opacity-100');
        }

        // Cycle every 4 seconds
        if(slides.length > 0) {
            setInterval(nextSlide, 4000);
        }
    });
</script>

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
                <p class="text-gray-500 text-sm leading-relaxed mb-6">Courses scheduled to fit your busy lifestyle, with both live sessions and recorded backups available.</p>
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

<!-- Featured Courses Section -->
<?php if (!empty($featured_courses)): ?>
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 text-center md:text-left">
            <div>
                <h2 class="text-4xl lg:text-5xl font-black text-navy uppercase italic tracking-tighter mb-4">Featured Courses</h2>
                <div class="h-2 w-24 bg-blue-500 rounded-full mx-auto md:mx-0"></div>
            </div>
            <p class="text-gray-500 max-w-md font-medium">Explore our top-rated programs designed to fast-track your career in the modern industry.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <?php foreach ($featured_courses as $course): ?>
                <div class="bg-white rounded-[3rem] border border-gray-100 shadow-xl shadow-navy/5 overflow-hidden group hover:-translate-y-2 transition-all duration-500">
                    <div class="relative h-64 overflow-hidden">
                        <img src="<?php echo htmlspecialchars($course['image']); ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                             alt="<?php echo htmlspecialchars($course['course_title']); ?>">
                        <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full shadow-lg">
                            <span class="text-[10px] font-black uppercase text-navy tracking-widest italic">Rs. <?php echo number_format($course['price'], 2); ?></span>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <i data-lucide="user" class="w-4 h-4 text-blue-500"></i>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest"><?php echo htmlspecialchars($course['instructor']); ?></span>
                        </div>
                        <h3 class="text-2xl font-black text-navy mb-4 italic line-clamp-2"><?php echo htmlspecialchars($course['course_title']); ?></h3>
                        <p class="text-gray-500 text-sm mb-8 line-clamp-3 leading-relaxed">
                            <?php echo htmlspecialchars($course['description']); ?>
                        </p>
                        <a href="courses.php" class="w-full bg-navy text-white text-center py-4 rounded-2xl font-bold uppercase italic tracking-widest text-xs hover:bg-navy-dark transition-all flex items-center justify-center gap-2">
                            View Details <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="flex justify-center">
            <a href="courses.php" class="inline-flex items-center gap-4 bg-white border-2 border-navy text-navy px-12 py-5 rounded-[2rem] font-black uppercase italic tracking-widest hover:bg-navy hover:text-white transition-all group shadow-xl shadow-navy/5">
                Explore More Courses
                <i data-lucide="layout-grid" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

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
