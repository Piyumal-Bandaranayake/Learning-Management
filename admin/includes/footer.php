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
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }
</script>
</body>
</html>
