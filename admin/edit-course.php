<?php
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

$db = getDBConnection();
$errors = [];
$success = "";

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: manage-courses.php");
    exit;
}

// Fetch current data
$stmt = $db->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$id]);
$course = $stmt->fetch();

if (!$course) {
    header("Location: manage-courses.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_title = trim($_POST['course_title'] ?? '');
    $instructor = trim($_POST['instructor'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $duration = trim($_POST['duration'] ?? '');
    $price = trim($_POST['price'] ?? '');

    if (empty($course_title) || empty($instructor) || empty($description) || empty($duration) || empty($price)) {
        $errors[] = "All fields except files are required.";
    }

    if (!is_numeric($price)) {
        $errors[] = "Price must be a valid number.";
    }

    $image_path = $course['image'];
    $video_path = $course['video_zip'];

    // Update Image if provided
    if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] === 0) {
        $allowed_img = ['jpg', 'jpeg', 'png', 'webp'];
        $img_ext = strtolower(pathinfo($_FILES['course_image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($img_ext, $allowed_img) && $_FILES['course_image']['size'] <= 5 * 1024 * 1024) {
            if (file_exists("../" . $course['image'])) unlink("../" . $course['image']);
            $new_name = uniqid('img_', true) . '.' . $img_ext;
            $image_path = "uploads/course_images/" . $new_name;
            move_uploaded_file($_FILES['course_image']['tmp_name'], "../" . $image_path);
        } else {
            $errors[] = "Invalid image or size too large.";
        }
    }

    // Update ZIP if provided
    if (isset($_FILES['course_video']) && $_FILES['course_video']['error'] === 0) {
        $allowed_zip = ['zip'];
        $zip_ext = strtolower(pathinfo($_FILES['course_video']['name'], PATHINFO_EXTENSION));
        
        if (in_array($zip_ext, $allowed_zip) && $_FILES['course_video']['size'] <= 10 * 1024 * 1024 * 1024) {
            if (file_exists("../" . $course['video_zip'])) unlink("../" . $course['video_zip']);
            $new_name = uniqid('vid_', true) . '.' . $zip_ext;
            $video_path = "uploads/course_videos/" . $new_name;
            move_uploaded_file($_FILES['course_video']['tmp_name'], "../" . $video_path);
        } else {
            $errors[] = "Invalid ZIP or size too large.";
        }
    }

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("UPDATE courses SET course_title = ?, instructor = ?, description = ?, duration = ?, price = ?, image = ?, video_zip = ? WHERE id = ?");
            $stmt->execute([$course_title, $instructor, $description, $duration, $price, $image_path, $video_path, $id]);
            $success = "Course updated successfully!";
            // Update local object to show new data
            $course['course_title'] = $course_title;
            $course['instructor'] = $instructor;
            $course['description'] = $description;
            $course['duration'] = $duration;
            $course['price'] = $price;
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
                <h2 class="text-2xl font-black uppercase italic tracking-widest">Edit Course</h2>
                <p class="text-blue-200 text-xs mt-1 uppercase font-bold tracking-widest">Update existing curriculum details</p>
            </div>
            <i data-lucide="edit" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 rotate-12"></i>
        </div>

        <div class="p-8">
            <?php if (!empty($errors)): ?>
                <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl font-bold italic text-sm">
                    <?php foreach ($errors as $error) echo "<li>$error</li>"; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl font-bold italic text-sm flex justify-between items-center">
                    <span><?php echo $success; ?></span>
                    <a href="manage-courses.php" class="bg-green-600 text-white px-4 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest">Return to List</a>
                </div>
            <?php endif; ?>

            <form action="edit-course.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Fields same as add-course but with values -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Course Title</label>
                        <input type="text" name="course_title" value="<?php echo htmlspecialchars($course['course_title']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Instructor Name</label>
                        <input type="text" name="instructor" value="<?php echo htmlspecialchars($course['instructor']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Course Description</label>
                    <textarea name="description" rows="4" required
                              class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-medium text-gray-600"><?php echo htmlspecialchars($course['description']); ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Duration</label>
                        <input type="text" name="duration" value="<?php echo htmlspecialchars($course['duration']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Price (USD)</label>
                        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($course['price']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Replace Image (Optional)</label>
                        <div id="image-preview-container" class="relative h-48 rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center overflow-hidden transition-all group">
                            <button type="button" id="remove-image" class="absolute top-3 right-3 z-30 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition-all scale-0 group-hover:scale-100 hidden">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                            <img id="image-current" src="../<?php echo $course['image']; ?>" class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none transition-opacity">
                            <img id="image-preview" src="#" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden transition-all">
                            
                            <div id="image-placeholder" class="relative z-10 flex flex-col items-center">
                                <i data-lucide="upload" class="w-8 h-8 text-gray-400 mb-2"></i>
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest italic">New Thumbnail</span>
                            </div>
                            <input type="file" name="course_image" id="course_image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Replace ZIP (Optional)</label>
                        <div id="zip-preview-container" class="relative h-48 rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center overflow-hidden transition-all p-4 group">
                            <button type="button" id="remove-zip" class="absolute top-3 right-3 z-30 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition-all scale-0 group-hover:scale-100 hidden">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                            <div id="zip-placeholder" class="text-center">
                                <div class="text-navy/40 font-black italic text-[10px] absolute top-4 inset-x-0 uppercase tracking-widest px-4 truncate">Current: <?php echo basename($course['video_zip']); ?></div>
                                <i data-lucide="archive" class="w-8 h-8 text-gray-400 mb-2"></i>
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest italic">New ZIP File</span>
                            </div>
                            <div id="zip-info" class="hidden flex flex-col items-center text-center space-y-2">
                                <div class="w-10 h-10 bg-navy/5 rounded-2xl flex items-center justify-center">
                                    <i data-lucide="file-check" class="w-5 h-5 text-navy"></i>
                                </div>
                                <p id="zip-filename" class="text-[10px] font-black text-navy italic truncate max-w-full px-2"></p>
                                <span id="zip-filesize" class="text-[9px] font-black text-blue-400 uppercase tracking-widest italic"></span>
                            </div>
                            <input type="file" name="course_video" id="course_video" accept=".zip" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                        </div>
                    </div>
                </div>

                <script>
                    // Image Preview Logic
                    const imageInput = document.getElementById('course_image');
                    const imagePreview = document.getElementById('image-preview');
                    const imageCurrent = document.getElementById('image-current');
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
                                imageCurrent.classList.add('opacity-0');
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
                        imageCurrent.classList.remove('opacity-0');
                        imagePlaceholder.classList.remove('hidden');
                        imageContainer.classList.remove('border-navy/20');
                        imageContainer.classList.add('border-dashed');
                        removeImageBtn.classList.add('hidden');
                    });

                    // ZIP Preview Logic
                    const zipInput = document.getElementById('course_video');
                    const zipInfo = document.getElementById('zip-info');
                    const zipPlaceholder = document.getElementById('zip-placeholder');
                    const filenameDisplay = document.getElementById('zip-filename');
                    const filesizeDisplay = document.getElementById('zip-filesize');
                    const zipContainer = document.getElementById('zip-preview-container');
                    const removeZipBtn = document.getElementById('remove-zip');

                    zipInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            filenameDisplay.textContent = file.name;
                            filesizeDisplay.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                            zipInfo.classList.remove('hidden');
                            zipPlaceholder.classList.add('hidden');
                            zipContainer.classList.add('border-navy/20');
                            zipContainer.classList.remove('border-dashed');
                            removeZipBtn.classList.remove('hidden');
                        }
                    });

                    removeZipBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        zipInput.value = '';
                        zipInfo.classList.add('hidden');
                        zipPlaceholder.classList.remove('hidden');
                        zipContainer.classList.remove('border-navy/20');
                        zipContainer.classList.add('border-dashed');
                        removeZipBtn.classList.add('hidden');
                    });
                </script>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="manage-courses.php" class="px-8 py-4 rounded-2xl font-black uppercase italic tracking-widest text-navy bg-gray-100 hover:bg-gray-200 transition-all text-xs">Cancel</a>
                    <button type="submit" class="px-10 py-4 rounded-2xl font-black uppercase italic tracking-widest text-white bg-navy hover:bg-navy-light transition-all shadow-xl shadow-navy/20 active:scale-95 text-xs">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
