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
<section class="relative min-h-[85vh] flex items-center bg-gradient-navy overflow-hidden">
    <!-- Mesh Background Overlay -->
    <div class="absolute inset-0 bg-gradient-mesh opacity-50"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Content -->
            <div class="lg:col-span-6 text-center lg:text-left order-2 lg:order-1">
                <div class="max-w-xl mx-auto lg:mx-0">
                    <div data-aos="fade-right" data-aos-delay="100">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-blue-200 text-[10px] font-black uppercase tracking-[0.2em] mb-6 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                            Welcome to Guideway Learning Network
                        </span>
                    </div>
                    <h1 data-aos="fade-right" data-aos-delay="200" class="text-5xl lg:text-6xl xl:text-7xl font-black text-white leading-[1.1] mb-6 uppercase tracking-tight">
                        Upgrade Your <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 via-blue-100 to-white pr-4 pb-2">Learning</span> <br>
                        Experience
                    </h1>
                    <p data-aos="fade-right" data-aos-delay="300" class="text-blue-100/60 text-lg mb-10 leading-relaxed font-medium">
                        Join thousands of students mastering new skills with our professional, flexible, and interactive platform. Start your journey today!
                    </p>
                    <div data-aos="fade-right" data-aos-delay="400" class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start items-center">
                        <a href="courses.php" class="bg-white text-navy px-10 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-blue-50 transition-all shadow-xl shadow-black/20 text-xs flex items-center justify-center gap-2 group whitespace-nowrap">
                            View Courses
                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="register.php" class="bg-white/5 text-white border-2 border-white/10 px-10 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-white hover:text-navy transition-all text-xs flex items-center justify-center whitespace-nowrap">
                            Create Account
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Image/Graphic -->
            <div class="lg:col-span-6 relative order-1 lg:order-2" data-aos="fade-left" data-aos-delay="500">
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
<section class="py-24 bg-[#f1f5f9] relative overflow-hidden">
    <!-- Sophisticated Background Design -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <!-- Floating Mesh Blobs -->
        <div class="absolute -top-[10%] -left-[5%] w-[45%] h-[45%] bg-blue-200/50 rounded-full blur-[100px] animate-blob"></div>
        <div class="absolute top-[30%] -right-[10%] w-[50%] h-[50%] bg-indigo-200/40 rounded-full blur-[100px] animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[40%] h-[40%] bg-blue-100/60 rounded-full blur-[100px] animate-blob animation-delay-4000"></div>
        
        <!-- Pattern Overlay - Very Subtle but visible Grid -->
        <div class="absolute inset-0 opacity-[0.1]" style="background-image: linear-gradient(#475569 1px, transparent 1px), linear-gradient(90deg, #475569 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20" data-aos="fade-up">
            <h2 class="text-4xl font-extrabold text-navy mb-4 uppercase tracking-tight">Why Students Choose Us?</h2>
            <p class="text-gray-500 leading-relaxed font-medium">We provide a high-end educational experience designed to provide the best tools for your professional growth.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Feature 1 -->
            <div data-aos="fade-up" data-aos-delay="100" class="bg-gradient-to-br from-white to-blue-50/50 p-10 rounded-3xl shadow-sm border border-blue-100/50 hover:shadow-2xl hover:scale-[1.02] transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50/50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-navy/5 transition-colors"></div>
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
            <div data-aos="fade-up" data-aos-delay="200" class="bg-gradient-to-br from-white to-blue-50/50 p-10 rounded-3xl shadow-sm border border-blue-100/50 hover:shadow-2xl hover:scale-[1.02] transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50/50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-navy/5 transition-colors"></div>
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
            <div data-aos="fade-up" data-aos-delay="300" class="bg-gradient-to-br from-white to-blue-50/50 p-10 rounded-3xl shadow-sm border border-blue-100/50 hover:shadow-2xl hover:scale-[1.02] transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50/50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-navy/5 transition-colors"></div>
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

