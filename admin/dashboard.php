<?php 
require_once dirname(__DIR__, 1) . '/config/database.php';
$db = getDBConnection();

$student_count = $db->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
$course_count = $db->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$pending_count = $db->query("SELECT COUNT(*) FROM registrations WHERE status = 'pending'")->fetchColumn();
$approved_count = $db->query("SELECT COUNT(*) FROM registrations WHERE status = 'approved'")->fetchColumn();

// Fetch Newest Requests
$recent_requests = $db->query("
    SELECT r.*, u.name as student_name, c.course_title 
    FROM registrations r 
    JOIN users u ON r.user_id = u.id 
    JOIN courses c ON r.course_id = c.id 
    ORDER BY r.created_at DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
include 'includes/navbar.php'; 
?>

<div class="max-w-7xl mx-auto px-4">
    <!-- Grid Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Students -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border-t-4 border-navy hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-2xl text-navy">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-green-600 font-black">+12% vs last month</span>
            </div>
            <p class="text-3xl font-black text-navy tracking-tighter"><?php echo number_format($student_count); ?></p>
            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest leading-none mt-1">Total Active Students</p>
        </div>

        <!-- Courses -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border-t-4 border-navy hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-2xl text-navy">
                    <i data-lucide="book-open" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-navy font-black">Active Courses</span>
            </div>
            <p class="text-3xl font-black text-navy tracking-tighter"><?php echo number_format($course_count); ?></p>
            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest leading-none mt-1">Courses in Catalog</p>
        </div>

        <!-- Pending -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border-t-4 border-amber-400 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 rounded-2xl text-amber-500">
                    <i data-lucide="clock-4" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-amber-600 font-black">Awaiting Approval</span>
            </div>
            <p class="text-3xl font-black text-navy tracking-tighter"><?php echo number_format($pending_count); ?></p>
            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest leading-none mt-1">Pending Registrations</p>
        </div>

        <!-- Approved -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border-t-4 border-green-500 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 rounded-2xl text-green-500">
                    <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-green-600 font-black">Successfully Enrolled</span>
            </div>
            <p class="text-3xl font-black text-navy tracking-tighter"><?php echo number_format($approved_count); ?></p>
            <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest leading-none mt-1">Approved Enrollments</p>
        </div>
    </div>

    <!-- Recent Activity Tables Snippet -->
    <div class="grid grid-cols-1 gap-8">
        <!-- Recent Registrations -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-black text-navy uppercase text-sm tracking-widest">Newest Requests</h3>
                <a href="registrations.php" class="text-xs font-bold text-navy hover:underline">View All</a>
            </div>
            <div class="space-y-0">
                <?php if (empty($recent_requests)): ?>
                    <div class="p-8 text-center">
                        <p class="text-gray-400 text-sm">No new requests found.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($recent_requests as $request): ?>
                        <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-b-0">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($request['student_name']); ?>&background=F3F4F6&color=0B3C5D" class="w-10 h-10 rounded-xl" alt="<?php echo htmlspecialchars($request['student_name']); ?>">
                                <div>
                                    <p class="text-sm font-bold text-navy"><?php echo htmlspecialchars($request['student_name']); ?></p>
                                    <p class="text-[10px] text-gray-400 uppercase font-black"><?php echo htmlspecialchars($request['course_title']); ?></p>
                                </div>
                            </div>
                            <?php 
                                $status_class = 'text-amber-500 bg-amber-50';
                                if ($request['status'] === 'approved') $status_class = 'text-green-500 bg-green-50';
                                if ($request['status'] === 'rejected') $status_class = 'text-red-500 bg-red-50';
                            ?>
                            <span class="text-[10px] font-black uppercase <?php echo $status_class; ?> px-2 py-1 rounded">
                                <?php echo htmlspecialchars($request['status']); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
