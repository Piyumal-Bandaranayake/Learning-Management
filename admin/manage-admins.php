<?php
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

$db = getDBConnection();
$errors = [];
$success = "";

if (isset($_GET['success']) && $_GET['success'] == '1') {
    $success = "New admin account created successfully!";
}

// Handle New Admin Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($name) || empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        $errors[] = "All required fields must be filled.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        try {
            // Check if username or email already exists in users table
            $check = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $check->execute([$username, $email]);
            if ($check->fetch()) {
                $errors[] = "Username or Email already exists.";
            } else {
                // Insert into users table
                $stmt1 = $db->prepare("INSERT INTO users (name, email, whatsapp_number, username, password, role) VALUES (?, ?, ?, ?, ?, 'admin')");
                $stmt1->execute([$name, $email, $whatsapp, $username, $hashed_password]);

                // Insert into admins table
                $stmt2 = $db->prepare("INSERT INTO admins (name, email, whatsapp_number, username, password, role) VALUES (?, ?, ?, ?, ?, 'admin')");
                $stmt2->execute([$name, $email, $whatsapp, $username, $hashed_password]);

                header("Location: manage-admins.php?success=1");
                exit;
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

// Handle Admin Deletion
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    
    // Prevent self-deletion if possible (or at least check)
    // For now, let's just delete by ID
    try {
        // We need to find the username first to delete from both tables
        $find = $db->prepare("SELECT username FROM admins WHERE id = ?");
        $find->execute([$delete_id]);
        $admin_to_del = $find->fetch();
        
        if ($admin_to_del) {
            $username_to_del = $admin_to_del['username'];
            
            // Delete from admins
            $del1 = $db->prepare("DELETE FROM admins WHERE id = ?");
            $del1->execute([$delete_id]);
            
            // Delete from users
            $del2 = $db->prepare("DELETE FROM users WHERE username = ? AND role = 'admin'");
            $del2->execute([$username_to_del]);
            
            header("Location: manage-admins.php?success=deleted");
            exit;
        }
    } catch (PDOException $e) {
        $errors[] = "Delete error: " . $e->getMessage();
    }
}

$success_msg = $success;
if (isset($_GET['success']) && $_GET['success'] == 'deleted') {
    $success_msg = "Admin account deleted successfully.";
}

// Fetch all admins
$admins = $db->query("SELECT * FROM admins ORDER BY created_at DESC")->fetchAll();

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';
?>

<div class="max-w-6xl mx-auto space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-navy uppercase tracking-tight">Admin <span class="text-blue-600">Management</span></h2>
            <p class="text-gray-500 text-sm font-bold uppercase tracking-widest mt-1">Create and manage administrative accounts</p>
        </div>
        <button onclick="document.getElementById('create-modal').classList.remove('hidden')" class="bg-navy text-white px-6 py-3 rounded-2xl font-black uppercase tracking-widest text-xs flex items-center gap-2 shadow-xl shadow-navy/20 hover:bg-navy-light transition-all active:scale-95">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Add New Admin
        </button>
    </div>

    <?php if ($errors): ?>
        <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl font-bold text-sm">
            <ul class="list-disc ml-5">
                <?php foreach ($errors as $error) echo "<li>$error</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success_msg): ?>
        <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl font-bold text-sm">
            <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <!-- Admins List -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-navy/40">Admin User</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-navy/40">Username</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-navy/40">Email Address</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-navy/40 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php foreach ($admins as $admin): ?>
                        <tr class="hover:bg-gray-50/30 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-navy text-white flex items-center justify-center font-black shadow-lg shadow-navy/20">
                                        <?php echo strtoupper(substr($admin['name'], 0, 1)); ?>
                                    </div>
                                    <span class="font-bold text-navy"><?php echo htmlspecialchars($admin['name']); ?></span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border border-blue-100 italic">
                                    @<?php echo htmlspecialchars($admin['username']); ?>
                                </span>
                            </td>
                            <td class="px-8 py-6 text-sm font-medium text-gray-500">
                                <?php echo htmlspecialchars($admin['email']); ?>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-2 text-right">
                                    <button onclick="viewAdmin(<?php echo $admin['id']; ?>)" class="p-2 text-navy hover:bg-navy hover:text-white rounded-xl transition-all border border-navy/10 shadow-sm" title="View Details">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                    <?php if ($admin['username'] !== 'admin'): ?>
                                    <a href="?delete_id=<?php echo $admin['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this admin account? This action cannot be undone.')"
                                       class="p-2 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-red-100 shadow-sm" 
                                       title="Remove Admin">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                    <?php else: ?>
                                    <span class="text-[8px] font-black text-gray-300 uppercase tracking-widest border border-gray-100 px-2 py-1.5 rounded-lg italic">Primary</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Admin Modal -->
