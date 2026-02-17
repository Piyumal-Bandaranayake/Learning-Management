<?php 
session_start();
include 'includes/public_header.php'; 
?>

<section class="min-h-[95vh] flex items-center justify-center bg-gray-50 py-20 px-4">
    <div class="max-w-xl w-full">
        <!-- Brand -->
        <div class="text-center mb-10">
            <div class="bg-navy p-3 rounded-2xl text-white inline-block mb-4 shadow-xl shadow-navy/20">
                <i data-lucide="graduation-cap" class="w-10 h-10"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-navy italic">Join LMS Core</h1>
            <p class="text-gray-500 mt-2">Create your student account to start learning</p>
        </div>

        <!-- Registration Card -->
        <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-navy/5 border border-gray-100">
            
            <!-- Error Alerts -->
            <?php if (isset($_SESSION['register_errors'])): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl space-y-1">
                    <?php foreach ($_SESSION['register_errors'] as $error): ?>
                        <p class="text-sm font-bold italic">• <?php echo $error; ?></p>
                    <?php endforeach; unset($_SESSION['register_errors']); ?>
                </div>
            <?php endif; ?>

            <form action="auth/register.php" method="POST" class="space-y-6">
                <!-- Name Field -->
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Full Name</label>
                    <input type="text" name="name" placeholder="John Doe" required
                           value="<?php echo $_SESSION['form_data']['name'] ?? ''; ?>"
                           class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Email Field -->
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" placeholder="john@example.com" required
                               value="<?php echo $_SESSION['form_data']['email'] ?? ''; ?>"
                               class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                    <!-- WhatsApp Field -->
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" placeholder="07XXXXXXXX" required
                               value="<?php echo $_SESSION['form_data']['whatsapp_number'] ?? ''; ?>"
                               class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                </div>

                <!-- Username Field -->
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Desired Username</label>
                    <input type="text" name="username" placeholder="john_doe" required
                           value="<?php echo $_SESSION['form_data']['username'] ?? ''; ?>"
                           class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password Field -->
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Password</label>
                        <input type="password" name="password" placeholder="••••••••" required
                               class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                    <!-- Confirm Password Field -->
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="••••••••" required
                               class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                </div>

                <div class="flex items-start gap-3 mt-4">
                    <input type="checkbox" required class="w-5 h-5 mt-0.5 rounded text-navy focus:ring-navy cursor-pointer">
                    <span class="text-sm text-gray-500 italic leading-tight">I agree to the <a href="#" class="text-navy font-black underline">Terms</a> and <a href="#" class="text-navy font-black underline">Privacy Policy</a>.</span>
                </div>

                <button type="submit" class="w-full bg-navy text-white py-5 rounded-2xl font-black uppercase italic tracking-[0.2em] hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-[0.98] text-lg mt-4">
                    Create Account
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                <p class="text-gray-400 text-sm">
                    Already have an account? 
                    <a href="login.php" class="text-navy font-black hover:underline">Sign in instead</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php 
unset($_SESSION['form_data']); // Clear form data after display
include 'includes/public_footer.php'; 
?>
