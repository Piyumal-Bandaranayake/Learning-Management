<?php 
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot-password.php");
    exit;
}

$error = '';
$email = $_SESSION['reset_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password)) {
        $error = "Password must be at least 8 characters with uppercase, lowercase, and numbers.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $db = getDBConnection();
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashed_password, $email]);
        
        unset($_SESSION['reset_email']);
        $_SESSION['success_msg'] = "Password reset successfully. Please login.";
        header("Location: login.php");
        exit;
    }
}

include 'includes/public_header.php'; 
?>

<section class="min-h-[80vh] flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full">
        <!-- Brand -->
        <div class="text-center mb-10">
            <div class="bg-navy p-3 rounded-2xl text-white inline-block mb-4 shadow-xl shadow-navy/20">
                <i data-lucide="lock-keyhole" class="w-10 h-10"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-navy italic">Reset Password</h1>
            <p class="text-gray-500 mt-2">Create a new strong password for <?php echo htmlspecialchars($email); ?></p>
        </div>

        <!-- Card -->
        <div class="bg-white p-8 rounded-3xl shadow-xl shadow-navy/5 border border-gray-100">
            
            <?php if (!empty($error)): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl">
                    <p class="text-sm font-bold italic"><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                
                <!-- Password Field -->
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">New Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="reset-password" placeholder="••••••••" required
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                               title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                               class="w-full pl-6 pr-12 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                        <button type="button" onclick="toggleResetPassword('reset-password', 'reset-pass-icon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors focus:outline-none">
                            <i data-lucide="eye" id="reset-pass-icon" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2 px-1">Must be 8+ chars, incl. uppercase, lowercase & number.</p>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest italic mb-2 ml-1">Confirm New Password</label>
                    <div class="relative">
                        <input type="password" name="confirm_password" id="reset-confirm-password" placeholder="••••••••" required
                               class="w-full pl-6 pr-12 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all">
                        <button type="button" onclick="toggleResetPassword('reset-confirm-password', 'reset-confirm-pass-icon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors focus:outline-none">
                            <i data-lucide="eye" id="reset-confirm-pass-icon" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <script>
                    function toggleResetPassword(inputId, iconId) {
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

                <button type="submit" class="w-full bg-navy text-white py-5 rounded-2xl font-black uppercase italic tracking-[0.2em] hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-[0.98] text-lg mt-4">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/public_footer.php'; ?>
