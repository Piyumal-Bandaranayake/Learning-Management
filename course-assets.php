<?php 
require_once 'includes/auth_check.php';
require_login();
require_once 'config/database.php';

$db = getDBConnection();
$user_id = $_SESSION['user_id'];
$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;

if (!$course_id) {
    header("Location: my-registrations.php");
    exit;
}

// Verify registration and fetch course details
$stmt = $db->prepare("
    SELECT c.*, r.status 
    FROM registrations r 
    JOIN courses c ON r.course_id = c.id 
    WHERE r.user_id = ? AND r.course_id = ? AND r.status = 'approved'
");
$stmt->execute([$user_id, $course_id]);
$course = $stmt->fetch();

if (!$course) {
    die("Course not found or access not approved.");
}

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
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

<!-- Background Design Elements -->
<div class="absolute inset-0 pointer-events-none overflow-hidden -z-10">
    <!-- Mesh Gradients -->
    <div class="absolute top-0 left-0 w-full h-full opacity-40 bg-[radial-gradient(circle_at_0%_0%,#4CAF50_0%,transparent_60%),radial-gradient(circle_at_100%_0%,#2196F3_0%,transparent_60%),radial-gradient(circle_at_50%_100%,#FF9800_0%,transparent_60%)]"></div>
    
    <!-- Animated Blobs -->
    <div class="absolute top-[-10%] left-[-15%] w-[600px] h-[600px] bg-navy/20 rounded-full blur-[120px] animate-blob"></div>
    <div class="absolute bottom-[0%] right-[-10%] w-[700px] h-[700px] bg-blue-600/20 rounded-full blur-[120px] animate-blob" style="animation-delay: -5s;"></div>
    <div class="absolute top-[20%] right-[10%] w-[500px] h-[500px] bg-orange-500/20 rounded-full blur-[100px] animate-blob" style="animation-delay: -2s;"></div>
    
    <!-- Pattern -->
    <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
</div>

<script>
    // Ensure the main container is relative for absolute positioning
    setTimeout(() => {
        const main = document.querySelector('main');
        if (main) main.classList.add('relative');
    }, 100);
</script>

<div class="max-w-7xl mx-auto px-4 md:px-8">
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-navy italic tracking-tight mb-2">
                Course <span class="text-blue-600">Assets</span>
            </h1>
            <p class="text-gray-500 italic font-medium leading-relaxed max-w-2xl">
                Zip files and resources for <span class="text-navy font-bold">"<?php echo htmlspecialchars($course['course_title']); ?>"</span>
            </p>
        </div>
        <a href="my-registrations.php" class="bg-gray-100 text-gray-500 px-6 py-3 rounded-2xl font-black uppercase italic tracking-widest text-[10px] hover:bg-navy hover:text-white transition-all flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Registrations
        </a>
    </div>

    <!-- Assets List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php 
        // We'll look for the primary zip file first
        if (!empty($course['video_zip'])): 
            $file_path = __DIR__ . '/' . $course['video_zip'];
            $file_size = 'N/A';
            $file_ext = 'ZIP';
            
            if (file_exists($file_path)) {
                $size_bytes = @filesize($file_path);
                if ($size_bytes) {
                    $file_size = round($size_bytes / (1024 * 1024), 2) . ' MB';
                }
                $file_ext = strtoupper(pathinfo($file_path, PATHINFO_EXTENSION));
            }
        ?>
            <!-- Main Content Zip -->
            <div data-aos="fade-up" class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 shadow-xl shadow-navy/5 border border-white/50 hover:shadow-2xl hover:-translate-y-2 transition-all group relative overflow-hidden h-full flex flex-col">
                <div class="absolute top-0 right-0 py-2 px-6 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest italic rounded-bl-3xl">
                    Main Asset
                </div>

                <div class="flex flex-col h-full">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-navy flex items-center justify-center mb-6 group-hover:bg-navy group-hover:text-white transition-colors duration-500">
                        <i data-lucide="archive" class="w-8 h-8"></i>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="font-black text-navy text-xl leading-tight uppercase italic mb-2 line-clamp-2">Course Package</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-6 italic">Full video lectures and materials</p>
                        
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
        <?php else: ?>
            <div class="col-span-full py-20 px-10 text-center bg-white/80 backdrop-blur-xl rounded-[3rem] border-2 border-dashed border-white/50 flex flex-col items-center justify-center">
                <div class="w-24 h-24 bg-navy/10 rounded-full flex items-center justify-center mb-6 text-navy/40">
                    <i data-lucide="file-warning" class="w-12 h-12"></i>
                </div>
                <h3 class="text-2xl font-black text-navy italic uppercase tracking-widest mb-4">No Zip Files Found</h3>
                <p class="text-gray-400 font-bold italic max-w-sm">There are no zip files uploaded for this course yet. Please check back later or contact your instructor.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
