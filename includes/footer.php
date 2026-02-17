</main> <!-- End Main Content -->
</div> <!-- End Sidebar Flexbox -->

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Sidebar logic
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar.CourseList.contains('-translate-x-full')) {
                sidebar.CourseList.remove('-translate-x-full');
                overlay.CourseList.remove('hidden');
            } else {
                sidebar.CourseList.add('-translate-x-full');
                overlay.CourseList.add('hidden');
            }
        }
    </script>
</body>
</html>
