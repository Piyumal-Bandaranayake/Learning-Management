<?php include 'includes/public_header.php'; ?>

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
            <form action="dashboard.php" method="GET" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-navy uppercase tracking-widest mb-2">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="email" placeholder="john@example.com" class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-bold text-navy uppercase tracking-widest">Password</label>
                        <a href="#" class="text-xs font-bold text-navy hover:underline">Forgot?</a>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="password" placeholder="••••••••" class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" class="w-4 h-4 rounded text-navy focus:ring-navy">
                    <span class="text-sm text-gray-500 italic">Keep me signed in</span>
                </div>

                <button type="submit" class="w-full bg-navy text-white py-4 rounded-xl font-bold hover:bg-navy-dark transition-all shadow-xl shadow-navy/10 active:scale-[0.98] text-lg">
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
