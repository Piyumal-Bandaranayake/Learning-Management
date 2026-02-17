<?php
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

$db = getDBConnection();
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_name = trim($_POST['class_name'] ?? '');
    $class_time = trim($_POST['class_time'] ?? '');
    $day_name = trim($_POST['day_name'] ?? '');
    $class_description = trim($_POST['class_description'] ?? '');

    if (empty($class_name) || empty($class_time) || empty($day_name)) {
        $errors[] = "All fields except description are required.";
    }

    // Image Upload Handling
    $image_path = "";
    if (isset($_FILES['class_image']) && $_FILES['class_image']['error'] === 0) {
        $allowed_img = ['jpg', 'jpeg', 'png', 'webp'];
        $img_name = $_FILES['class_image']['name'];
        $img_tmp = $_FILES['class_image']['tmp_name'];
        $img_size = $_FILES['class_image']['size'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

        if (!in_array($img_ext, $allowed_img)) {
            $errors[] = "Invalid image format. Allowed: " . implode(', ', $allowed_img);
        } elseif ($img_size > 5 * 1024 * 1024) {
            $errors[] = "Image size exceeds 5MB limit.";
        } else {
            $unique_name = uniqid('class_', true) . '.' . $img_ext;
            $image_path = "uploads/timetable/" . $unique_name;
            
            // Ensure directory exists
            if (!is_dir("../uploads/timetable")) {
                mkdir("../uploads/timetable", 0777, true);
            }

            if (!move_uploaded_file($img_tmp, "../" . $image_path)) {
                $errors[] = "Failed to upload image.";
            }
        }
    } else {
        $errors[] = "Class image is required.";
    }

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("INSERT INTO timetable (class_name, class_time, class_description, day_name, class_image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$class_name, $class_time, $class_description, $day_name, $image_path]);
            $success = "Timetable entry added successfully!";
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
                <h2 class="text-2xl font-black uppercase italic tracking-widest">Add Timetable Entry</h2>
                <p class="text-blue-200 text-xs mt-1 uppercase font-bold tracking-widest">Schedule a new class session</p>
            </div>
            <i data-lucide="calendar" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 rotate-12"></i>
        </div>

        <div class="p-8">
            <?php if (!empty($errors)): ?>
                <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl">
                    <ul class="list-disc ml-5 text-sm font-bold italic">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl flex items-center justify-between">
                    <p class="text-sm font-bold italic"><?php echo $success; ?></p>
                    <a href="manage-timetable.php" class="bg-green-600 text-white px-4 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest italic">View Timetable</a>
                </div>
            <?php endif; ?>

            <form action="add-timetable.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Class Name</label>
                        <input type="text" name="class_name" placeholder="e.g. Advanced Chemistry" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Class Time</label>
                        <input type="text" name="class_time" placeholder="e.g. 09:00 AM - 11:00 AM" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Class Description</label>
                    <textarea name="class_description" rows="4" placeholder="Briefly describe what students will learn..."
                              class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Select Day</label>
                    <select name="day_name" required
                            class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy appearance-none">
                        <option value="" disabled selected>Choose a day...</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>

                <div class="relative group">
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Class Image</label>
                    <div id="image-preview-container" class="relative h-48 rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center group-hover:border-navy/30 transition-all overflow-hidden">
                        <button type="button" id="remove-image" class="absolute top-3 right-3 z-30 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition-all scale-0 group-hover:scale-100 hidden">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                        <div id="image-placeholder" class="flex flex-col items-center text-center">
                            <i data-lucide="image" class="w-12 h-12 text-gray-300 mb-2"></i>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Choose Image</span>
                        </div>
                        <img id="image-preview" src="#" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        <input type="file" name="class_image" id="class_image" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer z-10">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <button type="reset" class="px-8 py-4 rounded-2xl font-black uppercase italic tracking-widest text-navy bg-gray-100 hover:bg-gray-200 transition-all text-xs">Reset Form</button>
                    <button type="submit" class="px-10 py-4 rounded-2xl font-black uppercase italic tracking-widest text-white bg-navy hover:bg-navy-light transition-all shadow-xl shadow-navy/20 active:scale-95 text-xs">Add to Timetable</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const imageInput = document.getElementById('class_image');
    const imagePreview = document.getElementById('image-preview');
    const imagePlaceholder = document.getElementById('image-placeholder');
    const imageContainer = document.getElementById('image-preview-container');
    const removeImageBtn = document.getElementById('remove-image');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                imagePlaceholder.classList.add('hidden');
                imageContainer.classList.add('border-navy/20');
                imageContainer.classList.remove('border-dashed');
                removeImageBtn.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    removeImageBtn.addEventListener('click', function(e) {
        e.preventDefault();
        imageInput.value = '';
        imagePreview.classList.add('hidden');
        imagePlaceholder.classList.remove('hidden');
        imageContainer.classList.remove('border-navy/20');
        imageContainer.classList.add('border-dashed');
        removeImageBtn.classList.add('hidden');
    });
</script>

<?php include 'includes/footer.php'; ?>
