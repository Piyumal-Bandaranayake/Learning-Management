    </main>
</div> <!-- End flex-1 wrapper -->
</div> <!-- End min-h-screen Flex -->

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true
    });

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

    // Profile Dropdown Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const profileBtn = document.getElementById('profileDropdownBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isHidden = profileDropdown.classList.contains('hidden');
                
                if (isHidden) {
                    profileDropdown.classList.remove('hidden');
                    // Small timeout to trigger transition
                    setTimeout(() => {
                        profileDropdown.classList.remove('opacity-0', 'translate-y-2', 'scale-95');
                        profileDropdown.classList.add('opacity-100', 'translate-y-0', 'scale-100');
                    }, 10);
                } else {
                    closeProfileDropdown();
                }
            });

            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
                    closeProfileDropdown();
                }
            });

            function closeProfileDropdown() {
                profileDropdown.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
                profileDropdown.classList.add('opacity-0', 'translate-y-2', 'scale-95');
                setTimeout(() => {
                    profileDropdown.classList.add('hidden');
                }, 200);
            }
        }

        // Universal Table Search Logic
        const searchInput = document.getElementById('adminSearchInput');
        
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                const tables = document.querySelectorAll('table');
                
                tables.forEach(table => {
                    const tableBody = table.querySelector('tbody');
                    if (!tableBody) return;

                    const rows = Array.from(tableBody.querySelectorAll('tr:not(.no-results-row)'));
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const text = row.innerText.toLowerCase();
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Handle "No Results" Message
                    let noResultsRow = tableBody.querySelector('.no-results-row');
                    if (visibleCount === 0 && searchTerm !== '') {
                        if (!noResultsRow) {
                            noResultsRow = document.createElement('tr');
                            noResultsRow.className = 'no-results-row';
                            const colCount = table.querySelectorAll('thead th, thead td').length || 10;
                            noResultsRow.innerHTML = `
                                <td colspan="${colCount}" class="py-20 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
                                            <i data-lucide="search-x" class="w-8 h-8 opacity-20"></i>
                                        </div>
                                        <p class="font-black uppercase tracking-[0.2em] text-[10px]">No matching records found</p>
                                        <p class="text-[9px] mt-1 font-bold">Try adjusting your search terms</p>
                                    </div>
                                </td>
                            `;
                            tableBody.appendChild(noResultsRow);
                            lucide.createIcons();
                        }
                    } else if (noResultsRow) {
                        noResultsRow.remove();
                    }
                });
            });

            // Prevent form submission if it's just a filter input
            const parentForm = searchInput.closest('form');
            if (parentForm && !parentForm.getAttribute('action')) {
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                    }
                });
            }
        }
    });
</script>
</body>
</html>
