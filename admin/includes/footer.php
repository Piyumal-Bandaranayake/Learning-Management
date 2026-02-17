    </main>
</div> <!-- End flex-1 wrapper -->
</div> <!-- End min-h-screen Flex -->

<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Sidebar Toggle
    function toggleAdminSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('admin-overlay');
        
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
