<?php 
session_start();
include 'includes/public_header.php'; 
?>

<section class="min-h-[90vh] flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full">
        <!-- Brand -->
        <div class="text-center mb-10">
            <div class="bg-navy p-3 rounded-2xl text-white inline-block mb-4 shadow-xl shadow-navy/20">
                <i data-lucide="graduation-cap" class="w-10 h-10"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-navy italic">Welcome Back</h1>
            <p class="text-gray-500 mt-2">Sign in to your account to continue</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white p-8 rounded-3xl shadow-xl shadow-navy/5 border border-gray-100">
            
            <!-- Alerts -->
            <?php if (isset($_SESSION['success_msg'])): ?>
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl">
                    <p class="text-sm font-bold italic"><?php echo $_SESSION['success_msg']; ?></p>
                </div>
            <?php unset($_SESSION['success_msg']); endif; ?>

            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl">
                    <p class="text-sm font-bold italic"><?php echo $_SESSION['login_error']; ?></p>
                </div>
            <?php unset($_SESSION['login_error']); endif; ?>

            <form action="auth/login.php" method="POST" class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Username or Email</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="text" name="username" placeholder="john_doe" required 
                               class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic ml-1">Password</label>
                        <a href="forgot-password.php" class="text-[10px] font-black text-navy hover:underline uppercase italic">Forgot?</a>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="password" name="password" id="login-password" placeholder="••••••••" required
                               class="w-full pl-12 pr-12 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors focus:outline-none">
                            <i data-lucide="eye" id="password-toggle-icon" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <script>
                    function togglePasswordVisibility() {
                        const passwordInput = document.getElementById('login-password');
                        const icon = document.getElementById('password-toggle-icon');
                        
                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            icon.setAttribute('data-lucide', 'eye-off');
                        } else {
                            passwordInput.type = 'password';
                            icon.setAttribute('data-lucide', 'eye');
                        }
                        // Re-render icons
                        lucide.createIcons();
                    }
                </script>

                <div class="flex items-center gap-3">
                    <input type="checkbox" class="w-5 h-5 rounded text-navy focus:ring-navy cursor-pointer">
                    <span class="text-sm text-gray-500 italic">Keep me signed in</span>
                </div>

                <button type="submit" class="w-full bg-navy text-white py-5 rounded-2xl font-black uppercase italic tracking-[0.2em] hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-[0.98] text-lg mt-4">
                    Sign In
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                <p class="text-gray-400 text-sm">
                    Don't have an account? 
                    <a href="register.php" class="text-navy font-black hover:underline">Create one</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/public_footer.php'; ?>
