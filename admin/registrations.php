<?php 
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

$db = getDBConnection();

// Handle Status Updates
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $new_status = ($_GET['action'] === 'approve') ? 'approved' : (($_GET['action'] === 'reject') ? 'rejected' : 'pending');
    
    $stmt = $db->prepare("UPDATE registrations SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $id]);
    header("Location: registrations.php?updated=1");
    exit;
}

// Fetch Stats
$new_requests = $db->query("SELECT COUNT(*) FROM registrations WHERE status = 'pending'")->fetchColumn();
$total_approved = $db->query("SELECT COUNT(*) FROM registrations WHERE status = 'approved'")->fetchColumn();
$rejected_requests = $db->query("SELECT COUNT(*) FROM registrations WHERE status = 'rejected'")->fetchColumn();

// Get Search Term
$search = trim($_GET['search'] ?? '');

// Fetch Registrations with User and Course Info (Excluding Approved)
$query = "
    SELECT r.*, u.name, u.email, c.course_title 
    FROM registrations r 
    JOIN users u ON r.user_id = u.id 
    JOIN courses c ON r.course_id = c.id 
    WHERE r.status != 'approved'
";

if (!empty($search)) {
    $query .= " AND (u.name LIKE :search OR u.email LIKE :search OR c.course_title LIKE :search)";
}

$query .= " ORDER BY r.created_at DESC";

$stmt = $db->prepare($query);
if (!empty($search)) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}
$registrations = $stmt->fetchAll();

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
include 'includes/navbar.php'; 
?>

<div class="max-w-7xl mx-auto px-4">
    <!-- Registration Stats Mini -->
    <div class="flex gap-4 mb-8 overflow-x-auto pb-4 scrollbar-hide">
        <div class="bg-navy text-white px-6 py-4 rounded-3xl flex items-center gap-4 shrink-0 shadow-xl shadow-navy/20">
            <span class="text-3xl font-black"><?php echo $new_requests; ?></span>
            <span class="text-[10px] uppercase font-bold tracking-widest leading-none">New <br> Requests</span>
        </div>
        <div class="bg-white border border-gray-100 px-6 py-4 rounded-3xl flex items-center gap-4 shrink-0 shadow-sm">
            <span class="text-3xl font-black text-navy"><?php echo $total_approved; ?></span>
            <span class="text-[10px] uppercase font-bold tracking-widest leading-none text-gray-400">Total <br> Approved</span>
        </div>
        <div class="bg-white border border-gray-100 px-6 py-4 rounded-3xl flex items-center gap-4 shrink-0 shadow-sm">
            <span class="text-3xl font-black text-red-500"><?php echo $rejected_requests; ?></span>
            <span class="text-[10px] uppercase font-bold tracking-widest leading-none text-gray-400">Rejected <br> Requests</span>
        </div>
    </div>

    <!-- Filters row -->
    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <form action="" method="GET" class="flex-1 relative">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input type="text" name="search" id="adminSearchInput" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by student name, email or course title..." class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-100 bg-white focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all shadow-sm text-sm">
        </form>
    </div>

    <?php if (isset($_GET['updated'])): ?>
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl font-bold text-sm">
            Registration status updated successfully!
        </div>
    <?php endif; ?>

    <!-- Main Table -->
    <div class="bg-white rounded-3xl shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-navy text-white">
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em]">Student Details</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em]">Desired Course</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em]">Receipt</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em]">Final Status</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-center">Admin Controls</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if (empty($registrations)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 font-bold">No enrollment requests found.</td>
                        </tr>
                    <?php else: foreach ($registrations as $reg): ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($reg['name']); ?>&background=F3F4F6&color=0B3C5D" class="w-10 h-10 rounded-xl" alt="Student">
                                    <div>
                                        <p class="font-bold text-navy"><?php echo htmlspecialchars($reg['name']); ?></p>
                                        <p class="text-[10px] text-gray-400 font-bold"><?php echo htmlspecialchars($reg['email']); ?></p>
                                        <p class="text-[10px] text-blue-500 font-bold"><?php echo htmlspecialchars($reg['phone']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="block text-sm font-bold text-navy"><?php echo htmlspecialchars($reg['course_title']); ?></span>
                                <span class="text-[10px] text-gray-400 font-black uppercase">Applied: <?php echo date('M d, Y', strtotime($reg['created_at'])); ?></span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <a href="../<?php echo htmlspecialchars($reg['payment_receipt']); ?>" target="_blank" class="inline-block bg-blue-50 text-navy p-2.5 rounded-xl hover:bg-navy hover:text-white transition-all shadow-sm">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </a>
                            </td>
                            <td class="px-6 py-5">
                                <?php 
                                $status_classes = [
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'approved' => 'bg-green-50 text-green-600 border-green-100',
                                    'rejected' => 'bg-red-50 text-red-600 border-red-100'
                                ];
                                $status_dots = [
                                    'pending' => 'bg-amber-600',
                                    'approved' => 'bg-green-600',
                                    'rejected' => 'bg-red-600'
                                ];
                                ?>
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-black uppercase border <?php echo $status_classes[$reg['status']]; ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?php echo $status_dots[$reg['status']]; ?>"></span>
                                    <?php echo ucfirst($reg['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <?php if ($reg['status'] !== 'approved'): ?>
                                        <a href="registrations.php?action=approve&id=<?php echo $reg['id']; ?>" class="bg-green-500 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase shadow-lg shadow-green-500/20 hover:scale-105 transition-transform active:scale-95">Approve</a>
                                    <?php endif; ?>
                                    <?php if ($reg['status'] !== 'rejected'): ?>
                                        <a href="registrations.php?action=reject&id=<?php echo $reg['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase shadow-lg shadow-red-500/20 hover:scale-105 transition-transform active:scale-95">Reject</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