<!-- Navigation Hub Section -->
<section class="py-24 bg-white relative overflow-hidden group/hub">
    <!-- Sophisticated Background Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-blue-50/50 rounded-full blur-[120px] -z-10"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-20" data-aos="fade-up">
            <span class="text-blue-500 font-extrabold text-[10px] uppercase tracking-[0.4em] mb-4 block">Quick Access Portal</span>
            <h2 class="text-4xl lg:text-5xl font-black text-navy uppercase tracking-tight">Navigation <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Hub</span></h2>
            <p class="text-gray-500 font-medium mt-4">Everything you need to manage your learning journey, all in one place.</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Hub Item 1: Dashboard -->
            <a href="<?php echo isset($_SESSION['user_id']) ? 'dashboard.php' : 'login.php'; ?>" 
               data-aos="fade-up" data-aos-delay="100"
               class="p-10 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-navy hover:text-white transition-all duration-500 group/item shadow-sm hover:shadow-2xl hover:-translate-y-2 text-center flex flex-col items-center">
                <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6 group-hover/item:bg-white/10 transition-colors">
                    <i data-lucide="layout-dashboard" class="w-8 h-8 text-navy group-hover/item:text-white"></i>
                </div>
                <h3 class="text-xs font-black uppercase tracking-widest text-navy group-hover/item:text-white">Portal Dashboard</h3>
            </a>

            <!-- Hub Item 2: Timetable -->
            <a href="public-timetable.php" 
               data-aos="fade-up" data-aos-delay="200"
               class="p-10 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-navy hover:text-white transition-all duration-500 group/item shadow-sm hover:shadow-2xl hover:-translate-y-2 text-center flex flex-col items-center">
                <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6 group-hover/item:bg-white/10 transition-colors">
                    <i data-lucide="calendar" class="w-8 h-8 text-navy group-hover/item:text-white"></i>
                </div>
                <h3 class="text-xs font-black uppercase tracking-widest text-navy group-hover/item:text-white">Weekly Schedule</h3>
            </a>

            <!-- Hub Item 3: All Courses -->
            <a href="courses.php" 
               data-aos="fade-up" data-aos-delay="300"
               class="p-10 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-navy hover:text-white transition-all duration-500 group/item shadow-sm hover:shadow-2xl hover:-translate-y-2 text-center flex flex-col items-center">
                <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6 group-hover/item:bg-white/10 transition-colors">
                    <i data-lucide="book-open" class="w-8 h-8 text-navy group-hover/item:text-white"></i>
                </div>
                <h3 class="text-xs font-black uppercase tracking-widest text-navy group-hover/item:text-white">Course Catalog</h3>
            </a>

            <!-- Hub Item 4: My Registrations -->
            <a href="<?php echo isset($_SESSION['user_id']) ? 'my-registrations.php' : 'login.php'; ?>" 
               data-aos="fade-up" data-aos-delay="400"
               class="p-10 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-navy hover:text-white transition-all duration-500 group/item shadow-sm hover:shadow-2xl hover:-translate-y-2 text-center flex flex-col items-center">
                <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6 group-hover/item:bg-white/10 transition-colors">
                    <i data-lucide="file-check" class="w-8 h-8 text-navy group-hover/item:text-white"></i>
                </div>
                <h3 class="text-xs font-black uppercase tracking-widest text-navy group-hover/item:text-white">My Admissions</h3>
            </a>
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<?php if (!empty($featured_courses)): ?>
<section id="featured-courses-section" class="py-24 bg-gradient-to-b from-blue-50/20 to-white relative overflow-hidden group/section">
    <!-- Ultra-Creative Background Design - Increased Vibrancy -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Main Mesh Gradient -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(37,99,235,0.05),transparent_70%)]"></div>

        <!-- Interactive Glow - Intensified -->
        <div id="courses-bg-glow" class="absolute w-[800px] h-[800px] bg-blue-500/20 rounded-full blur-[150px] -translate-x-1/2 -translate-y-1/2 transition-opacity duration-1000 opacity-0 group-hover/section:opacity-100"></div>

        <!-- Floating Abstract Shapes - More Vibrant Colors -->
        <div class="absolute top-[10%] left-[5%] w-64 h-64 bg-gradient-to-br from-blue-400/30 to-indigo-500/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-[20%] right-[10%] w-80 h-80 bg-gradient-to-tr from-purple-400/30 to-pink-500/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-[30%] w-48 h-48 bg-gradient-to-r from-cyan-400/20 to-blue-500/10 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
        
        <!-- Artistic SVG Paths - More distinct -->
        <svg class="absolute top-0 right-0 w-1/2 h-full opacity-[0.08] text-blue-600" viewBox="0 0 400 600" fill="none">
            <path d="M400 100C300 150 250 50 150 100C50 150 0 350 100 450S300 550 400 500" stroke="currentColor" stroke-width="3" stroke-dasharray="15 15" class="animate-[pulse_8s_infinite]" />
        </svg>

        <!-- Glassmorphic Decorative Cards - Enhanced -->
        <div class="absolute top-1/4 -left-12 w-64 h-80 bg-gradient-to-br from-white/60 to-blue-100/40 border border-white/80 backdrop-blur-xl rounded-[3rem] -rotate-12 shadow-2xl opacity-40"></div>
        <div class="absolute bottom-1/4 -right-12 w-80 h-64 bg-gradient-to-tr from-white/40 to-purple-100/30 border border-white/60 backdrop-blur-xl rounded-[3rem] rotate-12 shadow-2xl opacity-40"></div>

        <!-- Watermark - More visible -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[22rem] font-black text-blue-900 opacity-[0.03] select-none leading-none tracking-tighter">
            LEARN
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-center mb-16 gap-6 text-center md:text-left">
            <div data-aos="fade-right">
                <span class="text-blue-500 font-black text-[10px] uppercase tracking-[0.3em] mb-2 block">Premium Selection</span>
                <h2 class="text-4xl lg:text-5xl font-black text-navy uppercase tracking-tighter">Featured <span class="relative inline-block pr-4">Courses<span class="absolute -bottom-1 left-0 w-full h-3 bg-blue-400/20 -z-10 -rotate-1"></span></span></h2>
            </div>
        </div>

        <script>
            // Mouse follower glow for creative section
            const section = document.getElementById('featured-courses-section');
            const glow = document.getElementById('courses-bg-glow');
            
            section.addEventListener('mousemove', (e) => {
                const rect = section.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                glow.style.left = `${x}px`;
                glow.style.top = `${y}px`;
            });
        </script>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <?php foreach ($featured_courses as $index => $course): ?>
                <div data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>" class="bg-gradient-to-b from-white to-blue-50/50 rounded-[3rem] border border-blue-100/50 shadow-xl shadow-navy/5 overflow-hidden group hover:-translate-y-2 transition-all duration-500 relative">
                    <!-- Top Gradient Glow -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-blue-400/10 rounded-full blur-3xl group-hover:bg-blue-400/20 transition-colors"></div>
                    
                    <div class="relative h-64 overflow-hidden">
                        <img src="<?php echo htmlspecialchars($course['image']); ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                             alt="<?php echo htmlspecialchars($course['course_title']); ?>">
                        <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full shadow-lg">
                            <span class="text-[10px] font-black uppercase text-navy tracking-widest">Rs. <?php echo number_format($course['price'], 2); ?></span>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <i data-lucide="user" class="w-4 h-4 text-blue-500"></i>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest"><?php echo htmlspecialchars($course['instructor']); ?></span>
                        </div>
                        <h3 class="text-2xl font-black text-navy mb-4 line-clamp-2"><?php echo htmlspecialchars($course['course_title']); ?></h3>
                        <p class="text-gray-500 text-sm mb-8 line-clamp-3 leading-relaxed">
                            <?php echo htmlspecialchars($course['description']); ?>
                        </p>
                        <a href="courses.php" class="w-full bg-navy text-white text-center py-4 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-navy-dark transition-all flex items-center justify-center gap-2">
                            View Details <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="flex justify-center">
            <a href="courses.php" class="inline-flex items-center gap-4 bg-white border-2 border-navy text-navy px-12 py-5 rounded-[2rem] font-black uppercase tracking-widest hover:bg-navy hover:text-white transition-all group shadow-xl shadow-navy/5">
                Explore More Courses
                <i data-lucide="layout-grid" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Call to Action Section -->
