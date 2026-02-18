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

<div class="max-w-7xl mx-auto">
    <!-- Welcome Section -->
    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100 mb-8 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-navy mb-2">Welcome back, <?php echo htmlspecialchars(explode(' ', $_SESSION['name'] ?? 'Student')[0]); ?>! 👋</h1>
                <p class="text-gray-500 max-w-md">You have 2 Courses today and 3 pending approvals. Keep up the great work and stay on track with your studies.</p>
                <div class="mt-6 flex flex-wrap gap-4">
                    <a href="Courses.php" class="bg-navy text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-navy-dark transition-all flex items-center gap-2 shadow-lg shadow-navy/20">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Register Course
                    </a>

                </div>
            </div>
            <div class="hidden lg:block">
                <div class="w-48 h-48 bg-blue-50 rounded-full flex items-center justify-center border-4 border-white shadow-inner">
                    <i data-lucide="graduation-cap" class="w-24 h-24 text-navy opacity-80"></i>
                </div>
            </div>
        </div>
        <!-- Decorative blob -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-navy opacity-[0.03] rounded-full blur-3xl pointer-events-none group-hover:bg-navy-light group-hover:opacity-5 transition-all duration-700"></div>
    </div>

    <!-- Summary Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Courses -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-navy border-l border-r border-b border-gray-100 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-xl">
                    <i data-lucide="book-open" class="text-navy w-6 h-6"></i>
                </div>
                <!-- <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">+2 this week</span> -->
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Total Registered</h3>
            <p class="text-3xl font-bold text-navy"><?php echo $total_registered; ?></p>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-amber-400 border-l border-r border-b border-gray-100 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 rounded-xl">
                    <i data-lucide="clock" class="text-amber-500 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Awaiting Review</span>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Pending Approvals</h3>
            <p class="text-3xl font-bold text-navy"><?php echo $pending_approvals; ?></p>
        </div>

        <!-- Approved Courses -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-green-500 border-l border-r border-b border-gray-100 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 rounded-xl">
                    <i data-lucide="check-circle" class="text-green-500 w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">Successfully Joined</span>
            </div>
            <h3 class="text-gray-500 font-medium mb-1">Approved Courses</h3>
            <p class="text-3xl font-bold text-navy"><?php echo $approved_courses; ?></p>
        </div>
    </div>

    <!-- Main Content Section (Split View) -->
    <div class="grid grid-cols-1 gap-8">
        <!-- Announcements/Timeline -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-navy">Recent Activity</h2>
                <button class="text-navy text-sm font-semibold hover:underline">View All</button>
            </div>
            <div class="space-y-6">
                <?php if (empty($recent_activity)): ?>
                    <p class="text-gray-500 italic">No recent activity found.</p>
                <?php else: ?>
                    <?php foreach($recent_activity as $index => $activity): ?>
                    <div class="flex gap-4">
                        <div class="mt-1 flex-shrink-0 w-8 h-8 rounded-full <?php echo $index === 0 ? 'bg-navy text-white ring-4 ring-blue-50' : 'bg-blue-100 text-navy'; ?> flex items-center justify-center font-bold text-xs">
                            <?php echo $index + 1; ?>
                        </div>
                        <div>
                            <h4 class="font-bold text-navy italic">"<?php echo htmlspecialchars($activity['course_title']); ?>"</h4>
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
