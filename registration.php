<?php 
require_once 'includes/auth_check.php';
require_login();
require_once 'config/database.php';

$db = getDBConnection();
$course_id = $_GET['id'] ?? 0;

// Fetch course details
$stmt = $db->prepare("SELECT course_title FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

if (!$course) {
    header("Location: courses.php");
    exit;
}

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
?>

<div class="max-w-4xl mx-auto">
    <!-- Breadcrumbs -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="courses.php" class="text-sm text-gray-400 hover:text-navy inline-flex items-center">
                    <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
                    Back to Courses
                </a>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-3xl shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <!-- Form Header -->
        <div class="bg-navy p-8 text-white relative">
            <h1 class="text-2xl font-bold mb-2">Course Registration</h1>
            <p class="text-blue-100 opacity-80">Complete the form below to enroll in <span class="text-white font-bold italic">"<?php echo htmlspecialchars($course['course_title']); ?>"</span></p>
            <div class="absolute top-8 right-8 hidden md:block">
                <i data-lucide="file-edit" class="w-16 h-16 opacity-10"></i>
            </div>
        </div>

        <!-- Form Body -->
        <form action="process-registration.php" method="POST" enctype="multipart/form-data" class="p-8">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Full Name -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-navy uppercase tracking-wider">Full Name</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="text" name="fullname" value="<?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?>" readonly class="w-full pl-12 pr-4 py-3 bg-gray-50 rounded-xl border-2 border-gray-100 text-gray-500 cursor-not-allowed focus:outline-none">
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-navy uppercase tracking-wider">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" readonly class="w-full pl-12 pr-4 py-3 bg-gray-50 rounded-xl border-2 border-gray-100 text-gray-500 cursor-not-allowed focus:outline-none">
                    </div>
                </div>

                <!-- Phone -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-navy uppercase tracking-wider">Phone Number</label>
                    <div class="relative">
                        <i data-lucide="phone" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="tel" name="phone" value="<?php echo htmlspecialchars($_SESSION['whatsapp'] ?? ''); ?>" placeholder="+1 (555) 000-0000" required class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-100 focus:border-navy focus:outline-none focus:ring-4 focus:ring-navy/5 transition-all">
                    </div>
                </div>
            </div>

            <!-- Bank Details Section -->
            <div class="mb-10 p-8 bg-navy/5 rounded-[2rem] border border-navy/10 relative overflow-hidden">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-navy text-white rounded-xl flex items-center justify-center shadow-lg shadow-navy/20">
                        <i data-lucide="landmark" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-navy italic">Bank Transfer Details</h3>
                        <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest">Complete your payment to the account below</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 relative z-10">
                    <div class="space-y-1">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic ml-1">Bank Name</span>
                        <div class="bg-white/80 backdrop-blur-sm px-4 py-3 rounded-xl border border-white font-black text-navy text-xs italic">Commercial Bank</div>
                    </div>
                    <div class="space-y-1">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic ml-1">Account Holder</span>
                        <div class="bg-white/80 backdrop-blur-sm px-4 py-3 rounded-xl border border-white font-black text-navy text-xs italic">Guideway Learning Network</div>
                    </div>
                    <div class="space-y-1">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic ml-1">Account Number</span>
                        <div class="bg-white/80 backdrop-blur-sm px-4 py-3 rounded-xl border border-white font-black text-blue-600 text-sm tracking-widest italic">8002 1234 5678 9012</div>
                    </div>
                    <div class="space-y-1">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic ml-1">Branch</span>
                        <div class="bg-white/80 backdrop-blur-sm px-4 py-3 rounded-xl border border-white font-black text-navy text-xs italic">Colombo Main Branch</div>
                    </div>
                </div>

                <!-- Abstract background decoration -->
                <i data-lucide="shield-check" class="absolute -right-6 -bottom-6 w-32 h-32 text-navy/5 -rotate-12"></i>
            </div>

            <!-- Payment Proof Section -->
            <div class="p-6 bg-blue-50/50 rounded-2xl border-2 border-dashed border-blue-200 mb-8">
                <div class="flex items-start gap-4">
                    <div class="bg-white p-3 rounded-xl shadow-sm text-navy">
                        <i data-lucide="upload-cloud"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-navy mb-1">Upload Payment Receipt</h3>
                        <p class="text-xs text-gray-500 mb-4">Please upload a clear image or PDF of your transaction receipt. Max file size: 5MB.</p>
                        
                        <label id="receipt-upload-container" class="group cursor-pointer block relative transition-all">
                            <input type="file" name="receipt" id="receipt-upload" required accept="image/*,application/pdf" class="hidden">
                            
                            <button type="button" id="remove-receipt" class="absolute top-3 right-3 z-30 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition-all scale-0 group-hover:scale-100 hidden">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>

                            <!-- Placeholder State -->
                            <div id="receipt-placeholder" class="bg-white border-2 border-dashed border-gray-200 group-hover:border-navy group-hover:bg-navy/5 transition-all rounded-xl p-8 text-center">
                                <span class="text-sm font-semibold text-gray-400 group-hover:text-navy">Click to browse or drag and drop file</span>
                                <p class="text-[10px] text-gray-300 mt-1">Supported: JPG, PNG, PDF</p>
                            </div>

                            <!-- Image Preview State -->
                            <div id="receipt-image-preview" class="hidden relative h-48 rounded-xl overflow-hidden border-2 border-navy/10 shadow-lg">
                                <img src="#" alt="Receipt Preview" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-white text-xs font-black uppercase tracking-widest italic bg-navy/80 px-4 py-2 rounded-full">Change Receipt</span>
                                </div>
                            </div>

                            <!-- PDF/File Info State -->
                            <div id="receipt-file-info" class="hidden bg-white border-2 border-navy/10 rounded-xl p-6 flex flex-col items-center text-center space-y-3 shadow-lg">
                                <div class="w-14 h-14 bg-navy/5 rounded-2xl flex items-center justify-center">
                                    <i data-lucide="file-text" id="file-icon" class="w-7 h-7 text-navy"></i>
                                </div>
                                <div class="space-y-1">
                                    <p id="receipt-filename" class="text-xs font-black text-navy italic truncate max-w-[250px] px-2"></p>
                                    <span id="receipt-filesize" class="text-[10px] font-black text-blue-400 uppercase tracking-widest italic"></span>
                                </div>
                                <span class="text-[9px] font-black text-navy/40 uppercase tracking-[0.2em] italic">Click to Replace File</span>
                            </div>
                        </label>

                        <script>
                            const receiptInput = document.getElementById('receipt-upload');
                            const imagePreview = document.getElementById('receipt-image-preview');
                            const fileInfo = document.getElementById('receipt-file-info');
                            const placeholder = document.getElementById('receipt-placeholder');
                            const filenameDisplay = document.getElementById('zip-filename'); // Note: ID in HTML was receipt-filename, fixing below
                            const receiptFilename = document.getElementById('receipt-filename');
                            const receiptFilesize = document.getElementById('receipt-filesize');
                            const fileIcon = document.getElementById('file-icon');
                            const removeBtn = document.getElementById('remove-receipt');

                            receiptInput.addEventListener('change', function(e) {
                                const file = e.target.files[0];
                                if (file) {
                                    placeholder.classList.add('hidden');
                                    removeBtn.classList.remove('hidden');

                                    if (file.type.startsWith('image/')) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            imagePreview.querySelector('img').src = e.target.result;
                                            imagePreview.classList.remove('hidden');
                                            fileInfo.classList.add('hidden');
                                        }
                                        reader.readAsDataURL(file);
                                    } else {
                                        receiptFilename.textContent = file.name;
                                        receiptFilesize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                                        
                                        if (file.type === 'application/pdf') {
                                            fileIcon.setAttribute('data-lucide', 'file-text');
                                        } else {
                                            fileIcon.setAttribute('data-lucide', 'file');
                                        }
                                        lucide.createIcons();
                                        
                                        fileInfo.classList.remove('hidden');
                                        imagePreview.classList.add('hidden');
                                    }
                                }
                            });

                            removeBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                receiptInput.value = '';
                                imagePreview.classList.add('hidden');
                                fileInfo.classList.add('hidden');
                                placeholder.classList.remove('hidden');
                                removeBtn.classList.add('hidden');
                            });
                        </script>
                    </div>
                </div>
            </div>

            <!-- Terms & Submit -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="terms" value="1" required class="w-5 h-5 rounded text-navy focus:ring-navy cursor-pointer">
                    <span class="text-sm text-gray-500">I agree to the <a href="#" class="text-navy font-bold underline">Terms & Conditions</a></span>
                </label>
                
                <button type="submit" class="bg-navy text-white px-10 py-4 rounded-2xl font-bold hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-95 flex items-center justify-center gap-2">
                    Submit Registration
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

