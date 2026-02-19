<?php 
require_once 'includes/auth_check.php'; 
require_once 'config/database.php';
require_login();

// Fetch Data for Dashboard
$db = getDBConnection();
$user_id = $_SESSION['user_id'];

// 1. Statistics
$stmt = $db->prepare("SELECT COUNT(*) as total FROM registrations WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_registered = $stmt->fetch()['total'];

$stmt = $db->prepare("SELECT COUNT(*) as pending FROM registrations WHERE user_id = ? AND status = 'pending'");
$stmt->execute([$user_id]);
$pending_approvals = $stmt->fetch()['pending'];

$stmt = $db->prepare("SELECT COUNT(*) as approved FROM registrations WHERE user_id = ? AND status = 'approved'");
$stmt->execute([$user_id]);
$approved_courses = $stmt->fetch()['approved'];

// 2. Recent Activity (Latest 3)
$stmt = $db->prepare("
    SELECT r.*, c.course_title 
    FROM registrations r 
    JOIN courses c ON r.course_id = c.id 
    WHERE r.user_id = ? 
    ORDER BY r.created_at DESC 
    LIMIT 3
");
$stmt->execute([$user_id]);
$recent_activity = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

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

<!-- Background Design Elements -->
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

<div class="max-w-7xl mx-auto">
    <!-- Welcome Section -->
    <div data-aos="fade-down" class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 md:p-8 shadow-xl shadow-navy/5 border border-white/50 mb-8 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-navy mb-2">Welcome back, <?php echo htmlspecialchars(explode(' ', $_SESSION['name'] ?? 'Student')[0]); ?>! 👋</h1>
                <p class="text-navy/60 max-w-md font-medium italic leading-relaxed">"The expert in anything was once a beginner. Keep pushing forward, stay curious, and unlock your full potential today!"</p>
                <div class="mt-6 flex flex-wrap gap-4 items-center">
                    <a href="Courses.php" class="bg-navy text-white px-8 py-3 rounded-2xl font-black uppercase tracking-widest text-[10px] italic hover:bg-navy-dark transition-all flex items-center gap-2 shadow-xl shadow-navy/20 active:scale-95">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        Register Course
                    </a>
                    
                    <div class="relative group/search">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-navy/30 w-4 h-4 group-focus-within/search:text-navy transition-colors"></i>
                        <input type="text" id="dashboard-search" placeholder="Search for new courses..." class="pl-11 pr-6 py-3 rounded-2xl border border-navy/10 bg-white/50 backdrop-blur-md focus:outline-none focus:ring-2 focus:ring-navy/20 w-72 text-[11px] font-bold shadow-inner transition-all focus:w-80">
                    </div>
                </div>
            </div>

            <script>
                document.getElementById('dashboard-search')?.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        window.location.href = 'courses.php?search=' + encodeURIComponent(this.value);
                    }
                });
            </script>
            <div class="hidden lg:block relative">
                <div class="w-48 h-48 bg-white/20 backdrop-blur-3xl rounded-full flex items-center justify-center border-4 border-white shadow-2xl relative overflow-hidden group/welcome-logo">
                    <!-- Premium Brand Logo (Large Version) -->
                    <div class="relative flex flex-col items-center justify-center transition-transform duration-700 group-hover/welcome-logo:scale-110">
                        <!-- Graduation Cap (Top Part) -->
                        <div class="relative z-20 mb-[-8px] transition-transform duration-500">
                            <i data-lucide="graduation-cap" class="w-20 h-20 text-navy drop-shadow-xl"></i>
                        </div>
                        
                        <!-- 3D Pedestal Blocks (Bottom Part) -->
                        <div class="relative z-10 flex flex-col items-center gap-1">
                            <div class="flex gap-1">
                                <div class="w-6 h-6 bg-[#4CAF50] rounded-sm shadow-lg"></div>
                                <div class="w-6 h-6 bg-[#2196F3] rounded-sm shadow-lg"></div>
                            </div>
                            <div class="w-6 h-6 bg-[#FF9800] rounded-sm shadow-lg"></div>
                        </div>
                    </div>

                    <!-- Ambient Glow -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400/10 to-transparent"></div>
                </div>
                
                <!-- Orbiting Rings for premium feel -->
                <div class="absolute inset-0 border border-white/30 rounded-full scale-110 animate-[spin_20s_linear_infinite]"></div>
                <div class="absolute inset-0 border border-white/10 rounded-full scale-125 animate-[spin_30s_linear_infinite_reverse]"></div>
            </div>
        </div>
        <!-- Decorative blob -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-navy opacity-[0.03] rounded-full blur-3xl pointer-events-none group-hover:bg-navy-light group-hover:opacity-5 transition-all duration-700"></div>
    </div>

    <!-- Summary Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 relative z-10">
        <!-- Total Registered -->
        <div data-aos="fade-up" data-aos-delay="100" class="bg-navy/15 backdrop-blur-xl p-6 rounded-2xl shadow-xl shadow-navy/10 border-t-4 border-navy border-l border-r border-b border-navy/20 hover-lift transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-navy text-white rounded-xl shadow-lg shadow-navy/20">
                    <i data-lucide="book-open" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-navy/60 font-bold uppercase tracking-widest text-[10px] mb-1">Total Registered</h3>
            <p class="text-3xl font-black text-navy leading-none"><?php echo $total_registered; ?></p>
        </div>

        <!-- Pending Approvals -->
        <div data-aos="fade-up" data-aos-delay="200" class="bg-amber-500/15 backdrop-blur-xl p-6 rounded-2xl shadow-xl shadow-amber-500/10 border-t-4 border-amber-400 border-l border-r border-b border-amber-500/20 hover-lift transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-500 text-white rounded-xl shadow-lg shadow-amber-500/20">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
                <span class="text-[9px] font-black text-amber-600 bg-amber-100 px-3 py-1.5 rounded-full uppercase tracking-widest border border-amber-200">Awaiting Review</span>
            </div>
            <h3 class="text-amber-700/60 font-bold uppercase tracking-widest text-[10px] mb-1">Pending Approvals</h3>
            <p class="text-3xl font-black text-navy leading-none"><?php echo $pending_approvals; ?></p>
        </div>

        <!-- Approved Courses -->
        <div data-aos="fade-up" data-aos-delay="300" class="bg-green-500/15 backdrop-blur-xl p-6 rounded-2xl shadow-xl shadow-green-500/10 border-t-4 border-green-500 border-l border-r border-b border-green-500/20 hover-lift transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-500 text-white rounded-xl shadow-lg shadow-green-500/20">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
                <span class="text-[9px] font-black text-green-600 bg-green-100 px-3 py-1.5 rounded-full uppercase tracking-widest border border-green-200">Successfully Joined</span>
            </div>
            <h3 class="text-green-700/60 font-bold uppercase tracking-widest text-[10px] mb-1">Approved Courses</h3>
            <p class="text-3xl font-black text-navy leading-none"><?php echo $approved_courses; ?></p>
        </div>
    </div>

    <!-- Main Content Section (Split View) -->
    <div class="grid grid-cols-1 gap-8">
        <!-- Announcements/Timeline -->
        <div data-aos="fade-up" data-aos-delay="400" class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-xl shadow-navy/5 border border-white/50 relative z-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-black text-navy uppercase italic">Recent Activity</h2>
                <button class="text-navy text-sm font-semibold hover:underline">View All</button>
            </div>
            <div class="space-y-6">
                <?php if (empty($recent_activity)): ?>
                    <p class="text-gray-500">No recent activity found.</p>
                <?php else: ?>
                    <?php foreach($recent_activity as $index => $activity): ?>
                    <div class="flex gap-4">
                        <div class="mt-1 flex-shrink-0 w-8 h-8 rounded-full <?php echo $index === 0 ? 'bg-navy text-white ring-4 ring-blue-50' : 'bg-blue-100 text-navy'; ?> flex items-center justify-center font-bold text-xs">
                            <?php echo $index + 1; ?>
                        </div>
                        <div>
                            <h4 class="font-bold text-navy">"<?php echo htmlspecialchars($activity['course_title']); ?>"</h4>
                            <p class="text-sm text-gray-500">
                                <?php 
                                    if ($activity['status'] == 'pending') echo "Registration pending approval.";
                                    elseif ($activity['status'] == 'approved') echo "Registration approved! Access granted.";
                                    else echo "Registration status: " . htmlspecialchars($activity['status']);
                                ?>
                            </p>
                            <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400"><?php echo date('M d, Y h:i A', strtotime($activity['created_at'])); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>


    </div>
</div>

<?php include 'includes/footer.php'; ?>
