<?php
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

$db = getDBConnection();
$msg = "";

// Delete Logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Get file paths to delete from server
    $stmt = $db->prepare("SELECT image, video_zip FROM courses WHERE id = ?");
    $stmt->execute([$id]);
    $course = $stmt->fetch();
    
    if ($course) {
        if (file_exists("../" . $course['image'])) unlink("../" . $course['image']);
        if (file_exists("../" . $course['video_zip'])) unlink("../" . $course['video_zip']);
        
        $stmt = $db->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        $msg = "Course deleted successfully!";
    }
}

// Get Search Term
$search = trim($_GET['search'] ?? '');

// Fetch courses
$query = "SELECT * FROM courses";
if ($search) {
    $query .= " WHERE course_title LIKE :search OR instructor LIKE :search OR description LIKE :search";
}
$query .= " ORDER BY created_at DESC";

$stmt = $db->prepare($query);
if ($search) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}
$courses = $stmt->fetchAll();

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';
?>

<div class="max-w-7xl mx-auto">
    <?php if ($msg): ?>
        <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl">
            <p class="text-sm font-bold"><?php echo $msg; ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex flex-col md:flex-row items-center justify-between gap-4">
            <h2 class="text-xl font-black text-navy uppercase tracking-tight shrink-0">Course Catalog</h2>
            
            <div class="flex flex-1 items-center gap-4 w-full md:max-w-xl">
                <form action="" method="GET" class="relative flex-1">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                    <input type="text" name="search" id="adminSearchInput" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search courses by title, instructor or price..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all text-xs font-bold">
                </form>
                <a href="add-course.php" class="bg-navy text-white px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-navy-dark transition-all flex items-center gap-2 shrink-0">
                    <i data-lucide="plus" class="w-4 h-4"></i> Add Course
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Course Info</th>
                        <th class="px-8 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Instructor</th>
                        <th class="px-8 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Duration</th>
                        <th class="px-8 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Price</th>
                        <th class="px-8 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if (empty($courses)): ?>
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center opacity-20">
                                    <i data-lucide="book-open" class="w-16 h-16 mb-4"></i>
                                    <p class="font-black uppercase tracking-widest text-xs">No courses found in catalog</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: foreach ($courses as $course): ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <img src="../<?php echo $course['image']; ?>" alt="Course" class="w-14 h-14 rounded-2xl object-cover shadow-sm">
                                    <div>
                                        <p class="font-black text-navy leading-none mb-1"><?php echo htmlspecialchars($course['course_title']); ?></p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Added: <?php echo date('M d, Y', strtotime($course['created_at'])); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-600"><?php echo htmlspecialchars($course['instructor']); ?></td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-600"><?php echo htmlspecialchars($course['duration']); ?></td>
                            <td class="px-8 py-6 font-black text-navy">Rs. <?php echo number_format($course['price'], 2); ?></td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <a href="edit-course.php?id=<?php echo $course['id']; ?>" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </a>
                                    <a href="manage-courses.php?delete=<?php echo $course['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this course? This will permanently remove all associated files.')"
                                       class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </a>
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
