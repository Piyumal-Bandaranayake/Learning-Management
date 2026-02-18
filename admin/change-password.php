<?php
require_once dirname(__DIR__, 1) . '/config/database.php';
require_once '../includes/auth_check.php';
require_admin();

$db = getDBConnection();
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    if ($new_password !== $confirm_password) {
        $errors[] = "New password and confirmation do not match.";
    }

    if (strlen($new_password) < 8) {
        $errors[] = "New password must be at least 8 characters long.";
    }

    if (empty($errors)) {
        $user_id = $_SESSION['user_id'];
        // Check in admins table specifically
        $stmt = $db->prepare("SELECT password FROM admins WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if ($user && password_verify($current_password, $user['password'])) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_stmt = $db->prepare("UPDATE admins SET password = ? WHERE id = ?");
            if ($update_stmt->execute([$hashed_password, $user_id])) {
                $_SESSION['success_msg'] = "Password updated successfully! Please log in with your new credentials.";
                // Clear sensitive session data but keep success message for the login page
                unset($_SESSION['user_id']);
                unset($_SESSION['role']);
                unset($_SESSION['name']);
                
                header("Location: ../login.php");
                exit;
            } else {
                $errors[] = "Failed to update password. Please try again.";
            }
        } else {
            $errors[] = "Current password is incorrect.";
        }
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';
?>

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="bg-navy p-8 text-white relative overflow-hidden text-center">
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-md">
                    <i data-lucide="key-round" class="w-8 h-8 text-white"></i>
                </div>
                <h2 class="text-2xl font-black uppercase italic tracking-widest">Security Settings</h2>
                <p class="text-blue-200 text-[10px] mt-1 uppercase font-bold tracking-[0.2em] italic">Change Administrative Password</p>
            </div>
            <!-- Decorative Graphics -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2"></div>
        </div>

        <div class="p-10">
            <?php if (!empty($errors)): ?>
                <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl space-y-1">
                    <?php foreach ($errors as $error): ?>
                        <p class="text-sm font-bold italic">• <?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl flex items-center justify-between">
                    <p class="text-sm font-bold italic"><?php echo $success; ?></p>
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-green-500"></i>
                </div>
            <?php endif; ?>

            <form action="change-password.php" method="POST" class="space-y-6">
                <!-- Current Password -->
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-[0.15em] italic mb-2 ml-1">Current Password</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4 transition-colors group-focus-within:text-navy"></i>
                        <input type="password" name="current_password" id="current_pass" required
                               placeholder="••••••••"
                               class="w-full pl-12 pr-12 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-medium text-navy">
                        <button type="button" onclick="togglePass('current_pass', 'icon-1')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors focus:outline-none">
                            <i data-lucide="eye" id="icon-1" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <hr class="border-gray-50">

                <!-- New Password -->
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-[0.15em] italic mb-2 ml-1">New Password</label>
                    <div class="relative group">
                        <i data-lucide="shield-check" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4 transition-colors group-focus-within:text-navy"></i>
                        <input type="password" name="new_password" id="new_pass" required
                               placeholder="••••••••"
                               class="w-full pl-12 pr-12 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-medium text-navy">
                        <button type="button" onclick="togglePass('new_pass', 'icon-2')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors focus:outline-none">
                            <i data-lucide="eye" id="icon-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <p class="text-[9px] text-gray-400 mt-2 font-bold italic ml-1 uppercase tracking-widest leading-tight">Must be at least 8 characters long with numbers and letters.</p>
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-[0.15em] italic mb-2 ml-1">Confirm New Password</label>
                    <div class="relative group">
                        <i data-lucide="shield-check" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4 transition-colors group-focus-within:text-navy"></i>
                        <input type="password" name="confirm_password" id="confirm_pass" required
                               placeholder="••••••••"
                               class="w-full pl-12 pr-12 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-medium text-navy">
                        <button type="button" onclick="togglePass('confirm_pass', 'icon-3')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors focus:outline-none">
                            <i data-lucide="eye" id="icon-3" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <script>
                    function togglePass(inputId, iconId) {
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

                <div class="pt-4">
                    <button type="submit" class="w-full bg-navy text-white py-5 rounded-2xl font-black uppercase italic tracking-[0.2em] hover:bg-navy-dark transition-all shadow-xl shadow-navy/20 active:scale-95 text-xs flex items-center justify-center gap-2">
                        Update Password
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                    <p class="text-center text-[10px] text-gray-400 mt-4 font-bold italic uppercase tracking-widest leading-tight">Changing your password will NOT logout current sessions.</p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
