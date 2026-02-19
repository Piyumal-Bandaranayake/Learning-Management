<?php 
session_start();
include 'includes/public_header.php'; 
?>

<section id="reg-auth-section" class="min-h-screen flex items-center justify-center bg-white py-24 px-4 relative overflow-hidden group/auth">
    <!-- Ultra-Creative Studio Background -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Main Mesh Glow -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_100%,rgba(37,99,235,0.1),transparent_70%)]"></div>

        <!-- Interactive Glow (following mouse) -->
        <div id="reg-auth-bg-glow" class="absolute w-[800px] h-[800px] bg-blue-500/20 rounded-full blur-[150px] -translate-x-1/2 -translate-y-1/2 transition-opacity duration-1000 opacity-0 group-hover/auth:opacity-100"></div>

        <!-- Artistic Large Blobs - Increased Vibrancy -->
        <div class="absolute -bottom-[10%] -left-[10%] w-[700px] h-[700px] bg-gradient-to-br from-blue-200/50 to-cyan-100/30 rounded-full blur-[130px] animate-blob"></div>
        <div class="absolute top-[0%] -right-[10%] w-[600px] h-[600px] bg-gradient-to-tr from-purple-200/50 to-pink-200/40 rounded-full blur-[130px] animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[1000px] bg-indigo-50/50 rounded-full blur-[150px]"></div>

        <!-- Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.6]" style="background-image: url('data:image/svg+xml,%3Csvg width=\"40\" height=\"40\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"%230B3C5D\" fill-opacity=\"0.1\" fill-rule=\"evenodd\"%3E%3Ccircle cx=\"2\" cy=\"2\" r=\"1\"/%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <!-- Artistic SVG Lines -->
        <svg class="absolute bottom-0 left-0 w-full h-full opacity-[0.1] text-blue-600" viewBox="0 0 1200 800" fill="none">
            <path d="M0 600C300 500 600 700 900 600C1200 500 1500 600 1800 500" stroke="currentColor" stroke-width="4" stroke-dasharray="20 20" />
        </svg>

        <!-- Typographic Watermark - Increased Visibility -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[18rem] font-black text-blue-900 opacity-[0.03] select-none tracking-tighter italic uppercase">
            REGISTER
        </div>
    </div>

    <!-- Mouse motion script -->
    <script>
        const rAuthSection = document.getElementById('reg-auth-section');
        const rAuthGlow = document.getElementById('reg-auth-bg-glow');
        if (rAuthSection && rAuthGlow) {
            rAuthSection.addEventListener('mousemove', (e) => {
                const rect = rAuthSection.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                rAuthGlow.style.left = `${x}px`;
                rAuthGlow.style.top = `${y}px`;
            });
        }
    </script>

    <div class="max-w-2xl w-full relative z-10">
        <!-- Brand -->
        <div class="text-center mb-12" data-aos="fade-down">
            <div class="bg-navy p-3 rounded-2xl text-white inline-block mb-6 shadow-2xl shadow-navy/30 relative group/icon">
                <div class="absolute inset-0 bg-blue-400 rounded-2xl blur-xl opacity-0 group-hover/icon:opacity-40 transition-opacity"></div>
                <i data-lucide="graduation-cap" class="w-10 h-10 relative z-10"></i>
            </div>
            <h1 class="text-4xl lg:text-5xl font-extrabold text-navy italic tracking-tight uppercase leading-tight">Join <span class="text-blue-600 pr-2">Guideway</span> Network</h1>
            <p class="text-gray-500 mt-4 font-medium italic">Create your student account to unlock your potential.</p>
        </div>

        <!-- Registration Card -->
        <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[3rem] shadow-2xl shadow-navy/10 border border-white/50 relative overflow-hidden group/card" data-aos="fade-up">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover/card:bg-blue-500/10 transition-colors"></div>
            
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
                        <div class="relative">
                            <input type="password" name="password" id="reg-password" placeholder="••••••••" required
                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                   title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                   class="w-full pl-6 pr-12 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                            <button type="button" onclick="toggleRegPassword('reg-password', 'reg-pass-icon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors focus:outline-none">
                                <i data-lucide="eye" id="reg-pass-icon" class="w-5 h-5"></i>
                            </button>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-2 px-1">Must be 8+ chars, incl. uppercase, lowercase & number.</p>
                    </div>
                    <!-- Confirm Password Field -->
                    <div>
                        <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Confirm Password</label>
                        <div class="relative">
                            <input type="password" name="confirm_password" id="reg-confirm-password" placeholder="••••••••" required
                                   class="w-full pl-6 pr-12 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                            <button type="button" onclick="toggleRegPassword('reg-confirm-password', 'reg-confirm-pass-icon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors focus:outline-none">
                                <i data-lucide="eye" id="reg-confirm-pass-icon" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    function toggleRegPassword(inputId, iconId) {
                        const input = document.getElementById(inputId);
                        const icon = document.getElementById(iconId);
                        
                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.setAttribute('data-lucide', 'eye-off');
                        } else {
                            input.type = 'password';
                            icon.setAttribute('data-lucide', 'eye');
                        }
                        lucide.createIcons();
                    }
                </script>

                <div class="flex items-start gap-3 mt-4">
                                        <input type="checkbox" name="terms" value="1" required class="w-5 h-5 mt-0.5 rounded text-navy focus:ring-navy cursor-pointer">
                    <span class="text-sm text-gray-500 italic leading-tight">I agree to the <a href="#" onclick="openTermsModal(event)" class="text-navy font-black underline">Terms and Conditions</a>.</span>
                </div>

                <!-- Terms Modal -->
                <div id="terms-modal" class="fixed inset-0 z-[100] hidden">
                    <!-- Backdrop -->
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeTermsModal()"></div>
                    
                    <!-- Modal Content -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl bg-white rounded-[2rem] shadow-2xl p-8 max-h-[80vh] overflow-y-auto">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-navy italic">Terms and Conditions</h3>
                            <button type="button" onclick="closeTermsModal()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                <i data-lucide="x" class="w-6 h-6 text-gray-500"></i>
                            </button>
                        </div>
                        
                        <div class="prose prose-sm text-gray-500 overflow-y-auto max-h-[60vh] pr-2 custom-scrollbar">
                            <p class="mb-4"><strong>1. Introduction</strong><br>Welcome to Guideway Learning Network. By accessing our website and using our services, you agree to be bound by the following terms and conditions.</p>
                            
                            <p class="mb-4"><strong>2. User Accounts</strong><br>To access certain features, you must create an account. You agree to provide accurate, current, and complete information during the registration process and to update such information to keep it accurate, current, and complete.</p>
                            
                            <p class="mb-4"><strong>3. Course Enrollment</strong><br>When you enroll in a course, you get a license from us to view it via the Guideway Learning Network services and no other use. You may not transfer or resell courses in any way.</p>
                            
                            <p class="mb-4"><strong>4. Payment</strong><br>You agree to pay the fees for courses that you purchase, and you authorize us to charge your debit or credit card or process other means of payment for those fees.</p>
                            
                            <p class="mb-4"><strong>5. Content and Behavior Rules</strong><br>You may not use the Services for any illegal purpose. You are responsible for all the content that you post on our platform.</p>
                            
                            <p class="mb-4"><strong>6. Limitation of Liability</strong><br>To the extent permitted by law, we (and our group companies, suppliers, partners, and agents) will not be liable for any indirect, incidental, punitive, or consequential damages.</p>
                            
                            <p class="mb-4"><strong>7. Changes to Terms</strong><br>We reserve the right to modify these terms at any time. If we make changes to these terms, we will post the amended terms on the Services.</p>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                            <button type="button" onclick="closeTermsModal()" class="px-6 py-2.5 bg-navy text-white font-bold rounded-xl hover:bg-navy-dark transition-colors text-sm">
                                I Understand
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    function openTermsModal(e) {
                        e.preventDefault();
                        const modal = document.getElementById('terms-modal');
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden'; // Prevent scrolling
                        lucide.createIcons(); // specialized re-render in case icons inside modal need it
                    }

                    function closeTermsModal() {
                        const modal = document.getElementById('terms-modal');
                        modal.classList.add('hidden');
                        document.body.style.overflow = ''; // Restore scrolling
                    }

                    // Close on Escape key
                    document.addEventListener('keydown', function(event) {
                        if (event.key === "Escape") {
                            closeTermsModal();
                        }
                    });
                </script>

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
