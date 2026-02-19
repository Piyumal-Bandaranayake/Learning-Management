<?php
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

$db = getDBConnection();
$msg = "";

// Delete Logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Get file path to delete from server
    $stmt = $db->prepare("SELECT image FROM banners WHERE id = ?");
    $stmt->execute([$id]);
    $banner = $stmt->fetch();
    
    if ($banner) {
        if (file_exists("../" . $banner['image'])) unlink("../" . $banner['image']);
        
        $stmt = $db->prepare("DELETE FROM banners WHERE id = ?");
        $stmt->execute([$id]);
        $msg = "Banner deleted successfully!";
    }
}

// Fetch all banners
$stmt = $db->query("SELECT * FROM banners ORDER BY display_order ASC, created_at DESC");
$banners = $stmt->fetchAll();

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';
?>

<div class="max-w-7xl mx-auto">
    <?php if ($msg): ?>
        <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl">
            <p class="text-sm font-bold"><?php echo $msg; ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex flex-col md:flex-row items-center justify-between gap-4">
            <h2 class="text-xl font-black text-navy uppercase tracking-tight shrink-0">Banner Gallery</h2>
            
            <div class="flex flex-1 items-center gap-4 w-full md:max-w-xl">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                    <input type="text" id="adminSearchInput" placeholder="Search banners by order or date..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50/50 focus:outline-none focus:ring-4 focus:ring-navy/5 focus:border-navy transition-all text-xs font-bold">
                </div>
                <a href="add-banner.php" class="bg-navy text-white px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-navy-dark transition-all flex items-center gap-2 shrink-0">
                    <i data-lucide="plus" class="w-4 h-4"></i> Add Banner
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Preview</th>
                        <th class="px-8 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Order</th>
                        <th class="px-8 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if (empty($banners)): ?>
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center opacity-20">
                                    <i data-lucide="image" class="w-16 h-16 mb-4"></i>
                                    <p class="font-black uppercase tracking-widest text-xs">No banners found</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: foreach ($banners as $banner): ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <img src="../<?php echo $banner['image']; ?>" alt="Banner" class="w-32 h-20 rounded-2xl object-cover shadow-sm border border-gray-100">
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-600"><?php echo $banner['display_order']; ?></td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <a href="manage-banners.php?delete=<?php echo $banner['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this banner?')"
                                       class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
