<!-- Premium Sidebar -->
<aside id="sidebar" style="font-family: 'Outfit', sans-serif;" class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 sidebar-transition z-40 w-72 bg-navy min-h-screen flex flex-col border-r border-white/10 pt-10 shadow-2xl">
    
    <!-- Sidebar Logo -->
    <a href="/Learning-Mangment/index.php" class="px-8 pb-10 flex items-center gap-4 group/logo">
        <div class="relative w-12 h-12 bg-white/10 rounded-2xl border border-white/10 shadow-2xl flex flex-col items-center justify-center overflow-hidden backdrop-blur-md transition-all duration-300 group-hover/logo:bg-white/20">
            <!-- Graduation Cap (Top Part) -->
            <div class="relative z-20 mb-[-4px] transition-transform duration-500 group-hover/logo:-translate-y-1">
                <i data-lucide="graduation-cap" class="w-7 h-7 text-white drop-shadow-md"></i>
            </div>
            
            <!-- 3D Pedestal Blocks (Bottom Part) -->
            <div class="relative z-10 flex flex-col items-center gap-[1px]">
                <div class="flex gap-[1px]">
                    <div class="w-2.5 h-2.5 bg-[#4CAF50] rounded-[1px] shadow-sm"></div>
                    <div class="w-2.5 h-2.5 bg-[#2196F3] rounded-[1px] shadow-sm"></div>
                </div>
                <div class="w-2.5 h-2.5 bg-[#FF9800] rounded-[1px] shadow-sm"></div>
            </div>
        </div>
        
        <div class="flex flex-col">
            <span class="text-2xl font-black text-white tracking-tighter uppercase leading-none mb-1">
                GUIDEWAY
            </span>
            <div class="bg-[#E31E24] px-1.5 py-0.5 rounded-sm">
                <span class="text-[8px] font-black text-white tracking-[0.2em] uppercase whitespace-nowrap">
                    Learning Network
                </span>
            </div>
        </div>
    </a>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 space-y-1">
        <?php 
        $current_page = basename($_SERVER['PHP_SELF']);
        $nav_items = [
            ['dashboard.php', 'layout-dashboard', 'Dashboard'],
            ['public-timetable.php', 'calendar', 'Timetable'],
            ['courses.php', 'book-open', 'All Courses'],
            ['my-registrations.php', 'file-check', 'My Registrations']
        ];

        foreach ($nav_items as $item):
            $is_active = ($current_page == $item[0]);
        ?>
            <a href="/Learning-Mangment/<?php echo ($item[0] === 'dashboard.php') ? 'student/' : ''; ?><?php echo $item[0]; ?>" 
               class="flex items-center gap-4 px-6 py-4 rounded-[2rem] transition-all duration-300 group <?php echo $is_active ? 'bg-white text-navy shadow-xl shadow-black/10' : 'text-blue-200/70 hover:bg-white hover:text-navy hover:shadow-xl hover:shadow-black/10'; ?>">
                <i data-lucide="<?php echo $item[1]; ?>" class="w-5 h-5 transition-colors <?php echo $is_active ? 'text-navy' : 'group-hover:text-navy'; ?>"></i>
                <span class="text-sm font-black"><?php echo $item[2]; ?></span>
            </a>
        <?php endforeach; ?>

        <!-- Extra Actions -->
        <hr class="mx-6 my-4 border-white/5">
        
        <a href="/Learning-Mangment/auth/logout.php" class="flex items-center gap-4 px-6 py-4 rounded-[2rem] transition-all duration-300 text-red-400/80 hover:bg-red-500 hover:text-white hover:shadow-xl hover:shadow-red-500/20 group mt-auto">
            <i data-lucide="log-out" class="w-5 h-5 transition-colors group-hover:text-white"></i>
            <span class="text-sm font-black">Sign Out</span>
        </a>
    </nav>

    <!-- Profile Section -->
    <div class="p-6 mt-auto border-t border-white/10">
        <div class="flex items-center gap-4 group cursor-pointer">
            <div class="flex flex-col flex-1 min-w-0">
                <span class="text-xs font-black uppercase text-white truncate tracking-tighter">
                    <?php echo htmlspecialchars($_SESSION['name'] ?? 'Guest'); ?>
                </span>
            </div>
            <div class="w-10 h-10 bg-white text-navy rounded-full flex items-center justify-center font-black text-xs shadow-lg group-hover:scale-110 transition-transform flex-shrink-0">
                <?php 
                $words = explode(' ', $_SESSION['name'] ?? 'U');
                $initials = (count($words) > 1) ? $words[0][0].$words[1][0] : $words[0][0];
                echo strtoupper($initials);
                ?>
            </div>
            <i data-lucide="chevron-up" class="w-4 h-4 text-blue-300/40"></i>
        </div>
    </div>
</aside>

<!-- Main Content Area Wrapper -->
<main class="flex-1 p-4 md:p-8 overflow-y-auto">
