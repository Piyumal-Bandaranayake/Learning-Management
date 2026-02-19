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
    $video_path_string = $course['video_zip'];

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

    // Process ZIPs (New Uploads + Deletions)
    $existing_videos = json_decode($course['video_zip'], true) ?: ($course['video_zip'] ? [$course['video_zip']] : []);
    $keep_videos = [];
    
    // Check which existing ones to keep
    $removed_zips = isset($_POST['removed_zips']) ? json_decode($_POST['removed_zips'], true) : [];
    foreach ($existing_videos as $v) {
        if (!in_array($v, $removed_zips)) {
            $keep_videos[] = $v;
        } else {
            // Physically delete the removed file
            if (file_exists("../" . $v)) unlink("../" . $v);
        }
    }

    // Handle New Uploads
    if (isset($_FILES['course_video']) && is_array($_FILES['course_video']['name']) && !empty($_FILES['course_video']['name'][0])) {
        $file_count = count($_FILES['course_video']['name']);
        for ($i = 0; $i < $file_count; $i++) {
            if ($_FILES['course_video']['error'][$i] === 0) {
                $allowed_zip = ['zip'];
                $video_name = $_FILES['course_video']['name'][$i];
                $video_tmp = $_FILES['course_video']['tmp_name'][$i];
                $video_size = $_FILES['course_video']['size'][$i];
                $video_ext = strtolower(pathinfo($video_name, PATHINFO_EXTENSION));

                if (in_array($video_ext, $allowed_zip) && $video_size <= 10 * 1024 * 1024 * 1024) {
                    $unique_name = uniqid('vid_', true) . '_' . $i . '.' . $video_ext;
                    $video_path = "uploads/course_videos/" . $unique_name;
                    if (move_uploaded_file($video_tmp, "../" . $video_path)) {
                        $keep_videos[] = $video_path;
                    }
                } else {
                    $errors[] = "Invalid ZIP file '$video_name' or size too large.";
                }
            }
        }
    }
    
    $video_path_string = json_encode(array_values($keep_videos));

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("UPDATE courses SET course_title = ?, instructor = ?, description = ?, duration = ?, price = ?, image = ?, video_zip = ? WHERE id = ?");
            $stmt->execute([$course_title, $instructor, $description, $duration, $price, $image_path, $video_path_string, $id]);
            $success = "Course updated successfully!";
            // Update local object to show new data
            $course['course_title'] = $course_title;
            $course['instructor'] = $instructor;
            $course['description'] = $description;
            $course['duration'] = $duration;
            $course['price'] = $price;
            $course['image'] = $image_path;
            $course['video_zip'] = $video_path_string;
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';

