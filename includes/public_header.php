<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Professional Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        .nav-link { position: relative; transition: color 0.3s ease; }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: currentColor;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.03); }

        /* Floating Navbar Styles */
        #main-nav {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .navbar-scrolled {
            margin-top: 1rem;
            margin-left: 1rem;
            margin-right: 1rem;
            border-radius: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .nav-text-dark {
            color: #0B3C5D !important;
        }

        /* Background Animations */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Gradient Utilities */
        .bg-theme-gradient {
            background: linear-gradient(135deg, #0B3C5D 0%, #1d4e6f 50%, #082d46 100%);
        }
        .text-gradient {
            background: linear-gradient(to right, #60A5FA, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#0B3C5D',
                            light: '#1d4e6f',
                            dark: '#082d46',
                        },
                        accent: {
                            blue: '#4CAF50',
                            green: '#2196F3',
                            orange: '#FF9800'
                        }
                    },
                    backgroundImage: {
                        'gradient-navy': 'linear-gradient(135deg, #0B3C5D 0%, #1d4e6f 50%, #082d46 100%)',
                        'gradient-mesh': 'radial-gradient(at 0% 0%, rgba(29, 78, 216, 0.15) 0, transparent 50%), radial-gradient(at 50% 0%, rgba(30, 64, 175, 0.15) 0, transparent 50%), radial-gradient(at 100% 0%, rgba(37, 99, 235, 0.15) 0, transparent 50%)',
                    }
                }
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100,
                easing: 'ease-out-cubic'
            });
        });

        window.addEventListener('scroll', () => {
            const nav = document.getElementById('main-nav');
            const navLinks = document.querySelectorAll('.nav-link, #nav-logo-text, #nav-profile-name, #mobile-menu-btn');
            const navLogoIcon = document.getElementById('nav-logo-icon');
            const profileButton = document.querySelector('#main-nav .group > button');
            const profileChevron = document.querySelector('#main-nav .group > button i[data-lucide="chevron-down"]');
            const loginBtn = document.getElementById('nav-login-btn');
            const registerBtn = document.getElementById('nav-register-btn');
            const separator = document.querySelector('#main-nav .h-6.w-px');
            
            if (window.scrollY > 50) {
                nav.classList.add('navbar-scrolled');
                nav.classList.remove('bg-navy');
                navLinks.forEach(link => link.classList.add('nav-text-dark'));
                if (navLogoIcon) {
                    navLogoIcon.classList.remove('bg-white/10', 'border-white/10');
                    navLogoIcon.classList.add('bg-navy', 'border-navy');
                }
                if (profileButton) {
                    profileButton.classList.remove('bg-white/5', 'hover:bg-white/10', 'border-white/5');
                    profileButton.classList.add('bg-gray-50', 'hover:bg-gray-100', 'border-gray-100');
                }
                if (profileChevron) {
                    profileChevron.classList.remove('text-white/50');
                    profileChevron.classList.add('text-navy');
                }
                if (loginBtn) {
                    loginBtn.classList.remove('bg-white', 'text-navy', 'shadow-black/20');
                    loginBtn.classList.add('bg-navy', 'text-white', 'shadow-navy/20');
                }
                if (registerBtn) {
                    registerBtn.classList.remove('border-white/20', 'text-white');
                    registerBtn.classList.add('border-navy/10', 'text-navy');
                }
                if (separator) {
                    separator.classList.remove('bg-white/10');
                    separator.classList.add('bg-gray-200');
                }
            } else {
                nav.classList.remove('navbar-scrolled');
                nav.classList.add('bg-navy');
                navLinks.forEach(link => link.classList.remove('nav-text-dark'));
                if (navLogoIcon) {
                    navLogoIcon.classList.remove('bg-navy', 'border-navy');
                    navLogoIcon.classList.add('bg-white/10', 'border-white/10');
                }
                if (profileButton) {
                    profileButton.classList.remove('bg-gray-50', 'hover:bg-gray-100', 'border-gray-100');
                    profileButton.classList.add('bg-white/5', 'hover:bg-white/10', 'border-white/5');
                }
                if (profileChevron) {
                    profileChevron.classList.remove('text-navy');
                    profileChevron.classList.add('text-white/50');
                }
                if (loginBtn) {
                    loginBtn.classList.remove('bg-navy', 'text-white', 'shadow-navy/20');
                    loginBtn.classList.add('bg-white', 'text-navy', 'shadow-black/20');
                }
                if (registerBtn) {
                    registerBtn.classList.remove('border-navy/10', 'text-navy');
                    registerBtn.classList.add('border-white/20', 'text-white');
                }
                if (separator) {
                    separator.classList.remove('bg-gray-200');
                    separator.classList.add('bg-white/10');
                }
            }
        });
    </script>