<section class="py-24 relative overflow-hidden">
    <!-- Section-level Decorative Blobs (Outside the container) -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-100/20 rounded-full blur-[120px] -z-10 animate-blob"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-indigo-100/20 rounded-full blur-[120px] -z-10 animate-blob animation-delay-4000"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-aos="zoom-in" class="bg-gradient-navy rounded-[4rem] p-12 md:p-24 relative overflow-hidden text-center shadow-[0_40px_100px_-15px_rgba(11,60,93,0.5)] group/cta">
            <!-- Intense Background Effects -->
            <div class="absolute inset-0 bg-gradient-mesh opacity-40"></div>
            
            <!-- Floating Vibrant Orbs within the card -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-gradient-to-br from-blue-400/30 to-cyan-400/20 rounded-full blur-3xl animate-blob group-hover:scale-110 transition-transform duration-1000"></div>
            <div class="absolute -bottom-32 -left-32 w-[30rem] h-[30rem] bg-gradient-to-tr from-indigo-500/20 to-purple-500/20 rounded-full blur-[100px] animate-blob animation-delay-2000 group-hover:scale-110 transition-transform duration-1000"></div>
            
            <!-- Subtle Geometric Pattern -->
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.2\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

            <div class="relative z-10 max-w-3xl mx-auto">
                <span class="inline-block px-6 py-2 rounded-full bg-white/10 border border-white/20 text-blue-200 text-xs font-black uppercase tracking-[0.3em] mb-8 backdrop-blur-md">
                    Start Your Tomorrow
                </span>
                <h2 class="text-5xl md:text-7xl font-black text-white mb-8 leading-[1.1] tracking-tighter">
                    Ready to <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 via-cyan-200 to-white pr-4">transform</span> <br> 
                    your future?
                </h2>
                <p class="text-blue-100/70 text-xl mb-12 leading-relaxed font-medium">
                    Join our vibrant community of 5000+ learners today and take the first step towards a successful career. Your potential is limitless.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="register.php" class="bg-white text-navy px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-lg hover:bg-blue-50 transition-all shadow-[0_20px_50px_rgba(0,0,0,0.3)] flex items-center justify-center gap-3 group/btn">
                        Register Now
                        <div class="bg-navy text-white p-1 rounded-lg group-hover/btn:translate-x-1 transition-transform">
                            <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Floating Decoration -->
            <div class="absolute right-10 bottom-10 opacity-10 group-hover:opacity-20 transition-opacity duration-700">
                <i data-lucide="sparkles" class="w-32 h-32 text-white animate-pulse"></i>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/public_footer.php'; ?>