// Prepare existing videos for display
$existing_videos = json_decode($course['video_zip'], true);
if (!$existing_videos) {
    $existing_videos = $course['video_zip'] ? [$course['video_zip']] : [];
}
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="bg-navy p-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl font-black uppercase tracking-widest">Edit Course</h2>
                <p class="text-blue-200 text-xs mt-1 uppercase font-bold tracking-widest">Update existing curriculum details</p>
            </div>
            <i data-lucide="edit" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 rotate-12"></i>
        </div>

        <div class="p-8">
            <?php if (!empty($errors)): ?>
                <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl font-bold text-sm">
                    <ul class="list-disc ml-5">
                        <?php foreach ($errors as $error) echo "<li>$error</li>"; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl font-bold text-sm flex justify-between items-center">
                    <span><?php echo $success; ?></span>
                    <a href="manage-courses.php" class="bg-green-600 text-white px-4 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest">Return to List</a>
                </div>
            <?php endif; ?>

            <form action="edit-course.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Fields same as add-course but with values -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Course Title</label>
                        <input type="text" name="course_title" value="<?php echo htmlspecialchars($course['course_title']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Instructor Name</label>
                        <input type="text" name="instructor" value="<?php echo htmlspecialchars($course['instructor']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Course Description</label>
                    <textarea name="description" rows="4" required
                              class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-medium text-gray-600"><?php echo htmlspecialchars($course['description']); ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Duration</label>
                        <input type="text" name="duration" value="<?php echo htmlspecialchars($course['duration']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Price (LKR)</label>
                        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($course['price']); ?>" required
                               class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Replace Image (Optional)</label>
                        <div id="image-preview-container" class="relative h-48 rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center overflow-hidden transition-all group">
                            <button type="button" id="remove-image" class="absolute top-3 right-3 z-30 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition-all scale-0 group-hover:scale-100 hidden">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                            <img id="image-current" src="../<?php echo $course['image']; ?>" class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none transition-opacity">
                            <img id="image-preview" src="#" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden transition-all">
                            
                            <div id="image-placeholder" class="relative z-10 flex flex-col items-center">
                                <i data-lucide="upload" class="w-8 h-8 text-gray-400 mb-2"></i>
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">New Thumbnail</span>
                            </div>
                            <input type="file" name="course_image" id="course_image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Replace ZIP(s) (Optional)</label>
                        <div id="zip-preview-container" class="relative min-h-[12rem] rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center overflow-hidden transition-all p-4 group">
                            <button type="button" id="remove-zip" class="absolute top-3 right-3 z-30 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition-all scale-0 group-hover:scale-100 hidden">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                            <div id="zip-placeholder" class="text-center py-4">
                                <div class="text-navy/40 font-black text-[10px] absolute top-4 inset-x-0 uppercase tracking-widest px-4">
                                    Current: <?php echo count($existing_videos); ?> file(s)
                                </div>
                                <i data-lucide="archive" class="w-8 h-8 text-gray-400 mb-2"></i>
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Upload New ZIP(s)</span>
                            </div>
                            <div id="zip-info-list" class="hidden w-full flex flex-col gap-2">
                                <!-- Multiple ZIPs will be listed here -->
                            </div>
                            
                            <!-- Removed Files Tracking -->
                            <input type="hidden" name="removed_zips" id="removed_zips" value="[]">

                            <!-- Current Files List -->
                            <div id="current-zips" class="w-full space-y-1 mt-2 opacity-50 group-hover:opacity-100 transition-opacity">
                                <?php foreach ($existing_videos as $index => $v): ?>
                                    <div class="flex items-center gap-2 px-3 py-1 bg-gray-100/50 rounded-lg border border-gray-200 existing-zip-item" data-path="<?php echo htmlspecialchars($v); ?>">
                                        <i data-lucide="file-text" class="w-3 h-3 text-gray-400"></i>
                                        <span class="text-[9px] font-medium text-gray-500 truncate"><?php echo basename($v); ?></span>
                                        <button type="button" class="ml-auto p-1 text-red-400 hover:text-red-600 transition-colors remove-existing-btn" title="Remove this file">
                                            <i data-lucide="trash-2" class="w-3 h-3"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <input type="file" name="course_video[]" id="course_video" accept=".zip" multiple class="absolute inset-0 opacity-0 cursor-pointer z-20">
                        </div>
                    </div>
                </div>

                <script>
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
                    const zipInfoList = document.getElementById('zip-info-list');
                    const currentZips = document.getElementById('current-zips');
                    const zipPlaceholder = document.getElementById('zip-placeholder');
                    const zipContainer = document.getElementById('zip-preview-container');
                    const removeZipBtn = document.getElementById('remove-zip');

                    zipInput.addEventListener('change', function(e) {
                        const files = e.target.files;
                        if (files.length > 0) {
                            zipInfoList.innerHTML = '';
                            for (let i = 0; i < files.length; i++) {
                                const file = files[i];
                                const fileDiv = document.createElement('div');
                                fileDiv.className = 'flex items-center gap-2 p-2 bg-white rounded-xl border border-gray-100 shadow-sm';
                                fileDiv.innerHTML = `
                                    <div class="w-8 h-8 bg-navy/5 rounded-lg flex items-center justify-center shrink-0">
                                        <i data-lucide="file-check" class="w-4 h-4 text-navy"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[9px] font-black text-navy truncate">${file.name}</p>
                                        <span class="text-[8px] font-black text-blue-400 uppercase tracking-widest">${(file.size / (1024 * 1024)).toFixed(2)} MB</span>
                                    </div>
                                `;
                                zipInfoList.appendChild(fileDiv);
                            }
                            
                            zipInfoList.classList.remove('hidden');
                            currentZips.classList.add('hidden');
                            zipPlaceholder.classList.add('hidden');
                            zipContainer.classList.add('border-navy/20');
                            zipContainer.classList.remove('border-dashed', 'items-center', 'justify-center');
                            zipContainer.classList.add('items-stretch', 'justify-start');
                            removeZipBtn.classList.remove('hidden');
                            
                            if (window.lucide) window.lucide.createIcons();
                        }
                    });

                    removeZipBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        zipInput.value = '';
                        zipInfoList.innerHTML = '';
                        zipInfoList.classList.add('hidden');
                        currentZips.classList.remove('hidden');
                        zipPlaceholder.classList.remove('hidden');
                        zipContainer.classList.remove('border-navy/20');
                        zipContainer.classList.add('border-dashed');
                        removeZipBtn.classList.add('hidden');
                    });

                    // Remove Existing Zip Logic
                    let removedZips = [];
                    const removedZipsInput = document.getElementById('removed_zips');
                    
                    document.querySelectorAll('.remove-existing-btn').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.stopPropagation(); // Don't trigger file input
                            const item = this.closest('.existing-zip-item');
                            const path = item.getAttribute('data-path');
                            
                            if (confirm('Are you sure you want to remove this file?')) {
                                removedZips.push(path);
                                removedZipsInput.value = JSON.stringify(removedZips);
                                item.remove();
                                
                                // Update file count display if needed
                                const countLabel = zipPlaceholder.querySelector('div');
                                if (countLabel) {
                                    const currentCount = document.querySelectorAll('.existing-zip-item').length;
                                    countLabel.textContent = `Current: ${currentCount} file(s)`;
                                }
                            }
                        });
                    });
                </script>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="manage-courses.php" class="px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-navy bg-gray-100 hover:bg-gray-200 transition-all text-xs">Cancel</a>
                    <button type="submit" class="px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-white bg-navy hover:bg-navy-light transition-all shadow-xl shadow-navy/20 active:scale-95 text-xs">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
