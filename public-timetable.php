<?php 
require_once 'config/database.php';
$db = getDBConnection();

// Fetch timetable entries grouped by day
$timetable_query = $db->query("SELECT * FROM timetable ORDER BY FIELD(day_name, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), class_time ASC");
$timetable_entries = $timetable_query->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

include 'includes/public_header.php'; 
?>

<!-- Timetable Hero Section -->
<header class="relative bg-navy py-24 overflow-hidden border-none shadow-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-5xl lg:text-6xl font-black text-white mb-6 italic tracking-tight uppercase">Weekly Schedule</h1>
        <p class="text-xl text-blue-100/70 max-w-2xl leading-relaxed italic font-medium mx-auto">
            Your comprehensive roadmap to academic excellence. Find your class and join the session.
        </p>
    </div>
    
    <!-- Background Glow -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
</header>

<section class="py-24 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <?php if (empty($timetable_entries)): ?>
            <div class="py-32 bg-white rounded-[3rem] shadow-xl shadow-navy/5 border border-gray-100 text-center">
                <div class="w-24 h-24 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="calendar-x" class="text-gray-300 w-12 h-12"></i>
                </div>
                <h3 class="text-2xl font-black text-navy italic uppercase">Schedule Coming Soon</h3>
                <p class="text-gray-400 font-bold italic mt-2">Our academic team is currently preparing the next weekly plan.</p>
            </div>
        <?php else: ?>
            <div class="space-y-20">
                <?php foreach ($timetable_entries as $day => $classes): ?>
                    <div class="space-y-8">
                        <div class="flex items-center gap-6">
                            <h2 class="text-3xl font-black text-navy italic uppercase tracking-tighter truncate"><?php echo $day; ?></h2>
                            <div class="h-px flex-1 bg-gradient-to-r from-navy/10 to-transparent"></div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                            <?php foreach ($classes as $class): ?>
                                <div class="timetable-card bg-white rounded-[3rem] border border-gray-100 shadow-xl shadow-navy/5 overflow-hidden group hover:border-navy/20 transition-all duration-500 cursor-pointer"
                                     data-name="<?php echo htmlspecialchars($class['class_name']); ?>"
                                     data-time="<?php echo htmlspecialchars($class['class_time']); ?>"
                                     data-description="<?php echo htmlspecialchars($class['class_description'] ?? 'No description available for this class.'); ?>"
                                     data-day="<?php echo htmlspecialchars($day); ?>"
                                     data-image="<?php echo htmlspecialchars($class['class_image']); ?>">
                                    
                                    <div class="relative h-56 overflow-hidden">
                                        <img src="<?php echo htmlspecialchars($class['class_image']); ?>" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                                             alt="<?php echo htmlspecialchars($class['class_name']); ?>">
                                        
                                        <div class="absolute inset-0 bg-navy/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="text-white text-[10px] font-black uppercase tracking-widest italic bg-navy/60 backdrop-blur-md px-4 py-2 rounded-full">View Details</span>
                                        </div>

                                        <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-xl flex items-center gap-2">
                                            <i data-lucide="clock" class="w-3 h-3 text-navy"></i>
                                            <span class="text-[10px] font-black uppercase text-navy italic"><?php echo htmlspecialchars($class['class_time']); ?></span>
                                        </div>
                                    </div>

                                    <div class="p-8">
                                        <h3 class="text-xl font-black text-navy italic mb-4 line-clamp-1 group-hover:text-blue-500 transition-colors">
                                            <?php echo htmlspecialchars($class['class_name']); ?>
                                        </h3>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex -space-x-2">
                                                <div class="w-8 h-8 rounded-full border-2 border-white bg-navy flex items-center justify-center text-[10px] font-black text-white">L</div>
                                                <div class="w-8 h-8 rounded-full border-2 border-white bg-blue-500 flex items-center justify-center text-[10px] font-black text-white">M</div>
                                            </div>
                                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic tracking-tighter">Joined Class</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
    
    <div id="modalContent" class="relative bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl overflow-hidden transform scale-90 opacity-0 transition-all duration-500">
        <!-- Modal Header -->
        <div class="relative h-60">
            <img id="modalImage" src="" class="w-full h-full object-cover" alt="Class">
            <div class="absolute inset-0 bg-gradient-to-t from-white via-navy/20 to-transparent"></div>
            
            <button id="closeModal" class="absolute top-4 right-4 bg-black/20 backdrop-blur-md hover:bg-black/40 text-white p-2.5 rounded-xl transition-all group active:scale-90">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <div class="absolute bottom-6 left-8">
                <div id="modalDay" class="bg-navy text-white text-[9px] font-black uppercase italic tracking-widest px-3 py-1.5 rounded-lg inline-block mb-2 shadow-lg">DAY</div>
                <h2 id="modalName" class="text-3xl font-black text-navy italic uppercase tracking-tighter">Class Name</h2>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-8">
            <div class="grid grid-cols-1 gap-4 mb-8">
                <div class="bg-gray-50/50 p-5 rounded-2xl border border-gray-100">
                    <div class="flex items-center gap-2 text-blue-500 mb-1">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span class="text-[9px] font-black uppercase tracking-widest">Starts At</span>
                    </div>
                    <p id="modalTime" class="text-sm font-black text-navy italic">Loading...</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h4 class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] italic mb-3 ml-1">Class Description</h4>
                    <p id="modalDescription" class="text-sm font-medium text-gray-600 italic leading-relaxed"></p>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center text-green-600">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none">Status</p>
                            <p class="text-xs font-black text-navy italic mt-1">Confirmed</p>
                        </div>
                    </div>
                    <button class="bg-navy text-white px-8 py-4 rounded-xl font-black uppercase italic tracking-widest text-[10px] hover:bg-navy-light transition-all shadow-xl shadow-navy/20 active:scale-95">Book Seat Now</button>
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
    const modalImage = document.getElementById('modalImage');
    const modalName = document.getElementById('modalName');
    const modalTime = document.getElementById('modalTime');
    const modalDay = document.getElementById('modalDay');
    const modalDescription = document.getElementById('modalDescription');

    const openModal = (data) => {
        // Populate modal
        modalImage.src = data.image;
        modalName.textContent = data.name;
        modalTime.textContent = data.time;
        modalDay.textContent = data.day;
        modalDescription.textContent = data.description;

        // Show modal with animation
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Use a small timeout to trigger CSS transitions
        setTimeout(() => {
            modalBackdrop.classList.remove('opacity-0');
            modalBackdrop.classList.add('opacity-100');
            modalContent.classList.remove('scale-90', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden'; // Prevent scrolling
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
        }, 500); // Match transition duration
    };

    cards.forEach(card => {
        card.addEventListener('click', () => {
            const data = {
                name: card.getAttribute('data-name'),
                time: card.getAttribute('data-time'),
                description: card.getAttribute('data-description'),
                day: card.getAttribute('data-day'),
                image: card.getAttribute('data-image')
            };
            openModal(data);
        });
    });

    closeBtn.addEventListener('click', closeModal);
    modalBackdrop.addEventListener('click', closeModal);
</script>

<?php include 'includes/public_footer.php'; ?>
