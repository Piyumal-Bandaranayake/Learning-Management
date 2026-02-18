<?php 
require_once 'config/database.php';
$db = getDBConnection();

// Fetch all timetable entries ordered by title and then by day of week
$timetable_query = $db->query("SELECT * FROM timetable ORDER BY class_title ASC, FIELD(day_name, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), class_time ASC");
$all_rows = $timetable_query->fetchAll(PDO::FETCH_ASSOC);

// Group by class_title
$grouped_classes = [];
foreach ($all_rows as $row) {
    echo "<!-- Debug: Row image for " . htmlspecialchars($row['class_title']) . ": " . htmlspecialchars($row['class_image']) . " -->";
    $title = $row['class_title'];
    if (!isset($grouped_classes[$title])) {
        // Use the image from the first occurrence
        $image_url = !empty($row['class_image']) ? $row['class_image'] : 'assets/images/placeholder-class.jpg';
        
        $grouped_classes[$title] = [
            'info' => [
                'title' => $row['class_title'],
                'short_desc' => $row['short_description'],
                'full_desc' => $row['full_description'],
                'instructor' => $row['instructor'],
                'duration' => $row['duration'],
                'image' => $image_url
            ],
            'sessions' => []
        ];
    }
    $grouped_classes[$title]['sessions'][] = [
        'location' => $row['location'],
        'day' => $row['day_name'],
        'time' => date('h:i A', strtotime($row['class_time']))
    ];
}

include 'includes/public_header.php'; 
?>

<!-- Timetable Hero Section -->
<header class="relative bg-navy py-24 overflow-hidden border-none shadow-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-5xl lg:text-6xl font-black text-white mb-6 italic tracking-tight uppercase">Physical Class Schedule</h1>
        <p class="text-xl text-blue-100/70 max-w-2xl leading-relaxed italic font-medium mx-auto">
            Join our in-person sessions. Find your class and check the available slots.
        </p>
    </div>
    
    <!-- Background Glow -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
</header>

