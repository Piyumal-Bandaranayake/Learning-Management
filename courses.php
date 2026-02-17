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

<?php if (!isset($_SESSION['user_id'])): ?>
<!-- Courses Hero Section -->
<header class="relative bg-navy py-24 overflow-hidden border-none shadow-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-5xl lg:text-6xl font-black text-white mb-6 italic tracking-tight uppercase">Explore Courses</span></h1>
        <p class="text-xl text-blue-100/70 max-w-2xl leading-relaxed italic font-medium mx-auto">
            Discover a wide range of professional programs designed to fast-track your career. Find your passion and start learning today.
        </p>
    </div>
    
    <!-- Background Glow -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
</header>
<?php endif; ?>

<section class="<?php echo isset($_SESSION['user_id']) ? '' : 'py-24 bg-white min-h-screen'; ?>">
    <div class="<?php echo isset($_SESSION['user_id']) ? '' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8'; ?>">
        <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Dashboard Section Header -->
        <div class="mb-12 flex flex-col lg:flex-row lg:items-end justify-between gap-8">
            <div class="max-w-2xl">
                <h1 class="text-4xl font-black text-navy mb-2 italic tracking-tight">Academic <span class="text-blue-500">Catalog</span></h1>
                <p class="text-gray-400 text-sm italic font-bold">Select a course to begin your journey.</p>
            </div>
            <div class="relative">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                <input type="text" placeholder="Search catalog..." class="pl-12 pr-6 py-3 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-navy/20 w-80 shadow-inner italic">
            </div>
        </div>
        <?php else: ?>
        <!-- Public Filter/Search Bar -->
        <div class="mb-16 flex justify-end">
            <div class="relative w-full lg:w-96">
                <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                <input type="text" placeholder="Search all courses..." class="w-full pl-14 pr-7 py-4 rounded-[2rem] border border-gray-100 bg-gray-50/50 backdrop-blur-sm focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy/20 transition-all shadow-xl shadow-navy/5 italic font-medium">
            </div>
        </div>
        <?php endif; ?>



        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php if (empty($courses)): ?>
                <div class="col-span-full py-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-100">
                    <div class="flex flex-col items-center opacity-30">
                        <i data-lucide="package-search" class="w-20 h-20 mb-4 text-navy"></i>
                        <h2 class="text-2xl font-black italic uppercase tracking-widest text-navy">Course Catalog Empty</h2>
                        <p class="text-gray-500 mt-2 font-bold italic">Our academic team is currently preparing new curricula. Check back soon!</p>
                    </div>
                </div>
            <?php else: foreach ($courses as $course): ?>
                <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 group overflow-hidden flex flex-col">
                    <div class="aspect-[16/10] overflow-hidden relative">
                        <img src="<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['course_title']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                            <span class="text-white font-bold italic">Curriculum Enclosed</span>
                        </div>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <span class="bg-blue-50 text-navy text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest border border-blue-100">COURSE #<?php echo str_pad($course['id'], 3, '0', STR_PAD_LEFT); ?></span>
                            <span class="text-2xl font-black text-navy">$<?php echo number_format($course['price'], 2); ?></span>
                        </div>
                        <h3 class="text-2xl font-extrabold text-navy mb-3 line-clamp-1 italic"><?php echo htmlspecialchars($course['course_title']); ?></h3>
                        <p class="text-gray-400 text-sm mb-6 line-clamp-2 italic leading-relaxed"><?php echo htmlspecialchars($course['description']); ?></p>
                        
                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-3 text-sm text-gray-500 italic">
                                <i data-lucide="user" class="w-4 h-4 text-navy"></i>
                                <span>Instructor: <span class="font-bold text-navy"><?php echo htmlspecialchars($course['instructor']); ?></span></span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-500 italic">
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
                                        <a href="downloads.php" class="block w-full text-center bg-green-500 text-white py-4 rounded-2xl font-bold hover:bg-green-600 transition-all shadow-xl shadow-green-500/20 active:scale-95 flex items-center justify-center gap-2 italic uppercase tracking-widest text-xs">
                                            Access Course
                                            <i data-lucide="play-circle" class="w-4 h-4"></i>
                                        </a>
                                        <?php
                                    } elseif ($reg['status'] === 'pending') {
                                        ?>
                                        <div class="w-full text-center bg-amber-50 text-amber-600 py-4 rounded-2xl font-black italic border border-amber-100 flex items-center justify-center gap-2 uppercase tracking-widest text-[10px]">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pending Approval
                                        </div>
                                        <?php
                                    } else { // Rejected
                                        ?>
                                        <a href="registration.php?id=<?php echo $course['id']; ?>" class="block w-full text-center bg-navy text-white py-4 rounded-2xl font-bold hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-95 flex items-center justify-center gap-2">
                                            Register Again
                                            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                        </a>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <a href="registration.php?id=<?php echo $course['id']; ?>" class="block w-full text-center bg-navy text-white py-4 rounded-2xl font-bold hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-95 flex items-center justify-center gap-2">
                                        Register Now
                                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                    </a>
                                    <?php
                                }
                            } else {
                                ?>
                                <a href="login.php" class="block w-full text-center bg-navy text-white py-4 rounded-2xl font-bold hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-95 flex items-center justify-center gap-2">
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

<?php 
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'student') {
    echo '</div>'; // Close flex-1 p-8
    include 'includes/footer.php';
} else {
    include 'includes/public_footer.php'; 
}
?>

