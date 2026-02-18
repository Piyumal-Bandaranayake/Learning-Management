    <!-- Footer -->
    <footer class="bg-navy text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Branding -->
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="bg-white p-1 rounded-lg text-navy">
                            <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xl font-bold tracking-tight">Guideway<span class="text-blue-400"> Learning Network</span></span>
                    </div>
                    <p class="text-blue-100/70 text-sm leading-relaxed mb-6">
                        Empowering students worldwide through accessible, premium education and a modern learning environment.
                    </p>
                    <div class="flex gap-4">
                        <a href="https://www.facebook.com/guidewayitacademy" target="_blank" class="p-2 bg-navy-light rounded-lg hover:bg-white hover:text-navy transition-all">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-6 italic">Quick Links</h4>
                    <ul class="space-y-4 text-blue-100/70 text-sm">
                        <li><a href="index.php" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="about.php" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="courses.php" class="hover:text-white transition-colors">Course Catalog</a></li>
                        <li><a href="public-timetable.php" class="hover:text-white transition-colors">Timetable</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-lg font-bold mb-6 italic">Support</h4>
                    <ul class="space-y-4 text-blue-100/70 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact Support</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-bold mb-6 italic">Contact Us</h4>
                    <ul class="space-y-4 text-blue-100/70 text-sm">
                        <li class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-5 h-5 text-blue-400"></i>
                            <span>No: 66, Nawammahara, Ragama, Gampaha, Sri Lanka, 11100</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="mail" class="w-5 h-5 text-blue-400"></i>
                            <span>nilankanaw@gmail.com</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="phone" class="w-5 h-5 text-blue-400"></i>
                            <span>077 088 6853</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-navy-light mb-8">
            <div class="text-center text-blue-100/50 text-xs">
                &copy; <?php echo date('Y'); ?> Guideway Learning Network. All rights reserved. Created with <span class="text-red-400">&hearts;</span> for excellence.
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.setAttribute('data-lucide', 'x');
            } else {
                menu.classList.add('hidden');
                icon.setAttribute('data-lucide', 'menu');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>
