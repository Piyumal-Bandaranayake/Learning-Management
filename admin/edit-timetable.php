<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

$db = getDBConnection();
$errors = [];
$success = "";

// Days of the week
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: manage-timetable.php");
    exit;
}

// Fetch current data
$stmt = $db->prepare("SELECT * FROM timetable WHERE id = ?");
$stmt->execute([$id]);
$entry = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$entry) {
    header("Location: manage-timetable.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_title = trim($_POST['class_title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $full_description = trim($_POST['full_description'] ?? '');
    $instructor = trim($_POST['instructor'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $day_name = trim($_POST['day_name'] ?? '');
    $class_time = trim($_POST['class_time'] ?? '');
    $duration = trim($_POST['duration'] ?? '');

    // Image Upload Logic
    $class_image = $entry['class_image']; // Default to existing image
    
    if (isset($_FILES['class_image']) && $_FILES['class_image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['class_image']['name'];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $filesize = $_FILES['class_image']['size'];

        if (!in_array($filetype, $allowed)) {
            $errors[] = "Error: Please select a valid file format (JPG, JPEG, PNG, WEBP).";
        } elseif ($filesize > 5 * 1024 * 1024) {
             $errors[] = "Error: File size is larger than the allowed limit (5MB).";
        } else {
             $new_filename = uniqid() . "." . $filetype;
             $upload_path = "../uploads/timetable/" . $new_filename;
             
             if (!is_dir('../uploads/timetable')) {
                 mkdir('../uploads/timetable', 0777, true);
             }

             if (move_uploaded_file($_FILES['class_image']['tmp_name'], $upload_path)) {
                 // Delete old image if it exists
                 if (!empty($entry['class_image']) && file_exists("../" . $entry['class_image'])) {
                     unlink("../" . $entry['class_image']);
                 }
                 $class_image = "uploads/timetable/" . $new_filename;
             } else {
                 $errors[] = "Error: Failed to upload image.";
             }
        }
    }


    // Validation
    if (empty($class_title) || empty($short_description) || empty($full_description) || empty($instructor) || empty($location) || empty($day_name) || empty($class_time) || empty($duration)) {
        $errors[] = "All fields are required.";
    }

    if (!in_array($day_name, $days)) {
        $errors[] = "Invalid day selected.";
    }

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("UPDATE timetable SET class_title = ?, short_description = ?, full_description = ?, instructor = ?, location = ?, day_name = ?, class_time = ?, duration = ?, class_image = ? WHERE id = ?");
            $stmt->execute([$class_title, $short_description, $full_description, $instructor, $location, $day_name, $class_time, $duration, $class_image, $id]);
            $success = "Timetable entry updated successfully!";
            
            // Refresh entry data
            $stmt = $db->prepare("SELECT * FROM timetable WHERE id = ?");
            $stmt->execute([$id]);
            $entry = $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="bg-navy p-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl font-black uppercase italic tracking-widest">Edit Class Session</h2>
                <p class="text-blue-200 text-xs mt-1 uppercase font-bold tracking-widest">Update physical class details</p>
            </div>
            <i data-lucide="edit-3" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 rotate-12"></i>
        </div>

        <div class="p-8">
            <?php if (!empty($errors)): ?>
                <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl">
                    <ul class="list-disc ml-5 text-sm font-bold italic">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl flex items-center justify-between">
                    <p class="text-sm font-bold italic"><?php echo htmlspecialchars($success); ?></p>
                    <a href="manage-timetable.php" class="bg-green-600 text-white px-4 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest italic">Return to List</a>
                </div>
            <?php endif; ?>

            <form action="edit-timetable.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                 <!-- Class Title -->
                 <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Class Title</label>
                    <input type="text" name="class_title" value="<?php echo htmlspecialchars($entry['class_title']); ?>" required
                           class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                </div>

                <!-- Short Description -->
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Short Description</label>
                    <input type="text" name="short_description" value="<?php echo htmlspecialchars($entry['short_description']); ?>" required
                           class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                </div>

                 <!-- Full Description -->
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Full Description</label>
                    <textarea name="full_description" rows="4" required
                              class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy resize-none"><?php echo htmlspecialchars($entry['full_description']); ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Instructor -->
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Instructor</label>
                        <input type="text" name="instructor" value="<?php echo htmlspecialchars($entry['instructor']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Duration</label>
                        <input type="text" name="duration" value="<?php echo htmlspecialchars($entry['duration']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Location -->
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Location</label>
                        <input type="text" name="location" value="<?php echo htmlspecialchars($entry['location']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>

                    <!-- Day of Week -->
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Day</label>
                        <select name="day_name" required
                                class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy appearance-none">
                            <option value="" disabled>Select Day</option>
                            <?php foreach ($days as $day): ?>
                                <option value="<?php echo htmlspecialchars($day); ?>" <?php echo ($entry['day_name'] === $day) ? 'selected' : ''; ?>><?php echo htmlspecialchars($day); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Time -->
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Time</label>
                        <input type="time" name="class_time" value="<?php echo htmlspecialchars($entry['class_time']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                </div>

                <!-- Image Upload -->
                <div>
                     <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Class Image</label>
                     <?php if (!empty($entry['class_image'])): ?>
                        <div class="mb-4 relative w-32 h-32 rounded-xl overflow-hidden border border-gray-200">
                            <img src="../<?php echo htmlspecialchars($entry['class_image']); ?>" class="w-full h-full object-cover">
                        </div>
                     <?php endif; ?>
                     <input type="file" name="class_image" accept="image/*"
                            class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:bg-navy/10 file:text-navy hover:file:bg-navy/20">
                     <p class="text-[10px] text-gray-400 mt-1 italic ml-1">Leave empty to keep current image. Recommended size: 800x600px | Max: 5MB</p>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="manage-timetable.php" class="px-8 py-4 rounded-2xl font-black uppercase italic tracking-widest text-navy bg-gray-100 hover:bg-gray-200 transition-all text-xs">Cancel</a>
                    <button type="submit" class="px-10 py-4 rounded-2xl font-black uppercase italic tracking-widest text-white bg-navy hover:bg-navy-light transition-all shadow-xl shadow-navy/20 active:scale-95 text-xs">Update Session</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
