<?php
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

$db = getDBConnection();
$errors = [];
$success = "";

// Check current banner count
$stmt = $db->query("SELECT COUNT(*) FROM banners");
$banner_count = $stmt->fetchColumn();
$limit_reached = $banner_count >= 3;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$limit_reached) {
    $display_order = isset($_POST['display_order']) ? (int)$_POST['display_order'] : 1;

    // Image Upload Handling
    $image_path = "";
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === 0) {
        $allowed_img = ['jpg', 'jpeg', 'png', 'webp'];
        $img_name = $_FILES['banner_image']['name'];
        $img_tmp = $_FILES['banner_image']['tmp_name'];
        $img_size = $_FILES['banner_image']['size'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

        if (!in_array($img_ext, $allowed_img)) {
            $errors[] = "Invalid image format. Allowed: " . implode(', ', $allowed_img);
        } elseif ($img_size > 10 * 1024 * 1024) {
            $errors[] = "Image size exceeds 10MB limit.";
        } else {
            $unique_name = uniqid('banner_', true) . '.' . $img_ext;
            $image_path = "uploads/banners/" . $unique_name;
            if (!move_uploaded_file($img_tmp, "../" . $image_path)) {
                $errors[] = "Failed to upload image.";
            }
        }
    } else {
        $errors[] = "Banner image is required.";
    }

    // Insert into DB
    if (empty($errors)) {
        try {
            $stmt = $db->prepare("INSERT INTO banners (image, display_order) VALUES (?, ?)");
            $stmt->execute([$image_path, $display_order]);
            $success = "Banner added successfully!";
            $banner_count++; // Update count for UI
            $limit_reached = $banner_count >= 3;
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $limit_reached) {
    $errors[] = "Maximum limit of 3 banners reached. Please delete an existing banner first.";
}

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="bg-navy p-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl font-black uppercase tracking-widest">Add New Banner</h2>
                <p class="text-blue-200 text-xs mt-1 uppercase font-bold tracking-widest">Upload a new image for the homepage slider</p>
            </div>
            <i data-lucide="image" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 rotate-12"></i>
        </div>

        <div class="p-8">
            <?php if (!empty($errors)): ?>
                <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl">
                    <ul class="list-disc ml-5 text-sm font-bold">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl flex items-center justify-between">
                    <p class="text-sm font-bold"><?php echo $success; ?></p>
                    <a href="manage-banners.php" class="bg-green-600 text-white px-4 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest">Manage Banners</a>
                </div>
            <?php endif; ?>

            <?php if ($limit_reached): ?>
                <div class="mb-8 p-6 bg-amber-50 border-l-4 border-amber-500 rounded-2xl flex items-start gap-4">
                    <div class="bg-amber-100 p-2 rounded-xl text-amber-600">
                        <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-amber-900 uppercase text-sm mb-1 tracking-tight">Banner Limit Reached</h4>
                        <p class="text-amber-700 text-xs font-semibold leading-relaxed">You have reached the maximum of 3 banners. You must delete an existing banner from the <a href="manage-banners.php" class="underline font-black">Gallery</a> before you can upload a new one.</p>
                    </div>
                </div>
            <?php endif; ?>

            <form action="add-banner.php" method="POST" enctype="multipart/form-data" class="space-y-6 <?php echo $limit_reached ? 'opacity-50 pointer-events-none' : ''; ?>">
                <div class="mb-6">
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Display Order</label>
                    <input type="number" name="display_order" value="1"
                            class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                </div>

                <div class="relative group">
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Banner Image (PNG/JPG/WEBP)</label>
                    <div id="image-preview-container" class="relative h-64 rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center group-hover:border-navy/30 transition-all overflow-hidden">
                        <button type="button" id="remove-image" class="absolute top-3 right-3 z-30 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition-all scale-0 group-hover:scale-100 hidden">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                        <div id="image-placeholder" class="flex flex-col items-center text-center">
                            <i data-lucide="image" class="w-16 h-16 text-gray-300 mb-2"></i>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Choose Banner Image</span>
                        </div>
                        <img id="image-preview" src="#" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        <input type="file" name="banner_image" id="banner_image" accept="image/*" <?php echo $limit_reached ? 'disabled' : 'required'; ?> class="absolute inset-0 opacity-0 cursor-pointer z-10">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <button type="reset" class="px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-navy bg-gray-100 hover:bg-gray-200 transition-all text-xs" <?php echo $limit_reached ? 'disabled' : ''; ?>>Reset Form</button>
                    <button type="submit" class="px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-white bg-navy hover:bg-navy-light transition-all shadow-xl shadow-navy/20 active:scale-95 text-xs" <?php echo $limit_reached ? 'disabled' : ''; ?>>Upload Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Image Preview Logic
    const imageInput = document.getElementById('banner_image');
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
