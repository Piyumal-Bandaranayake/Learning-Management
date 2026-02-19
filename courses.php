<?php 
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'config/database.php';
$db = getDBConnection();

// Fetch all courses
$stmt = $db->query("SELECT * FROM courses ORDER BY created_at DESC");
$courses = $stmt->fetchAll();

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'student') {
    include 'includes/header.php'; 
    include 'includes/sidebar.php';
    echo '<div class="flex-1 p-8">'; // Start dashboard content area
} else {
    include 'includes/public_header.php'; 
}
?>

<style>
    .bg-grid-pattern {
        background-image: radial-gradient(#0B3C5D 0.5px, transparent 0.5px);
        background-size: 30px 30px;
        opacity: 0.1;
    }
    @keyframes blob-bounce {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob {
        animation: blob-bounce 10s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<?php if (!isset($_SESSION['user_id'])): ?>
<!-- Courses Hero Section -->
<header class="bg-gradient-navy text-white py-32 relative overflow-hidden border-b-[6px] border-blue-500/20">
    <div class="absolute inset-0 bg-gradient-mesh opacity-30"></div>
    
    <!-- Premium Background Design -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-1/2 left-0 w-96 h-96 bg-blue-400/10 rounded-full blur-[100px] -translate-x-1/2"></div>
        <div class="absolute -bottom-24 -right-24 w-[500px] h-[500px] bg-white/5 rounded-full blur-[120px] animate-blob"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 data-aos="fade-down" class="text-5xl lg:text-7xl font-black text-white mb-6 tracking-tight uppercase leading-[1.1]">
            Explore <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-white pr-4">Programs</span>
        </h1>
        <p data-aos="fade-up" data-aos-delay="100" class="text-xl text-blue-100/70 max-w-2xl leading-relaxed font-medium mx-auto">
            Discover a wide range of professional programs designed to fast-track your career. Find your passion and start learning today.
        </p>
    </div>
</header>
<?php endif; ?>

<section id="courses-catalog-section" class="<?php echo isset($_SESSION['user_id']) ? '' : 'py-24 bg-white min-h-screen relative overflow-hidden group/section'; ?>">
    <?php if (!isset($_SESSION['user_id'])): ?>
    <!-- Ultra-Creative Background Design - Sync with Index -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Main Mesh Gradient -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(37,99,235,0.05),transparent_70%)]"></div>

        <!-- Interactive Glow -->
        <div id="catalog-bg-glow" class="absolute w-[800px] h-[800px] bg-blue-500/20 rounded-full blur-[150px] -translate-x-1/2 -translate-y-1/2 transition-opacity duration-1000 opacity-0 group-hover/section:opacity-100"></div>

        <!-- Floating Abstract Shapes -->
        <div class="absolute top-[10%] left-[5%] w-64 h-64 bg-gradient-to-br from-blue-400/30 to-indigo-500/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-[20%] right-[10%] w-80 h-80 bg-gradient-to-tr from-purple-400/30 to-pink-500/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        
        <!-- Artistic SVG Paths -->
        <svg class="absolute top-0 right-0 w-1/2 h-full opacity-[0.08] text-blue-600" viewBox="0 0 400 600" fill="none">
            <path d="M400 100C300 150 250 50 150 100C50 150 0 350 100 450S300 550 400 500" stroke="currentColor" stroke-width="3" stroke-dasharray="15 15" class="animate-[pulse_8s_infinite]" />
        </svg>

        <!-- Glassmorphic Decorative Cards -->
        <div class="absolute top-1/4 -left-12 w-64 h-80 bg-gradient-to-br from-white/60 to-blue-100/40 border border-white/80 backdrop-blur-xl rounded-[3rem] -rotate-12 shadow-2xl opacity-40"></div>
        <div class="absolute bottom-1/4 -right-12 w-80 h-64 bg-gradient-to-tr from-white/40 to-purple-100/30 border border-white/60 backdrop-blur-xl rounded-[3rem] rotate-12 shadow-2xl opacity-40"></div>

        <!-- Watermark -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[22rem] font-black text-blue-900 opacity-[0.02] select-none leading-none tracking-tighter">
            COURSES
        </div>
    </div>

    <script>
        // Mouse follower glow for catalog section
        const cSection = document.getElementById('courses-catalog-section');
        const cGlow = document.getElementById('catalog-bg-glow');
        
        if (cSection && cGlow) {
            cSection.addEventListener('mousemove', (e) => {
                const rect = cSection.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                cGlow.style.left = `${x}px`;
                cGlow.style.top = `${y}px`;
            });
        }
    </script>
    <?php endif; ?>

    <div class="<?php echo isset($_SESSION['user_id']) ? '' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10'; ?>">
        <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Dashboard Section Header -->
        <div class="relative mb-12 flex flex-col lg:flex-row lg:items-end justify-between gap-8 z-10">
            <div class="max-w-2xl">
                <h1 class="text-4xl font-black text-navy mb-2 tracking-tight">Academic <span class="text-blue-500">Catalog</span></h1>
                <p class="text-gray-400 text-sm font-bold">Select a course to begin your journey.</p>
            </div>
            <div class="relative">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                <input type="text" id="course-search-student" placeholder="Search catalog..." class="pl-12 pr-6 py-3 rounded-2xl border border-white/50 bg-white/50 backdrop-blur-md focus:outline-none focus:ring-2 focus:ring-navy/20 w-80 shadow-xl shadow-navy/5">
            </div>
        </div>

        <!-- Background Design Elements (Student View) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden -z-10">
            <div class="absolute top-0 left-0 w-full h-full opacity-40 bg-[radial-gradient(circle_at_0%_0%,#4CAF50_0%,transparent_60%),radial-gradient(circle_at_100%_0%,#2196F3_0%,transparent_60%),radial-gradient(circle_at_50%_100%,#FF9800_0%,transparent_60%)]"></div>
            <div class="absolute top-[-10%] left-[-15%] w-[600px] h-[600px] bg-navy/20 rounded-full blur-[120px] animate-blob"></div>
            <div class="absolute bottom-[0%] right-[-10%] w-[700px] h-[700px] bg-blue-600/20 rounded-full blur-[120px] animate-blob" style="animation-delay: -5s;"></div>
            <div class="absolute top-[20%] right-[10%] w-[500px] h-[500px] bg-orange-500/20 rounded-full blur-[100px] animate-blob" style="animation-delay: -2s;"></div>
            <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
        </div>

        <script>
            // Ensure the main container is relative for absolute positioning
            setTimeout(() => {
                const main = document.querySelector('main');
                if (main) main.classList.add('relative');
            }, 100);
        </script>
        <?php else: ?>
        <!-- Public Filter/Search Bar -->
        <div class="mb-16 flex justify-end">
            <div class="relative w-full lg:w-96">
                <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                <input type="text" id="course-search-public" placeholder="Search all courses..." class="w-full pl-14 pr-7 py-4 rounded-[2rem] border border-gray-100 bg-gray-50/50 backdrop-blur-sm focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy/20 transition-all shadow-xl shadow-navy/5 font-medium">
            </div>
        </div>
        <?php endif; ?>



        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 relative z-10">
            <?php if (empty($courses)): ?>
                <div class="col-span-full py-20 text-center bg-white/80 backdrop-blur-xl rounded-[3rem] border-2 border-dashed border-gray-100">
                    <div class="flex flex-col items-center opacity-30">
                        <i data-lucide="package-search" class="w-20 h-20 mb-4 text-navy"></i>
                        <h2 class="text-2xl font-black uppercase tracking-widest text-navy">Course Catalog Empty</h2>
                        <p class="text-gray-500 mt-2 font-bold">Our academic team is currently preparing new curricula. Check back soon!</p>
                    </div>
                </div>
            <?php else: foreach ($courses as $index => $course): ?>
                <div data-aos="fade-up" data-aos-delay="<?php echo ($index % 3) * 100; ?>" class="course-card bg-white/80 backdrop-blur-xl rounded-[3rem] border border-white/50 shadow-xl shadow-navy/5 overflow-hidden group hover:-translate-y-2 transition-all duration-500 relative flex flex-col" data-title="<?php echo strtolower(htmlspecialchars($course['course_title'])); ?>" data-instructor="<?php echo strtolower(htmlspecialchars($course['instructor'])); ?>">
                    <!-- Top Gradient Glow -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-blue-400/10 rounded-full blur-3xl group-hover:bg-blue-400/20 transition-colors"></div>
                    
                    <div class="aspect-[16/10] overflow-hidden relative">
                        <img src="<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['course_title']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/80 via-navy/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                            <span class="text-white font-black uppercase tracking-widest text-xs translate-y-4 group-hover:translate-y-0 transition-transform duration-500">Curriculum Enclosed</span>
                        </div>
                        <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full shadow-lg">
                            <span class="text-[10px] font-black uppercase text-navy tracking-widest">Rs. <?php echo number_format($course['price'], 2); ?></span>
                        </div>
                    </div>
                    <div class="p-8 flex-1 flex flex-col relative">
                        <div class="flex items-center gap-2 mb-4">
                            <i data-lucide="user" class="w-4 h-4 text-blue-500"></i>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest"><?php echo htmlspecialchars($course['instructor']); ?></span>
                        </div>
                        <h3 class="text-2xl font-black text-navy mb-3 line-clamp-1"><?php echo htmlspecialchars($course['course_title']); ?></h3>
                        <p class="text-gray-500 text-sm mb-8 line-clamp-2 leading-relaxed font-medium"><?php echo htmlspecialchars($course['description']); ?></p>
                        
                        <div class="flex items-center gap-6 mb-8 pt-6 border-t border-blue-50">
                            <div class="flex items-center gap-2 text-xs text-gray-400 font-bold uppercase tracking-wider">
                                <i data-lucide="clock" class="w-4 h-4 text-navy"></i>
                                <span><?php echo htmlspecialchars($course['duration']); ?></span>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <?php 
                            if (isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $course_id = $course['id'];
                                
                                // Check registration status
                                $reg_stmt = $db->prepare("SELECT status FROM registrations WHERE user_id = ? AND course_id = ?");
                                $reg_stmt->execute([$user_id, $course_id]);
                                $reg = $reg_stmt->fetch();
                                
                                if ($reg) {
                                    if ($reg['status'] === 'approved') {
                                        ?>
                                        <a href="course-assets.php?course_id=<?php echo $course['id']; ?>" class="block w-full text-center bg-blue-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-navy transition-all shadow-xl shadow-blue-500/20 flex items-center justify-center gap-2">
                                            Enroll now
                                            <i data-lucide="play-circle" class="w-4 h-4"></i>
                                        </a>
                                        <?php
                                    } elseif ($reg['status'] === 'pending') {
                                        ?>
                                        <div class="w-full text-center bg-amber-50 text-amber-600 py-4 rounded-2xl font-black border border-amber-100 flex items-center justify-center gap-2 uppercase tracking-widest text-[10px]">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pending Approval
                                        </div>
                                        <?php
                                    } else { // Rejected
                                        ?>
                                        <a href="registration.php?id=<?php echo $course['id']; ?>" class="block w-full text-center bg-navy text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 flex items-center justify-center gap-2">
                                            Register Again
                                            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                        </a>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <a href="registration.php?id=<?php echo $course['id']; ?>" class="block w-full text-center bg-navy text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 flex items-center justify-center gap-2">
                                        Register Now
                                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                    </a>
                                    <?php
                                }
                            } else {
                                ?>
                                <a href="login.php" class="block w-full text-center bg-navy text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 flex items-center justify-center gap-2">
                                    Login to Enroll
                                    <i data-lucide="lock" class="w-4 h-4"></i>
                                </a>
                                <?php
                            } 
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInputPublic = document.getElementById('course-search-public');
        const searchInputStudent = document.getElementById('course-search-student');
        const courseCards = document.querySelectorAll('.course-card');
        const emptyState = document.querySelector('.col-span-full.py-20.text-center');

        function performSearch(query) {
            query = query.toLowerCase();
            let hasResults = false;

            courseCards.forEach(card => {
                const title = card.getAttribute('data-title');
                const instructor = card.getAttribute('data-instructor');

                if (title.includes(query) || instructor.includes(query)) {
                    card.style.display = 'flex';
                    hasResults = true;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyState) {
                if (hasResults) {
                    emptyState.style.display = 'none';
                } else {
                    emptyState.style.display = 'block';
                    emptyState.querySelector('h2').textContent = 'No matching courses found';
                    emptyState.querySelector('p').textContent = `Keep searching! We might have something else for you.`;
                }
            }
        }

        if (searchInputPublic) {
            searchInputPublic.addEventListener('input', (e) => performSearch(e.target.value));
        }

        if (searchInputStudent) {
            searchInputStudent.addEventListener('input', (e) => performSearch(e.target.value));
        }

        // Handle search query from URL (e.g. from Dashboard)
        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('search');
        if (searchQuery) {
            const activeInput = searchInputStudent || searchInputPublic;
            if (activeInput) {
                activeInput.value = searchQuery;
                performSearch(searchQuery);
            }
        }
    });
</script>

<?php 
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'student') {
    echo '</div>'; // Close flex-1 p-8
    include 'includes/footer.php';
} else {
    include 'includes/public_footer.php'; 
}
?>

