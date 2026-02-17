<?php 
require_once 'includes/auth_check.php';
require_login();
require_once 'config/database.php';

$db = getDBConnection();
$user_id = $_SESSION['user_id'];

// Fetch only approved courses for this student that have an uploaded zip file
$stmt = $db->prepare("
    SELECT c.*, r.created_at as approval_date 
    FROM registrations r 
    JOIN courses c ON r.course_id = c.id 
    WHERE r.user_id = ? 
    AND r.status = 'approved' 
    AND c.video_zip IS NOT NULL 
    AND c.video_zip != ''
    ORDER BY r.created_at DESC
");
$stmt->execute([$user_id]);
$approved_courses = $stmt->fetchAll();

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
?>

<div class="max-w-7xl mx-auto px-4 md:px-8">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-navy italic tracking-tight mb-2">My Learning <span class="text-blue-600">Assets</span></h1>
        <p class="text-gray-500 italic font-medium leading-relaxed max-w-2xl">Access your high-quality learning materials, video lectures, and study guides for all your approved Courses.</p>
    </div>

    <!-- Downloads List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (empty($approved_courses)): ?>
            <div class="col-span-full py-20 px-10 text-center bg-white rounded-[3rem] border-2 border-dashed border-gray-100 flex flex-col items-center justify-center">
                <div class="w-24 h-24 bg-navy/5 rounded-full flex items-center justify-center mb-6 text-navy/20">
                    <i data-lucide="lock" class="w-12 h-12"></i>
                </div>
                <h3 class="text-2xl font-black text-navy italic uppercase tracking-widest mb-4">Access Restricted</h3>
                <p class="text-gray-400 font-bold italic mb-8 max-w-sm">You haven't been approved for any Courses yet. Materials will appear here once an admin confirms your registration.</p>
                <a href="courses.php" class="bg-navy text-white px-8 py-4 rounded-2xl font-black uppercase italic tracking-widest text-xs shadow-xl shadow-navy/20 hover:scale-105 transition-transform flex items-center gap-3">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    Browse Course Catalog
                </a>
            </div>
        <?php else: foreach ($approved_courses as $course): 
            $file_path = __DIR__ . '/' . $course['video_zip'];
            $file_size = 'N/A';
            $file_ext = 'ZIP';
            
            if (!empty($course['video_zip']) && file_exists($file_path)) {
                $size_bytes = @filesize($file_path);
                if ($size_bytes) {
                    $file_size = round($size_bytes / (1024 * 1024), 2) . ' MB';
                }
                $file_ext = strtoupper(pathinfo($file_path, PATHINFO_EXTENSION));
            }
        ?>
            <!-- Download Item -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all group relative overflow-hidden h-full flex flex-col">
                <!-- Status Badge -->
                <div class="absolute top-0 right-0 py-2 px-6 bg-green-500 text-white text-[10px] font-black uppercase tracking-widest italic rounded-bl-3xl">
                    Approved
                </div>

                <div class="flex flex-col h-full">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-navy flex items-center justify-center mb-6 group-hover:bg-navy group-hover:text-white transition-colors duration-500">
                        <i data-lucide="<?php echo ($file_ext === 'PDF') ? 'file-text' : 'archive'; ?>" class="w-8 h-8"></i>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="font-black text-navy text-xl leading-tight uppercase italic mb-2 line-clamp-2"><?php echo htmlspecialchars($course['course_title']); ?></h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-6 italic">Instructor: <?php echo htmlspecialchars($course['instructor']); ?></p>
                        
                        <div class="flex items-center gap-3 mb-8">
                            <span class="text-[9px] font-black text-navy bg-navy/5 px-3 py-1 rounded-full uppercase italic tracking-widest"><?php echo $file_size; ?></span>
                            <span class="text-[9px] font-black text-navy bg-navy/5 px-3 py-1 rounded-full uppercase italic tracking-widest"><?php echo $file_ext; ?></span>
                        </div>
                    </div>

                    <a href="<?php echo htmlspecialchars($course['video_zip']); ?>" download class="w-full bg-navy text-white py-4 rounded-2xl font-black uppercase italic tracking-widest text-xs flex items-center justify-center gap-3 shadow-xl shadow-navy/20 hover:bg-navy-dark transition-all group-hover:scale-[1.02]">
                        <i data-lucide="download-cloud" class="w-5 h-5"></i>
                        Download Now
                    </a>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