</head>
<body class="bg-white text-gray-800">

    <!-- Public Navbar -->
    <nav id="main-nav" class="sticky top-0 z-50 bg-navy border-none shadow-none">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="index.php" class="flex items-center gap-4 group/logo">
                    <div id="nav-logo-icon" class="relative w-12 h-12 bg-white/10 rounded-2xl border border-white/10 shadow-2xl flex flex-col items-center justify-center overflow-hidden backdrop-blur-md transition-all duration-300 group-hover/logo:bg-white/20">
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
                        <!-- Main Logo Text with Custom Styling -->
                        <span id="nav-logo-text" class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none mb-1">
                            GUIDEWAY
                        </span>
                        <!-- Red Branding Bar with Subtext -->
                        <div class="bg-[#E31E24] px-2 py-0.5 rounded-sm">
                            <span class="text-[9px] font-black text-white tracking-[0.25em] uppercase whitespace-nowrap">
                                Learning Network
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="index.php" class="nav-link text-white font-semibold">Home</a>
                    <a href="about.php" class="nav-link text-white font-semibold">About</a>
                    <a href="courses.php" class="nav-link text-white font-semibold">Courses</a>
                    <a href="public-timetable.php" class="nav-link text-white font-semibold">Timetable</a>
                    <a href="about.php#contact" class="nav-link text-white font-semibold">Contact Us</a>
                    <div class="h-6 w-px bg-white/10 mx-2"></div>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Logged In Profile -->
                        <div class="relative group">
                            <button class="flex items-center gap-3 p-1.5 bg-white/5 hover:bg-white/10 rounded-2xl transition-all border border-white/5">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['name'] ?? 'U'); ?>&background=0B3C5D&color=FFFFFF" alt="Profile" class="w-8 h-8 rounded-xl shadow-sm">
                                <span id="nav-profile-name" class="text-white font-bold text-sm italic transition-colors"><?php echo explode(' ', $_SESSION['name'])[0]; ?></span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-white/50"></i>
                            </button>
                            
                            <!-- Dropdown -->
                            <div class="absolute right-0 mt-3 w-64 bg-white rounded-[2rem] shadow-2xl border border-gray-100 py-4 hidden group-hover:block transition-all transform origin-top-right z-[100]">
                                <div class="px-6 py-3 border-b border-gray-50 mb-3 text-center">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Authenticated Account</p>
                                    <p class="text-sm font-black text-navy italic"><?php echo htmlspecialchars($_SESSION['name']); ?></p>
                                </div>
                                
                                <a href="<?php echo ($_SESSION['role'] === 'admin') ? 'admin/dashboard.php' : 'dashboard.php'; ?>" class="flex items-center gap-4 px-6 py-3 text-sm text-gray-600 hover:bg-navy/5 hover:text-navy transition-colors font-bold italic">
                                    <div class="bg-navy/5 p-2 rounded-xl group-hover:bg-navy/10 transition-colors">
                                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                    </div>
                                    <span>My Dashboard</span>
                                </a>
                                
                                <hr class="my-3 border-gray-50 mx-6">
                                
                                <a href="/Learning-Mangment/auth/logout.php" class="flex items-center gap-4 px-6 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors font-bold italic">
                                    <div class="bg-red-50 p-2 rounded-xl">
                                        <i data-lucide="log-out" class="w-4 h-4"></i>
                                    </div>
                                    <span>Logout Account</span>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Logged Out Actions -->
                        <a href="login.php" id="nav-login-btn" class="bg-white text-navy px-8 py-2.5 rounded-xl font-semibold hover:bg-blue-50 transition-all shadow-xl shadow-black/20 flex items-center justify-center gap-2">
                            Login
                            <i data-lucide="log-in" class="w-4 h-4"></i>
                        </a>
                        <a href="register.php" id="nav-register-btn" class="border-2 border-white/20 text-white px-8 py-2.5 rounded-xl font-semibold hover:bg-white hover:text-navy transition-all flex items-center justify-center">
                            Register
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button onclick="toggleMobileMenu()" class="p-2 text-navy">
                        <i data-lucide="menu" id="menu-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-gray-100 absolute w-full left-0 shadow-xl transition-all">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="index.php" class="block px-4 py-3 text-navy font-bold hover:bg-gray-50 rounded-xl">Home</a>
                <a href="about.php" class="block px-4 py-3 text-navy font-bold hover:bg-gray-50 rounded-xl">About</a>
                <a href="courses.php" class="block px-4 py-3 text-navy font-bold hover:bg-gray-50 rounded-xl">Courses</a>
                <a href="public-timetable.php" class="block px-4 py-3 text-navy font-bold hover:bg-gray-50 rounded-xl">Timetable</a>
                <a href="about.php#contact" class="block px-4 py-3 text-navy font-bold hover:bg-gray-50 rounded-xl">Contact Us</a>
                <hr class="my-4 border-gray-100">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo ($_SESSION['role'] === 'admin') ? 'admin/dashboard.php' : 'dashboard.php'; ?>" class="block px-4 py-3 text-navy font-bold bg-navy/5 rounded-xl">Go to Dashboard</a>
                    <a href="/Learning-Mangment/auth/logout.php" class="block px-4 py-3 text-red-600 font-bold">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="block px-4 py-3 text-navy font-bold">Login</a>
                    <a href="register.php" class="block px-4 py-3 bg-navy text-white text-center font-bold rounded-xl mt-4">Register Now</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
