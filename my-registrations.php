<?php 
require_once 'includes/auth_check.php';
require_login();
require_once 'config/database.php';

$db = getDBConnection();
$user_id = $_SESSION['user_id'];

// Fetch student's registrations
$stmt = $db->prepare("
    SELECT r.*, c.course_title 
    FROM registrations r 
    JOIN courses c ON r.course_id = c.id 
    WHERE r.user_id = ? 
    ORDER BY r.created_at DESC
");
$stmt->execute([$user_id]);
$registrations = $stmt->fetchAll();

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
    <!-- Mesh Gradients (Boosted Intensity) -->
    <div class="absolute top-0 left-0 w-full h-full opacity-40 bg-[radial-gradient(circle_at_0%_0%,#4CAF50_0%,transparent_60%),radial-gradient(circle_at_100%_0%,#2196F3_0%,transparent_60%),radial-gradient(circle_at_50%_100%,#FF9800_0%,transparent_60%)]"></div>
    
    <!-- Animated Blobs (Increased Opacity & Size) -->
    <div class="absolute top-[-10%] left-[-15%] w-[600px] h-[600px] bg-navy/20 rounded-full blur-[120px] animate-blob"></div>
    <div class="absolute bottom-[0%] right-[-10%] w-[700px] h-[700px] bg-blue-600/20 rounded-full blur-[120px] animate-blob" style="animation-delay: -5s;"></div>
    <div class="absolute top-[20%] right-[10%] w-[500px] h-[500px] bg-orange-500/20 rounded-full blur-[100px] animate-blob" style="animation-delay: -2s;"></div>
    
    <!-- Pattern (More visible) -->
    <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
</div>

<script>
    // Ensure the main container is relative for absolute positioning
    document.querySelector('main').classList.add('relative');
</script>

<div class="max-w-7xl mx-auto relative z-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-navy">My Registrations</h1>
            <p class="text-gray-500">Track the status of your course applications and payments.</p>
        </div>
        <div class="relative">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input type="text" id="reg-search" placeholder="Search registrations..." class="pl-12 pr-6 py-3 rounded-2xl border border-white/50 bg-white/50 backdrop-blur-md focus:outline-none focus:ring-2 focus:ring-navy/20 w-80 shadow-xl shadow-navy/5">
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="mb-8 p-6 bg-green-50/80 backdrop-blur-xl border-l-4 border-green-500 rounded-2xl flex items-center gap-4 shadow-sm animate-bounce-subtle">
            <div class="bg-green-500 text-white p-2 rounded-xl">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-green-800 font-black italic uppercase tracking-widest text-sm">Registration Submitted!</p>
                <p class="text-green-700 text-xs font-bold italic">Your request is currently being reviewed by our academic board. You will receive access once approved.</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Registrations Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <?php if (empty($registrations)): ?>
            <div class="col-span-full py-20 text-center bg-white/80 backdrop-blur-xl rounded-[3rem] border-2 border-dashed border-gray-100 italic">
                <i data-lucide="inbox" class="w-16 h-16 text-gray-200 mx-auto mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400 font-bold uppercase italic">No Registrations Found</h3>
                <p class="text-gray-400 mt-2">You haven't registered for any courses yet.</p>
                <a href="courses.php" class="mt-6 inline-block bg-navy text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest italic shadow-xl shadow-navy/20 active:scale-95 transition-all">Browse Catalog</a>
            </div>
        <?php else: foreach ($registrations as $reg): 
            $status_classes = [
                'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                'approved' => 'bg-green-50 text-green-600 border-green-100',
                'rejected' => 'bg-red-50 text-red-600 border-red-100'
            ];
            $status_dot = [
                'pending' => 'bg-amber-500',
                'approved' => 'bg-green-500',
                'rejected' => 'bg-red-500'
            ];
        ?>
            <!-- Registration Card -->
            <div class="registration-card bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white/50 shadow-sm hover:shadow-2xl transition-all duration-500 group overflow-hidden flex flex-col h-full relative" data-title="<?php echo strtolower(htmlspecialchars($reg['course_title'])); ?>">
                <!-- Status Badge (Floating) -->
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black uppercase italic border bg-white/90 backdrop-blur-sm <?php echo $status_classes[$reg['status']]; ?>">
                        <span class="w-1.5 h-1.5 rounded-full <?php echo $status_dot[$reg['status']]; ?> <?php echo ($reg['status'] === 'pending') ? 'animate-pulse' : ''; ?>"></span>
                        <?php echo $reg['status']; ?>
                    </span>
                </div>

                <!-- Card Content -->
                <div class="p-8 flex flex-col h-full">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-navy/5 text-navy flex items-center justify-center shrink-0 border border-navy/5">
                            <i data-lucide="book" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] mb-1">Registration</p>
                            <h3 class="text-xl font-black text-navy italic leading-tight line-clamp-1"><?php echo htmlspecialchars($reg['course_title']); ?></h3>
                        </div>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center justify-between text-xs py-2 border-b border-gray-50 italic">
                            <span class="text-gray-400 font-bold uppercase tracking-widest text-[9px]">Roll Number</span>
                            <span class="text-navy font-black">REG-<?php echo str_pad($reg['id'], 5, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-xs py-2 border-b border-gray-50 italic">
                            <span class="text-gray-400 font-bold uppercase tracking-widest text-[9px]">Applied Date</span>
                            <span class="text-navy font-bold"><?php echo date('M d, Y', strtotime($reg['created_at'])); ?></span>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-auto mb-4">
                        <a href="<?php echo htmlspecialchars($reg['payment_receipt']); ?>" target="_blank" class="flex-1 flex items-center justify-center gap-2 bg-gray-50 text-gray-500 py-3 rounded-2xl text-[10px] font-black uppercase italic border border-gray-100 hover:bg-navy hover:text-white hover:border-navy transition-all">
                            <i data-lucide="image" class="w-3.5 h-3.5"></i>
                            View Receipt
                        </a>
                    </div>

                    <?php if ($reg['status'] === 'approved'): ?>
                        <a href="course-assets.php?course_id=<?php echo $reg['course_id']; ?>" class="w-full flex items-center justify-center gap-3 bg-green-500 text-white py-4 rounded-3xl font-black uppercase italic text-xs shadow-xl shadow-green-500/20 hover:bg-green-600 transition-all active:scale-95 group/btn">
                            Enroll Course
                            <i data-lucide="play" class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>
                    <?php else: ?>
                        <div class="w-full py-4 rounded-3xl text-center bg-gray-100 text-gray-400 font-black uppercase italic text-[9px] tracking-widest border border-gray-100">
                            Awaiting Full Access
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('reg-search');
        const regCards = document.querySelectorAll('.registration-card');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase();
                
                regCards.forEach(card => {
                    const title = card.getAttribute('data-title');
                    if (title.includes(query)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
