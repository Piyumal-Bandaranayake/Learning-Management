<?php
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

$db = getDBConnection();
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_title = trim($_POST['course_title'] ?? '');
    $instructor = trim($_POST['instructor'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $duration = trim($_POST['duration'] ?? '');
    $price = trim($_POST['price'] ?? '');

    // Basic Validation
    if (empty($course_title) || empty($instructor) || empty($description) || empty($duration) || empty($price)) {
        $errors[] = "All fields are required.";
    }

    if (!is_numeric($price)) {
        $errors[] = "Price must be a valid number.";
    }

    // Image Upload Handling
    $image_path = "";
    if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] === 0) {
        $allowed_img = ['jpg', 'jpeg', 'png', 'webp'];
        $img_name = $_FILES['course_image']['name'];
        $img_tmp = $_FILES['course_image']['tmp_name'];
        $img_size = $_FILES['course_image']['size'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

        if (!in_array($img_ext, $allowed_img)) {
            $errors[] = "Invalid image format. Allowed: " . implode(', ', $allowed_img);
        } elseif ($img_size > 5 * 1024 * 1024) {
            $errors[] = "Image size exceeds 5MB limit.";
        } else {
            $unique_name = uniqid('img_', true) . '.' . $img_ext;
            $image_path = "uploads/course_images/" . $unique_name;
            if (!move_uploaded_file($img_tmp, "../" . $image_path)) {
                $errors[] = "Failed to upload image.";
            }
        }
    } else {
        $errors[] = "Course image is required.";
    }

    // Video ZIP Upload Handling
    $video_path = "";
    if (isset($_FILES['course_video']) && $_FILES['course_video']['error'] === 0) {
        $allowed_video = ['zip'];
        $video_name = $_FILES['course_video']['name'];
        $video_tmp = $_FILES['course_video']['tmp_name'];
        $video_size = $_FILES['course_video']['size'];
        $video_ext = strtolower(pathinfo($video_name, PATHINFO_EXTENSION));

        if (!in_array($video_ext, $allowed_video)) {
            $errors[] = "Invalid video format. Only .zip allowed.";
        } elseif ($video_size > 10 * 1024 * 1024 * 1024) { // 10GB
            $errors[] = "Video ZIP exceeds 10GB limit.";
        } else {
            $unique_name = uniqid('vid_', true) . '.' . $video_ext;
            $video_path = "uploads/course_videos/" . $unique_name;
            if (!move_uploaded_file($video_tmp, "../" . $video_path)) {
                $errors[] = "Failed to upload video ZIP.";
            }
        }
    } else {
        $errors[] = "Course video ZIP is required.";
    }

    // Insert into DB
    if (empty($errors)) {
        try {
            $stmt = $db->prepare("INSERT INTO courses (course_title, instructor, description, duration, price, image, video_zip) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$course_title, $instructor, $description, $duration, $price, $image_path, $video_path]);
            $success = "Course created successfully!";
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
                <h2 class="text-2xl font-black uppercase italic tracking-widest">Create New Course</h2>
                <p class="text-blue-200 text-xs mt-1 uppercase font-bold tracking-widest">Add a new curriculum to the platform</p>
            </div>
            <i data-lucide="plus-circle" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 rotate-12"></i>
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
                    <a href="manage-courses.php" class="bg-green-600 text-white px-4 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest italic">View Catalog</a>
                </div>
            <?php endif; ?>

            <form action="add-course.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Course Title</label>
                        <input type="text" name="course_title" placeholder="e.g. Advanced PHP Mastery" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Instructor Name</label>
                        <input type="text" name="instructor" placeholder="e.g. John Doe" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Course Description</label>
                    <textarea name="description" rows="4" placeholder="Brief overview of the course curriculum..." required
                              class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-medium text-gray-600"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Duration</label>
                        <input type="text" name="duration" placeholder="e.g. 12 Weeks (48 Hours)" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Price (USD)</label>
                        <input type="number" step="0.01" name="price" placeholder="e.g. 99.99" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="relative group">
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Course Thumbnail (PNG/JPG)</label>
                        <div id="image-preview-container" class="relative h-48 rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center group-hover:border-navy/30 transition-all overflow-hidden">
                            <button type="button" id="remove-image" class="absolute top-3 right-3 z-30 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition-all scale-0 group-hover:scale-100 hidden">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                            <div id="image-placeholder" class="flex flex-col items-center text-center">
                                <i data-lucide="image" class="w-12 h-12 text-gray-300 mb-2"></i>
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Choose Image</span>
                            </div>
                            <img id="image-preview" src="#" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden">
                            <input type="file" name="course_image" id="course_image" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer z-10">
                        </div>
                    </div>
                    <div class="relative group">
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Video Material (ZIP)</label>
                        <div id="zip-preview-container" class="relative h-48 rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center group-hover:border-navy/30 transition-all overflow-hidden p-4">
                            <button type="button" id="remove-zip" class="absolute top-3 right-3 z-30 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition-all scale-0 group-hover:scale-100 hidden">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                            <div id="zip-placeholder" class="flex flex-col items-center text-center">
                                <i data-lucide="file-archive" class="w-12 h-12 text-gray-300 mb-2"></i>
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Choose ZIP File</span>
                            </div>
                            <div id="zip-info" class="hidden flex flex-col items-center text-center space-y-2">
                                <div class="w-12 h-12 bg-navy/5 rounded-2xl flex items-center justify-center">
                                    <i data-lucide="file-check" class="w-6 h-6 text-navy"></i>
                                </div>
                                <p id="zip-filename" class="text-xs font-black text-navy italic truncate max-w-full px-2"></p>
                                <span id="zip-filesize" class="text-[10px] font-black text-blue-400 uppercase tracking-widest italic"></span>
                            </div>
                            <input type="file" name="course_video" id="course_video" accept=".zip" required class="absolute inset-0 opacity-0 cursor-pointer z-10">
                        </div>
                    </div>
                </div>

                <script>
                    // Image Preview Logic
                    const imageInput = document.getElementById('course_image');
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
                    <button type="reset" class="px-8 py-4 rounded-2xl font-black uppercase italic tracking-widest text-navy bg-gray-100 hover:bg-gray-200 transition-all text-xs">Reset Form</button>
                    <button type="submit" class="px-10 py-4 rounded-2xl font-black uppercase italic tracking-widest text-white bg-navy hover:bg-navy-light transition-all shadow-xl shadow-navy/20 active:scale-95 text-xs">Publish Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
