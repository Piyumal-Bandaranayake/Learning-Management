<?php include 'includes/public_header.php'; ?>

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
            <form action="login.php" method="GET" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-navy uppercase tracking-widest mb-2">First Name</label>
                        <input type="text" placeholder="John" class="w-full px-4 py-3.5 rounded-xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-navy uppercase tracking-widest mb-2">Last Name</label>
                        <input type="text" placeholder="Doe" class="w-full px-4 py-3.5 rounded-xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-navy uppercase tracking-widest mb-2">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="email" placeholder="john@example.com" class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-navy uppercase tracking-widest mb-2">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="password" placeholder="••••••••" class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <input type="checkbox" class="w-5 h-5 mt-0.5 rounded text-navy focus:ring-navy cursor-pointer">
                    <span class="text-sm text-gray-500 italic">I agree to the <a href="#" class="text-navy font-black underline">Terms of Service</a> and <a href="#" class="text-navy font-black underline">Privacy Policy</a>.</span>
                </div>

                <button type="submit" class="w-full bg-navy text-white py-4 rounded-xl font-bold hover:bg-navy-dark transition-all shadow-xl shadow-navy/10 active:scale-[0.98] text-lg">
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

<?php include 'includes/public_footer.php'; ?>