<section class="py-24 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <?php if (empty($grouped_classes)): ?>
            <div class="py-32 bg-white rounded-[3rem] shadow-xl shadow-navy/5 border border-gray-100 text-center">
                <div class="w-24 h-24 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="calendar-x" class="text-gray-300 w-12 h-12"></i>
                </div>
                <h3 class="text-2xl font-black text-navy italic uppercase">No Classes Scheduled</h3>
                <p class="text-gray-400 font-bold italic mt-2">Check back later for new physical class sessions.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach ($grouped_classes as $class): ?>
                    <?php 
                        $info = $class['info']; 
                        $sessions_json = htmlspecialchars(json_encode($class['sessions']), ENT_QUOTES, 'UTF-8');
                        $info_json = htmlspecialchars(json_encode($info), ENT_QUOTES, 'UTF-8');
                    ?>
                    <div class="timetable-card bg-white rounded-[3rem] border border-gray-100 shadow-xl shadow-navy/5 overflow-hidden group hover:border-navy/20 transition-all duration-500 cursor-pointer flex flex-col h-full"
                         data-info="<?php echo $info_json; ?>"
                         data-sessions="<?php echo $sessions_json; ?>">
                        
                        <!-- Class Image -->
                        <div class="relative h-56 overflow-hidden bg-navy">
                            <?php if (!empty($info['image']) && $info['image'] !== 'assets/images/placeholder-class.jpg'): ?>
                                <img src="<?php echo htmlspecialchars($info['image']); ?>" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                                     alt="<?php echo htmlspecialchars($info['title']); ?>">
                            <?php else: ?>
                                <!-- Fallback Layout if image missing -->
                                <div class="w-full h-full bg-navy flex items-center justify-center group-hover:scale-110 transition-transform duration-700">
                                    <i data-lucide="image-off" class="text-white/20 w-16 h-16"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="absolute inset-0 bg-navy/20 group-hover:bg-navy/10 transition-colors"></div>
                            
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full shadow-lg">
                                <div class="flex items-center gap-1.5 text-navy">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest italic"><?php echo htmlspecialchars($info['duration']); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 flex-1 flex flex-col">
                            <h3 class="text-xl font-black text-navy italic mb-2 line-clamp-2 group-hover:text-blue-500 transition-colors">
                                <?php echo htmlspecialchars($info['title']); ?>
                            </h3>
                            <p class="text-xs font-bold text-gray-400 italic mb-6 line-clamp-3">
                                <?php echo htmlspecialchars($info['short_desc']); ?>
                            </p>
                            
                            <div class="mt-auto flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black uppercase text-gray-400 tracking-widest leading-none">Instructor</p>
                                    <p class="text-xs font-black text-navy italic"><?php echo htmlspecialchars($info['instructor']); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="px-8 pb-8">
                            <button class="w-full py-4 bg-navy text-white rounded-2xl font-black uppercase italic tracking-widest text-[10px] group-hover:bg-blue-600 transition-colors shadow-lg shadow-navy/20">
                                View Schedule
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Class Details Modal -->
<div id="classModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div id="modalBackdrop" class="absolute inset-0 bg-navy/80 backdrop-blur-md transition-opacity duration-500 opacity-0"></div>
    
    <div id="modalContent" class="relative bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden transform scale-90 opacity-0 transition-all duration-500 max-h-[90vh] flex flex-col">
        
        <!-- Modal Image Header -->
        <div class="relative h-64 shrink-0 overflow-hidden bg-navy">
             <img id="modalImage" src="" class="w-full h-full object-cover">
             <div class="absolute inset-0 bg-gradient-to-t from-navy/90 via-navy/20 to-transparent"></div>
             
             <button id="closeModal" class="absolute top-6 right-6 bg-black/20 hover:bg-black/40 backdrop-blur-md text-white p-2 rounded-xl transition-all group active:scale-90 z-20">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

             <div class="absolute bottom-6 left-8 right-8 z-10">
                <h2 id="modalTitle" class="text-3xl font-black text-white italic uppercase tracking-tighter mb-2 shadow-black/10 drop-shadow-lg">Class Title</h2>
                <div class="flex items-center gap-2 text-blue-200 text-xs font-bold italic">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span id="modalInstructor">Instructor Name</span>
                </div>
             </div>
        </div>

        <!-- Modal Body -->
        <div class="p-8 bg-white relative overflow-y-auto custom-scrollbar flex-1">
            
            <div class="mb-8">
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] italic mb-3 ml-1">About the Class</h4>
                <p id="modalDescription" class="text-sm font-medium text-gray-600 italic leading-relaxed"></p>
            </div>

            <div>
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] italic mb-4 ml-1">Weekly Sessions</h4>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="py-3 px-4 text-[10px] font-black uppercase text-navy tracking-widest italic bg-gray-50/50 first:rounded-tl-xl first:rounded-bl-xl">Day</th>
                                <th class="py-3 px-4 text-[10px] font-black uppercase text-navy tracking-widest italic bg-gray-50/50">Time</th>
                                <th class="py-3 px-4 text-[10px] font-black uppercase text-navy tracking-widest italic bg-gray-50/50 last:rounded-tr-xl last:rounded-br-xl">Location</th>
                            </tr>
                        </thead>
                        <tbody id="modalSessions" class="text-sm font-bold text-navy italic">
                            <!-- Sessions injected here -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('classModal');
    const modalBackdrop = document.getElementById('modalBackdrop');
    const modalContent = document.getElementById('modalContent');
    const cards = document.querySelectorAll('.timetable-card');
    const closeBtn = document.getElementById('closeModal');

    // Select modal elements to populate
    const modalTitle = document.getElementById('modalTitle');
    const modalInstructor = document.getElementById('modalInstructor');
    const modalDescription = document.getElementById('modalDescription');
    const modalSessions = document.getElementById('modalSessions');
    const modalImage = document.getElementById('modalImage');

    const openModal = (info, sessions) => {
        // Populate modal info
        modalTitle.textContent = info.title;
        modalInstructor.textContent = info.instructor;
        modalDescription.textContent = info.full_desc;
        
        if (info.image && info.image !== 'assets/images/placeholder-class.jpg') {
            modalImage.src = info.image;
            modalImage.style.display = 'block';
        } else {
             // Fallback if generic placeholder (optional: or a default banner)
             modalImage.src = ''; 
             modalImage.style.display = 'none'; // Or show a default pattern
        }
        
        /* Force show for now if we have a path */
        if (info.image) {
             modalImage.src = info.image;
             modalImage.style.display = 'block';
        }

        // Populate sessions table
        modalSessions.innerHTML = '';
        if (sessions.length > 0) {
            sessions.forEach(session => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-50 hover:bg-blue-50/50 transition-colors';
                row.innerHTML = `
                    <td class="py-4 px-4 text-blue-600">${session.day}</td>
                    <td class="py-4 px-4 text-navy">${session.time}</td>
                    <td class="py-4 px-4 text-gray-700">${session.location}</td>
                `;
                modalSessions.appendChild(row);
            });
        } else {
            modalSessions.innerHTML = '<tr><td colspan="3" class="py-4 text-center text-gray-400 text-xs">No active sessions found.</td></tr>';
        }

        // Show modal with animation
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalBackdrop.classList.remove('opacity-0');
            modalBackdrop.classList.add('opacity-100');
            modalContent.classList.remove('scale-90', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        modalBackdrop.classList.remove('opacity-100');
        modalBackdrop.classList.add('opacity-0');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-90', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 500);
    };

    cards.forEach(card => {
        card.addEventListener('click', () => {
            try {
                const info = JSON.parse(card.getAttribute('data-info'));
                const sessions = JSON.parse(card.getAttribute('data-sessions'));
                openModal(info, sessions);
            } catch (e) {
                console.error("Error parsing class data", e);
            }
        });
    });

    closeBtn.addEventListener('click', closeModal);
    modalBackdrop.addEventListener('click', closeModal);
</script>

<?php include 'includes/public_footer.php'; ?>
