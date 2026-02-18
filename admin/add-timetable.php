<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

$db = getDBConnection();
$errors = [];
$success = "";

// Days of the week
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_title = trim($_POST['class_title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $full_description = trim($_POST['full_description'] ?? '');
    $instructor = trim($_POST['instructor'] ?? '');
    $duration = trim($_POST['duration'] ?? '');
    $posted_sessions = $_POST['sessions'] ?? [];

    // Image Upload
    $class_image = '';
    if (isset($_FILES['class_image']) && $_FILES['class_image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['class_image']['name'];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $filesize = $_FILES['class_image']['size'];

        if (!in_array($filetype, $allowed)) {
            $errors[] = "Error: Please select a valid file format (JPG, JPEG, PNG, WEBP).";
        }
        if ($filesize > 5 * 1024 * 1024) {
             $errors[] = "Error: File size is larger than the allowed limit (5MB).";
        }

        if (empty($errors)) {
            $new_filename = uniqid() . "." . $filetype;
            $upload_path = "../uploads/timetable/" . $new_filename;
            
            if (!is_dir('../uploads/timetable')) {
                mkdir('../uploads/timetable', 0777, true);
            }
            
            if (move_uploaded_file($_FILES['class_image']['tmp_name'], $upload_path)) {
                $class_image = "uploads/timetable/" . $new_filename;
            } else {
                $errors[] = "Error: There was a problem uploading your file. Please try again.";
            }
        }
    } else {
        $errors[] = "Class image is required.";
    }

    // Validation
    if (empty($class_title) || empty($short_description) || empty($full_description) || empty($instructor) || empty($duration)) {
        $errors[] = "Class details are required.";
    }
    
    if (empty($posted_sessions)) {
        $errors[] = "At least one session (Location, Day, Time) is required.";
    }

    if (empty($errors)) {
        try {
            $db->beginTransaction();
            
            $stmt = $db->prepare("INSERT INTO timetable (class_title, short_description, full_description, instructor, location, day_name, class_time, duration, class_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            foreach ($posted_sessions as $session) {
                $loc = trim($session['location'] ?? '');
                $day = trim($session['day_name'] ?? '');
                $time = trim($session['class_time'] ?? '');
                
                if (empty($loc) || empty($day) || empty($time)) continue;
                
                $stmt->execute([$class_title, $short_description, $full_description, $instructor, $loc, $day, $time, $duration, $class_image]);
            }
            
            $db->commit();
            $success = "All class sessions added successfully!";
        } catch (PDOException $e) {
            $db->rollBack();
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="bg-navy p-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-2xl font-black uppercase italic tracking-widest">Add Physical Class</h1>
                <p class="text-blue-200 text-[10px] mt-1 uppercase font-bold tracking-[0.2em] opacity-80">Setup class details and multiple locations</p>
            </div>
            <i data-lucide="calendar" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/5 rotate-12"></i>
        </div>

        <div class="p-8">
            <?php if (!empty($errors)): ?>
                <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl">
                    <ul class="list-disc ml-5 text-[10px] font-black uppercase tracking-widest italic">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl flex items-center justify-between">
                    <p class="text-[10px] font-black uppercase tracking-widest italic"><?php echo htmlspecialchars($success); ?></p>
                    <a href="manage-timetable.php" class="bg-green-600 text-white px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-[0.2em] italic">View Timetable</a>
                </div>
            <?php endif; ?>

            <form action="add-timetable.php" method="POST" enctype="multipart/form-data" class="space-y-10">
                
                <!-- Section: Class Metadata -->
                <div class="space-y-6">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-1.5 h-6 bg-navy rounded-full"></div>
                        <h2 class="text-xs font-black uppercase italic tracking-widest text-navy">1. Class Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Class Title</label>
                            <input type="text" name="class_title" placeholder="e.g. Advanced Physics Workshop" required
                                   class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy placeholder:text-gray-300">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Short Description</label>
                            <input type="text" name="short_description" placeholder="Brief summary for preview cards" required
                                   class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy placeholder:text-gray-300">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Full Description</label>
                            <textarea name="full_description" rows="3" placeholder="Detailed description of the class..." required
                                      class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy placeholder:text-gray-300 resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Instructor</label>
                            <input type="text" name="instructor" placeholder="e.g. Dr. Jane Doe" required
                                   class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy placeholder:text-gray-300">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Duration</label>
                            <input type="text" name="duration" placeholder="e.g. 2 Hours" required
                                   class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy placeholder:text-gray-300">
                        </div>
                    </div>
                </div>

                <!-- Section: Class Image -->
                <div class="space-y-6">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-1.5 h-6 bg-navy rounded-full"></div>
                        <h2 class="text-xs font-black uppercase italic tracking-widest text-navy">2. Branding</h2>
                    </div>
                    <div>
                         <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Cover Image</label>
                         <div class="relative group">
                            <input type="file" name="class_image" id="class_image" accept="image/*" required class="hidden">
                            <label for="class_image" class="flex flex-col items-center justify-center w-full min-h-[160px] rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50/30 hover:bg-gray-50 hover:border-navy/20 cursor-pointer transition-all p-6 text-center">
                                <i data-lucide="image-plus" class="w-8 h-8 text-gray-300 mb-3 group-hover:text-navy transition-colors"></i>
                                <span id="fileName" class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic group-hover:text-navy">Click to upload class header image</span>
                                <span class="text-[9px] text-gray-300 mt-2 font-bold uppercase tracking-widest italic">800x600px recommended | Max 5MB</span>
                            </label>
                         </div>
                    </div>
                </div>

                <!-- Section: Sessions (Dynamic) -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-6 bg-navy rounded-full"></div>
                            <h2 class="text-xs font-black uppercase italic tracking-widest text-navy">3. Locations & Schedule</h2>
                        </div>
                        <button type="button" id="addSession" class="flex items-center gap-2 bg-navy/5 text-navy px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] italic hover:bg-navy hover:text-white transition-all">
                            <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                            Add Location
                        </button>
                    </div>

                    <div id="sessionsContainer" class="space-y-6">
                        <!-- Initial Session Row -->
                        <div class="session-row p-6 bg-gray-50/50 rounded-3xl border border-gray-100 relative group">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Location</label>
                                    <input type="text" name="sessions[0][location]" placeholder="e.g. Science Lab 101" required
                                           class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-white focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy placeholder:text-gray-200">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Day</label>
                                    <div class="relative">
                                        <select name="sessions[0][day_name]" required
                                                class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-white focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy appearance-none cursor-pointer">
                                            <option value="" disabled selected>Select Day</option>
                                            <?php foreach ($days as $day): ?>
                                                <option value="<?php echo htmlspecialchars($day); ?>"><?php echo htmlspecialchars($day); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300 pointer-events-none"></i>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Time</label>
                                    <input type="time" name="sessions[0][class_time]" required
                                           class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-white focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-navy text-white rounded-[2rem] font-black uppercase italic tracking-[0.3em] text-xs hover:bg-blue-600 transition-all shadow-2xl shadow-navy/20 active:scale-[0.98] flex items-center justify-center gap-3">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Confirm Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template for new sessions -->
<template id="sessionTemplate">
    <div class="session-row p-6 bg-gray-50/50 rounded-3xl border border-gray-100 relative group animate-in fade-in slide-in-from-top-4 duration-500">
        <button type="button" class="remove-session absolute -top-2 -right-2 w-7 h-7 bg-white text-red-500 border border-red-50 rounded-full flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-lg opacity-0 group-hover:opacity-100">
            <i data-lucide="x" class="w-3.5 h-3.5"></i>
        </button>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Location</label>
                <input type="text" name="sessions[{{index}}][location]" placeholder="e.g. Library Annex" required
                       class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-white focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy placeholder:text-gray-200">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Day</label>
                <div class="relative">
                    <select name="sessions[{{index}}][day_name]" required
                            class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-white focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy appearance-none cursor-pointer">
                        <option value="" disabled selected>Select Day</option>
                        <?php foreach ($days as $day): ?>
                            <option value="<?php echo htmlspecialchars($day); ?>"><?php echo htmlspecialchars($day); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300 pointer-events-none"></i>
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase text-gray-400 tracking-[0.15em] italic mb-2 ml-1">Time</label>
                <input type="time" name="sessions[{{index}}][class_time]" required
                       class="w-full px-4 py-3.5 rounded-2xl border border-gray-100 bg-white focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-bold text-navy">
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('sessionsContainer');
    const addButton = document.getElementById('addSession');
    const template = document.getElementById('sessionTemplate').innerHTML;
    let sessionCount = 1;

    // Handle Image Upload Label
    const fileInput = document.getElementById('class_image');
    const fileNameSpan = document.getElementById('fileName');
    
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            fileNameSpan.textContent = e.target.files[0].name;
            fileNameSpan.classList.add('text-navy');
        }
    });

    // Add Session
    addButton.addEventListener('click', () => {
        const index = sessionCount++;
        const newRow = template.replace(/{{index}}/g, index);
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newRow;
        const rowElement = tempDiv.firstElementChild;
        container.appendChild(rowElement);
        
        // Re-initialize Lucide icons for new elements
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Remove Session
    container.addEventListener('click', (e) => {
        if (e.target.closest('.remove-session')) {
            const row = e.target.closest('.session-row');
            row.classList.add('fade-out', 'translate-x-4');
            setTimeout(() => row.remove(), 300);
        }
    });
});
</script>

<style>
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
@keyframes slide-in-from-top { from { transform: translateY(-10px); } to { transform: translateY(0); } }
.animate-in { animation: fade-in 0.3s ease-out, slide-in-from-top 0.3s ease-out; }
.fade-out { opacity: 0; transition: opacity 0.3s ease-out, transform 0.3s ease-out; }
</style>

<?php include 'includes/footer.php'; ?>
