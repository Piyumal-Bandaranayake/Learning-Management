<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

$db = getDBConnection();
$success = $_GET['success'] ?? "";

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Get image path before deleting
    $stmt = $db->prepare("SELECT class_image FROM timetable WHERE id = ?");
    $stmt->execute([$id]);
    $entry = $stmt->fetch();
    
    if ($entry && !empty($entry['class_image'])) {
        $image_path = "../" . $entry['class_image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    $stmt = $db->prepare("DELETE FROM timetable WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage-timetable.php?success=Entry deleted successfully");
    exit;
}

// Order by custom field order for days, then time
$timetable = $db->query("SELECT * FROM timetable ORDER BY FIELD(day_name, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), class_time ASC")->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';
?>

<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-navy italic uppercase tracking-tighter">Manage Timetable</h2>
            <p class="text-blue-400 text-xs font-bold uppercase tracking-widest mt-1">Organize and update physical class schedules</p>
        </div>
        <a href="add-timetable.php" class="bg-navy text-white px-8 py-4 rounded-2xl font-black uppercase italic tracking-widest text-xs hover:bg-navy-light transition-all shadow-xl shadow-navy/20 flex items-center gap-3">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add New Session
        </a>
    </div>

    <?php if ($success): ?>
        <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl font-bold italic text-sm">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-navy/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-navy text-white">
                        <th class="py-5 px-6 text-[10px] font-black uppercase tracking-widest italic">Image</th>
                        <th class="py-5 px-6 text-[10px] font-black uppercase tracking-widest italic">Day & Time</th>
                        <th class="py-5 px-6 text-[10px] font-black uppercase tracking-widest italic">Class Title</th>
                        <th class="py-5 px-6 text-[10px] font-black uppercase tracking-widest italic">Instructor</th>
                        <th class="py-5 px-6 text-[10px] font-black uppercase tracking-widest italic">Location</th>
                        <th class="py-5 px-6 text-right text-[10px] font-black uppercase tracking-widest italic">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($timetable)): ?>
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400 font-bold italic">No classes scheduled yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($timetable as $entry): ?>
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-5 px-6">
                                    <div class="w-16 h-12 rounded-lg bg-gray-100 overflow-hidden border border-gray-100">
                                        <?php if (!empty($entry['class_image'])): ?>
                                            <img src="../<?php echo htmlspecialchars($entry['class_image']); ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                                <i data-lucide="image" class="w-4 h-4 text-gray-300"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-navy italic"><?php echo htmlspecialchars($entry['day_name']); ?></span>
                                        <span class="text-xs font-bold text-blue-500 italic"><?php echo date('h:i A', strtotime($entry['class_time'])); ?> (<?php echo htmlspecialchars($entry['duration']); ?>)</span>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <span class="text-sm font-bold text-gray-700 italic"><?php echo htmlspecialchars($entry['class_title']); ?></span>
                                    <p class="text-[10px] text-gray-400 truncate w-48"><?php echo htmlspecialchars($entry['short_description']); ?></p>
                                </td>
                                <td class="py-5 px-6">
                                    <span class="text-xs font-bold text-gray-600 italic"><?php echo htmlspecialchars($entry['instructor']); ?></span>
                                </td>
                                <td class="py-5 px-6">
                                    <span class="text-xs font-bold text-navy italic bg-blue-50 px-2 py-1 rounded-lg"><?php echo htmlspecialchars($entry['location']); ?></span>
                                </td>
                                <td class="py-5 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="edit-timetable.php?id=<?php echo $entry['id']; ?>" class="p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </a>
                                        <a href="manage-timetable.php?delete=<?php echo $entry['id']; ?>" onclick="return confirm('Delete this session?');" class="p-2 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
