<?php
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

$db = getDBConnection();
$success = $_GET['success'] ?? "";

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $db->prepare("SELECT class_image FROM timetable WHERE id = ?");
    $stmt->execute([$id]);
    $entry = $stmt->fetch();
    
    if ($entry) {
        if (file_exists("../" . $entry['class_image'])) {
            unlink("../" . $entry['class_image']);
        }
        $db->prepare("DELETE FROM timetable WHERE id = ?")->execute([$id]);
        header("Location: manage-timetable.php?success=Entry deleted successfully");
        exit;
    }
}

$timetable = $db->query("SELECT * FROM timetable ORDER BY FIELD(day_name, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), class_time ASC")->fetchAll();

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';
?>

<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-navy italic uppercase tracking-tighter">Manage Timetable</h2>
            <p class="text-blue-400 text-xs font-bold uppercase tracking-widest mt-1">Organize and update weekly class schedules</p>
        </div>
        <a href="add-timetable.php" class="bg-navy text-white px-8 py-4 rounded-2xl font-black uppercase italic tracking-widest text-xs hover:bg-navy-light transition-all shadow-xl shadow-navy/20 flex items-center gap-3">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add New Entry
        </a>
    </div>

    <?php if ($success): ?>
        <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl font-bold italic text-sm">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($timetable as $entry): ?>
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-navy/5 overflow-hidden group hover:border-navy/20 transition-all">
                <div class="relative h-48 overflow-hidden">
                    <img src="../<?php echo $entry['class_image']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Class Image">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-[10px] font-black uppercase text-navy italic shadow-lg">
                        <?php echo $entry['day_name']; ?>
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-xl font-black text-navy italic mb-1 truncate"><?php echo htmlspecialchars($entry['class_name']); ?></h3>
                    <div class="flex items-center gap-2 text-blue-400 mb-6">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span class="text-xs font-bold uppercase tracking-widest"><?php echo htmlspecialchars($entry['class_time']); ?></span>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <a href="edit-timetable.php?id=<?php echo $entry['id']; ?>" class="flex-1 bg-gray-50 text-navy py-3 rounded-xl text-center text-[10px] font-black uppercase tracking-widest italic hover:bg-navy hover:text-white transition-all">
                            Edit Entry
                        </a>
                        <button onclick="confirmDelete(<?php echo $entry['id']; ?>)" class="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-lg shadow-red-500/5">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($timetable)): ?>
            <div class="col-span-full py-20 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200 text-center">
                <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                    <i data-lucide="calendar-x" class="text-gray-300 w-10 h-10"></i>
                </div>
                <h3 class="text-xl font-black text-navy italic">No Timetable Entries</h3>
                <p class="text-gray-400 text-sm mt-2 font-bold italic">Start by adding your first scheduled class</p>
                <a href="add-timetable.php" class="inline-block mt-6 text-navy font-black underline hover:text-blue-500 transition-colors uppercase tracking-widest text-xs">Add Class Now</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this timetable entry?')) {
        window.location.href = 'manage-timetable.php?delete=' + id;
    }
}
</script>

<?php include 'includes/footer.php'; ?>