<div id="create-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
    <div onclick="document.getElementById('create-modal').classList.add('hidden')" class="absolute inset-0 bg-navy/40 backdrop-blur-md"></div>
    <div class="relative bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="bg-navy p-8 text-white relative">
            <h3 class="text-xl font-black uppercase tracking-widest">Create Admin</h3>
            <p class="text-blue-200 text-[10px] font-bold uppercase tracking-[0.2em] mt-1 italic">New Administrative Credentials</p>
            <button onclick="document.getElementById('create-modal').classList.add('hidden')" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <form action="" method="POST" class="p-8 space-y-5">
            <input type="hidden" name="create_admin" value="1">
            
            <div>
                <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Full Name</label>
                <input type="text" name="name" required placeholder="e.g. John Doe"
                       class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Username</label>
                    <input type="text" name="username" required placeholder="admin_nick"
                           class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">WhatsApp</label>
                    <input type="text" name="whatsapp" placeholder="07XXXXXXXX"
                           class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Email Address</label>
                <input type="email" name="email" required placeholder="admin@example.com"
                       class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Password</label>
                    <div class="relative group/pass">
                        <input type="password" name="password" id="admin_password" required placeholder="••••••••"
                               class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                        <button type="button" onclick="toggleAdminPass('admin_password', 'pass-icon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors">
                            <i data-lucide="eye" id="pass-icon" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-navy tracking-widest mb-2 ml-1">Re-enter Password</label>
                    <div class="relative group/pass">
                        <input type="password" name="confirm_password" id="confirm_password" required placeholder="••••••••"
                               class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all font-semibold text-navy">
                        <button type="button" onclick="toggleAdminPass('confirm_password', 'confirm-pass-icon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors">
                            <i data-lucide="eye" id="confirm-pass-icon" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-1 ml-1 mt-1">
                <p id="pass-error" class="hidden text-[8px] font-black text-red-500 uppercase tracking-widest leading-tight">Must be at least 8 characters long</p>
                <p id="match-error" class="hidden text-[8px] font-black text-red-500 uppercase tracking-widest leading-tight">Passwords do not match</p>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" 
                        class="flex-1 px-6 py-4 rounded-2xl font-black uppercase tracking-widest text-navy bg-gray-100 hover:bg-gray-200 transition-all text-xs">
                    Cancel
                </button>
                <button type="submit" class="flex-[2] px-6 py-4 rounded-2xl font-black uppercase tracking-widest text-white bg-navy hover:bg-navy-light transition-all shadow-xl shadow-navy/20 active:scale-95 text-xs">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Admin Detail Modal -->
