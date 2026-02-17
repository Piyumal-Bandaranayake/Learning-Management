<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="max-w-4xl mx-auto">
    <!-- Breadcrumbs -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="classes.php" class="text-sm text-gray-400 hover:text-navy inline-flex items-center">
                    <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
                    Back to Classes
                </a>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-3xl shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <!-- Form Header -->
        <div class="bg-navy p-8 text-white relative">
            <h1 class="text-2xl font-bold mb-2">Class Registration</h1>
            <p class="text-blue-100 opacity-80">Complete the form below to enroll in <span class="text-white font-bold italic">"Advanced PHP Mastery"</span></p>
            <div class="absolute top-8 right-8 hidden md:block">
                <i data-lucide="file-edit" class="w-16 h-16 opacity-10"></i>
            </div>
        </div>

        <!-- Form Body -->
        <form action="process-registration.php" method="POST" enctype="multipart/form-data" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Full Name -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-navy uppercase tracking-wider">Full Name</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="text" name="fullname" value="John Doe" readonly class="w-full pl-12 pr-4 py-3 bg-gray-50 rounded-xl border-2 border-gray-100 text-gray-500 cursor-not-allowed focus:outline-none">
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-navy uppercase tracking-wider">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="email" name="email" value="john.doe@example.com" readonly class="w-full pl-12 pr-4 py-3 bg-gray-50 rounded-xl border-2 border-gray-100 text-gray-500 cursor-not-allowed focus:outline-none">
                    </div>
                </div>

                <!-- Phone -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-navy uppercase tracking-wider">Phone Number</label>
                    <div class="relative">
                        <i data-lucide="phone" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="tel" name="phone" placeholder="+1 (555) 000-0000" class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-100 focus:border-navy focus:outline-none focus:ring-4 focus:ring-navy/5 transition-all">
                    </div>
                </div>

                <!-- Registration ID (Auto-generated) -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-navy uppercase tracking-wider">Reference Code</label>
                    <div class="relative">
                        <i data-lucide="hash" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="text" name="ref" value="REF-<?php echo strtoupper(bin2hex(random_bytes(3))); ?>" readonly class="w-full pl-12 pr-4 py-3 bg-gray-50 rounded-xl border-2 border-gray-100 text-gray-500 font-mono focus:outline-none">
                    </div>
                </div>
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
                        
                        <label class="group cursor-pointer block">
                            <input type="file" name="receipt" class="hidden">
                            <div class="bg-white border-2 border-dashed border-gray-200 group-hover:border-navy group-hover:bg-navy/5 transition-all rounded-xl p-8 text-center">
                                <span class="text-sm font-semibold text-gray-400 group-hover:text-navy">Click to browse or drag and drop file</span>
                                <p class="text-[10px] text-gray-300 mt-1">Supported: JPG, PNG, PDF</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Terms & Submit -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" class="w-5 h-5 rounded text-navy focus:ring-navy cursor-pointer">
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
