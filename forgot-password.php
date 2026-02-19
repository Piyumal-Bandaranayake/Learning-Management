<?php 
session_start();
require_once 'config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    
    if (empty($email)) {
        $error = "Please enter your email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $db = getDBConnection();
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $_SESSION['reset_email'] = $email;
            header("Location: reset-password.php");
            exit;
        } else {
            $error = "No account found with that email address.";
        }
    }
}

include 'includes/public_header.php'; 
?>

<section id="auth-section" class="min-h-[95vh] flex items-center justify-center bg-white py-20 px-4 relative overflow-hidden group/auth">
    <!-- Ultra-Creative Studio Background -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Main Mesh Glow -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(37,99,235,0.1),transparent_80%)]"></div>

        <!-- Interactive Glow (following mouse) -->
        <div id="auth-bg-glow" class="absolute w-[800px] h-[800px] bg-blue-500/20 rounded-full blur-[150px] -translate-x-1/2 -translate-y-1/2 transition-opacity duration-1000 opacity-0 group-hover/auth:opacity-100"></div>

        <!-- Artistic Large Blobs - Increased Vibrancy -->
        <div class="absolute -top-[10%] -left-[10%] w-[600px] h-[600px] bg-gradient-to-br from-blue-200/50 to-cyan-100/30 rounded-full blur-[120px] animate-blob"></div>
        <div class="absolute bottom-[0%] -right-[10%] w-[500px] h-[500px] bg-gradient-to-tr from-purple-200/50 to-pink-100/30 rounded-full blur-[120px] animate-blob animation-delay-4000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-50/50 rounded-full blur-[150px]"></div>

        <!-- Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.6]" style="background-image: url('data:image/svg+xml,%3Csvg width=\"30\" height=\"30\" viewBox=\"0 0 30 30\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"%230B3C5D\" fill-opacity=\"0.1\" fill-rule=\"evenodd\"%3E%3Ccircle cx=\"2\" cy=\"2\" r=\"1\"/%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <!-- Artistic SVG Lines -->
        <svg class="absolute top-1/2 left-0 w-full h-96 -translate-y-1/2 opacity-[0.1] text-blue-600" viewBox="0 0 1200 400" fill="none">
            <path d="M0 200C300 100 600 300 900 200C1200 100 1500 200 1800 100" stroke="currentColor" stroke-width="4" stroke-dasharray="20 20" class="animate-[pulse_10s_infinite]" />
        </svg>

        <!-- Typographic Watermark -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[15rem] font-black text-blue-900 opacity-[0.03] select-none tracking-tighter italic uppercase">
            RECOVERY
        </div>
    </div>

    <!-- Mouse motion script -->
    <script>
        const authSection = document.getElementById('auth-section');
        const authGlow = document.getElementById('auth-bg-glow');
        if (authSection && authGlow) {
            authSection.addEventListener('mousemove', (e) => {
                const rect = authSection.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                authGlow.style.left = `${x}px`;
                authGlow.style.top = `${y}px`;
            });
        }
    </script>

    <div class="max-w-md w-full relative z-10">
        <!-- Brand -->
        <div class="text-center mb-10" data-aos="fade-down">
            <div class="bg-navy p-3 rounded-2xl text-white inline-block mb-6 shadow-2xl shadow-navy/30 relative group/icon">
                <div class="absolute inset-0 bg-blue-400 rounded-2xl blur-xl opacity-0 group-hover/icon:opacity-40 transition-opacity"></div>
                <i data-lucide="key-round" class="w-10 h-10 relative z-10"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-navy italic tracking-tight uppercase">Forgot <span class="text-blue-600 pr-2 pr-2">Password?</span></h1>
            <p class="text-gray-500 mt-3 font-medium italic">Enter your email address to reset your access.</p>
        </div>

        <!-- Card -->
        <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-2xl shadow-navy/10 border border-white/50 relative overflow-hidden group/card" data-aos="fade-up">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover/card:bg-blue-500/10 transition-colors"></div>
            
            <?php if (!empty($error)): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl">
                    <p class="text-sm font-bold italic"><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                        <input type="email" name="email" placeholder="john@example.com" required 
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                               class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                    </div>
                </div>

                <button type="submit" class="w-full bg-navy text-white py-5 rounded-2xl font-black uppercase italic tracking-[0.2em] hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-[0.98] text-lg mt-4">
                    Verify Email
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                <p class="text-gray-400 text-sm">
                    Remember your password? 
                    <a href="login.php" class="text-navy font-black hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/public_footer.php'; ?>