<div id="adminDetailModal" class="fixed inset-0 z-[100] hidden">
    <div onclick="closeAdminModal()" class="absolute inset-0 bg-navy/60 backdrop-blur-sm transition-opacity"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg p-4">
        <div id="modalContainer" class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
            <div class="bg-navy p-10 text-white relative">
                <button onclick="closeAdminModal()" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
                <div class="flex items-center gap-5">
                    <div id="admin_initials" class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-3xl flex items-center justify-center text-2xl font-black text-white shadow-inner">--</div>
                    <div>
                        <h3 id="admin_name_display" class="text-2xl font-black uppercase tracking-tight">Loading...</h3>
                        <p id="admin_role_display" class="text-blue-300 text-[10px] font-black uppercase tracking-[0.2em] italic">Access: Administrator</p>
                    </div>
                </div>
            </div>
            
            <div class="p-10 space-y-8">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Username</p>
                        <p id="admin_user_display" class="text-sm font-bold text-navy bg-gray-50 px-4 py-3 rounded-2xl border border-gray-100 italic">--</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">WhatsApp</p>
                        <p id="admin_whatsapp_display" class="text-sm font-bold text-navy bg-gray-50 px-4 py-3 rounded-2xl border border-gray-100">--</p>
                    </div>
                </div>
                
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Email Address</p>
                    <p id="admin_email_display" class="text-sm font-bold text-navy bg-gray-50 px-4 py-3 rounded-2xl border border-gray-100">--</p>
                </div>

                <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-1 leading-none">Registration Date</p>
                        <p id="admin_joined_display" class="text-[10px] font-black text-navy uppercase">--</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-500 shadow-sm border border-green-100">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewAdmin(id) {
    const modal = document.getElementById('adminDetailModal');
    const container = document.getElementById('modalContainer');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);

    fetch('get-admin-details.php?id=' + id)
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            if (data.success) {
                const a = data.admin;
                document.getElementById('admin_name_display').textContent = a.name;
                document.getElementById('admin_user_display').textContent = '@' + a.username;
                document.getElementById('admin_whatsapp_display').textContent = a.whatsapp_number || 'No Data';
                document.getElementById('admin_email_display').textContent = a.email;
                document.getElementById('admin_initials').textContent = a.name.charAt(0).toUpperCase();
                
                const date = new Date(a.created_at);
                document.getElementById('admin_joined_display').textContent = date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                
                if (window.lucide) window.lucide.createIcons();
            } else {
                throw new Error(data.message || 'Failed to fetch details');
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
            document.getElementById('admin_name_display').textContent = 'Error Loading Data';
            document.getElementById('admin_role_display').textContent = 'Please try again later';
        });
}

function closeAdminModal() {
    const modal = document.getElementById('adminDetailModal');
    const container = document.getElementById('modalContainer');
    container.classList.add('scale-95', 'opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

function toggleAdminPass(id, iconId) {
    const input = document.getElementById(id);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.setAttribute('data-lucide', 'eye-off');
    } else {
        input.type = 'password';
        icon.setAttribute('data-lucide', 'eye');
    }
    if (window.lucide) window.lucide.createIcons();
}

// Client-side validation
document.querySelector('#create-modal form').addEventListener('submit', function(e) {
    let hasError = false;
    const pass = document.getElementById('admin_password').value;
    const confirmPass = document.getElementById('confirm_password').value;
    const email = document.getElementsByName('email')[0].value;
    const username = document.getElementsByName('username')[0].value;
    
    // Password length validation
    const passError = document.getElementById('pass-error');
    if (pass.length < 8) {
        hasError = true;
        passError.classList.remove('hidden');
        document.getElementById('admin_password').classList.add('border-red-500', 'ring-red-50');
    } else {
        passError.classList.add('hidden');
        document.getElementById('admin_password').classList.remove('border-red-500', 'ring-red-50');
    }

    // Password match validation
    const matchError = document.getElementById('match-error');
    if (pass !== confirmPass) {
        hasError = true;
        matchError.classList.remove('hidden');
        document.getElementById('confirm_password').classList.add('border-red-500', 'ring-red-50');
    } else {
        matchError.classList.add('hidden');
        document.getElementById('confirm_password').classList.remove('border-red-500', 'ring-red-50');
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        hasError = true;
        document.getElementsByName('email')[0].classList.add('border-red-500', 'ring-red-50');
    } else {
        document.getElementsByName('email')[0].classList.remove('border-red-500', 'ring-red-50');
    }

    // Username validation (no spaces)
    if (username.includes(' ')) {
        hasError = true;
        document.getElementsByName('username')[0].classList.add('border-red-500', 'ring-red-50');
    } else {
        document.getElementsByName('username')[0].classList.remove('border-red-500', 'ring-red-50');
    }
    
    if (hasError) {
        e.preventDefault();
        alert('Please fix the errors in the form before submitting.');
    }
});
</script>

<?php include 'includes/footer.php'; ?>
