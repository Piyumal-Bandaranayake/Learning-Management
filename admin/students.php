<?php 
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

$db = getDBConnection();

// Get Search Term
$search = trim($_GET['search'] ?? '');

// Fetch Students with Enrollment Counts
$query = "
    SELECT u.*, 
    (SELECT COUNT(*) FROM registrations WHERE user_id = u.id AND status = 'approved') as enrollment_count 
    FROM users u 
    WHERE u.role = 'student'
";

if (!empty($search)) {
    $query .= " AND (u.name LIKE :search OR u.email LIKE :search OR u.username LIKE :search)";
}

$query .= " ORDER BY u.created_at DESC";

$stmt = $db->prepare($query);
if (!empty($search)) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}
$students = $stmt->fetchAll();

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
include 'includes/navbar.php'; 
?>

<div class="max-w-7xl mx-auto px-4">
    <!-- Filters row -->
    <div class="flex flex-col md:flex-row gap-4 mb-10">
        <form action="" method="GET" class="flex-1 relative">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by name, email or username..." class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-100 bg-white focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all shadow-sm italic text-sm">
        </form>
        <div class="flex gap-4 items-center">
            <button class="bg-navy text-white px-8 py-4 rounded-2xl font-black uppercase italic tracking-widest text-xs shadow-xl shadow-navy/20">
                Export to Excel
            </button>
        </div>
    </div>

    <!-- Student List Table -->
    <div class="bg-white rounded-3xl shadow-xl shadow-navy/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-navy text-white">
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Full Name</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Contact Info</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Joined Date</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic">Courses</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-[0.2em] italic text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic font-bold">No students found.</td>
                        </tr>
                    <?php else: foreach ($students as $student): ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-5 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-navy text-white flex items-center justify-center font-black italic shadow-lg shadow-navy/20">
                                    <?php 
                                    $initials = '';
                                    $names = explode(' ', $student['name']);
                                    foreach ($names as $n) $initials .= strtoupper($n[0]);
                                    echo substr($initials, 0, 2);
                                    ?>
                                </div>
                                <div>
                                    <p class="font-bold text-navy italic"><?php echo htmlspecialchars($student['name']); ?></p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter italic">@<?php echo htmlspecialchars($student['username']); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-xs font-bold text-gray-600"><?php echo htmlspecialchars($student['email']); ?></p>
                                <p class="text-[10px] text-blue-500 font-bold italic"><?php echo htmlspecialchars($student['whatsapp_number']); ?></p>
                            </td>
                            <td class="px-6 py-5 text-sm font-bold text-navy italic">
                                <?php echo date('M d, Y', strtotime($student['created_at'])); ?>
                            </td>
                            <td class="px-6 py-5">
                                <?php if ($student['enrollment_count'] > 0): ?>
                                    <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-sm font-black border border-green-100 italic shadow-sm">
                                        <?php echo $student['enrollment_count']; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-300 font-bold italic text-xs">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="viewStudent(<?php echo $student['id']; ?>)" class="p-2 text-navy hover:bg-navy hover:text-white rounded-xl transition-all border border-navy/10 shadow-sm" title="View Profile">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                    <button class="p-2 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-red-100 shadow-sm" title="Remove Student">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Student Profile Modal -->
<div id="studentModal" class="fixed inset-0 z-[100] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-navy/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    
    <!-- Modal Content -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-black/20 overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="modalContainer">
            <!-- Header -->
            <div class="relative h-32 bg-navy flex items-end px-8 pb-4">
                <button onclick="closeModal()" class="absolute top-6 right-6 text-white/50 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
                <div class="flex items-center gap-4 translate-y-8">
                    <div id="studentInitials" class="w-20 h-20 rounded-2xl bg-white text-navy flex items-center justify-center text-2xl font-black italic shadow-xl">
                        --
                    </div>
                </div>
            </div>

            <div class="pt-12 px-8 pb-8">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h2 id="studentName" class="text-2xl font-black text-navy italic">Loading...</h2>
                        <p id="studentEmail" class="text-sm font-bold text-gray-400">--</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black uppercase text-gray-300 tracking-[0.2em] italic mb-1">Joined Date</p>
                        <p id="studentJoined" class="text-xs font-bold text-navy italic">--</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1 italic">WhatsApp</p>
                        <p id="studentPhone" class="text-sm font-bold text-navy italic">--</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1 italic">Username</p>
                        <p id="studentUser" class="text-sm font-bold text-navy italic">--</p>
                    </div>
                </div>

                <h3 class="font-black text-navy uppercase italic text-xs tracking-[0.2em] mb-4 border-b border-gray-100 pb-2">Registered Courses</h3>
                <div id="courseList" class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                    <!-- Courses will load here -->
                    <div class="animate-pulse flex gap-4 p-3 grayscale opacity-30">
                        <div class="w-10 h-10 bg-gray-200 rounded-lg"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewStudent(id) {
    const modal = document.getElementById('studentModal');
    const container = document.getElementById('modalContainer');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);

    // Reset UI
    document.getElementById('courseList').innerHTML = '<div class="text-center py-4 text-gray-400 italic text-sm">Loading courses...</div>';

    fetch('get-student-details.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const s = data.student;
                document.getElementById('studentName').innerText = s.name;
                document.getElementById('studentEmail').innerText = s.email;
                document.getElementById('studentPhone').innerText = s.whatsapp_number;
                document.getElementById('studentUser').innerText = '@' + s.username;
                
                // Get Initials
                const initials = s.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                document.getElementById('studentInitials').innerText = initials;

                const date = new Date(s.created_at);
                document.getElementById('studentJoined').innerText = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

                // Courses
                let html = '';
                if (data.courses.length === 0) {
                    html = '<div class="text-center py-6 border-2 border-dashed border-gray-100 rounded-2xl text-gray-300 italic font-bold">No courses registered yet.</div>';
                } else {
                    data.courses.forEach(c => {
                        const statusColor = c.status === 'approved' ? 'text-green-500 bg-green-50' : (c.status === 'pending' ? 'text-amber-500 bg-amber-50' : 'text-red-500 bg-red-50');
                        html += `
                            <div class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-2xl hover:border-navy/20 transition-all hover:shadow-md group">
                                <div class="flex items-center gap-3">
                                    <img src="../${c.image}" class="w-10 h-10 rounded-xl object-cover shadow-sm bg-gray-100" alt="Course Cover" onerror="this.src='https://ui-avatars.com/api/?name='+encodeURIComponent(c.course_title)+'&background=0B3C5D&color=fff'">
                                    <div>
                                        <p class="text-sm font-bold text-navy italic">${c.course_title}</p>
                                        <p class="text-[9px] font-black uppercase text-gray-400 italic">Applied: ${new Date(c.applied_date).toLocaleDateString()}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="text-[10px] font-black italic text-navy">$${c.price}</span>
                                    <span class="text-[8px] font-black uppercase px-2 py-0.5 rounded-full ${statusColor}">${c.status}</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('courseList').innerHTML = html;
                lucide.createIcons();
            }
        });
}

function closeModal() {
    const modal = document.getElementById('studentModal');
    const container = document.getElementById('modalContainer');
    
    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}
</script>

<?php include 'includes/footer.php'; ?>
