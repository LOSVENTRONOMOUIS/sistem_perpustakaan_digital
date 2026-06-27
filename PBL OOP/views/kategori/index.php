<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Buku - Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="text-slate-800 antialiased bg-slate-50 overflow-x-hidden">

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity opacity-0"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-72 bg-white shadow-xl z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
        
        <!-- Sidebar Header -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100">
            <h4 class="text-xl font-bold text-blue-600 flex items-center gap-2">
                <i class="bi bi-book-half"></i> Digital Library
            </h4>
            <button id="closeSidebarBtn" class="lg:hidden text-slate-400 hover:text-red-500 text-2xl transition-colors">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- Sidebar User Profile -->
        <div class="flex flex-col items-center justify-center py-8">
            <div class="w-24 h-24 rounded-full bg-blue-50 p-2 mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" alt="Admin" class="w-full h-full object-cover">
            </div>
            <h5 class="font-bold text-lg text-slate-800">Administrator</h5>
            <span class="text-sm text-slate-500">Admin Perpustakaan</span>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-1 px-4 overflow-y-auto space-y-2">
            <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">
                <i class="bi bi-grid-fill text-lg"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="buku.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">
                <i class="bi bi-book-fill text-lg"></i>
                <span class="font-medium">Kelola Buku</span>
            </a>
            <a href="anggota.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">
                <i class="bi bi-people-fill text-lg"></i>
                <span class="font-medium">Data Anggota</span>
            </a>
            <a href="peminjaman.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">
                <i class="bi bi-journal-check text-lg"></i>
                <span class="font-medium">Peminjaman</span>
            </a>
            <a href="kategori.php" class="flex items-center gap-3 px-4 py-3 bg-blue-600 text-white rounded-xl shadow-md shadow-blue-200 transition-all">
                <i class="bi bi-tags-fill text-lg"></i>
                <span class="font-medium">Kategori Buku</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-100">
            <a href="logout.php" class="flex items-center justify-center gap-2 w-full py-3 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-xl transition-all font-medium">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="lg:ml-72 transition-all duration-300 min-h-screen flex flex-col">
        
        <!-- Navbar -->
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-6 lg:px-10 z-30 sticky top-0 rounded-b-3xl">
            <div class="flex items-center gap-4">
                <button id="openSidebarBtn" class="lg:hidden text-slate-600 hover:text-blue-600 bg-slate-50 p-2 rounded-lg transition-colors">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <h4 class="text-xl font-bold text-slate-800 hidden sm:block">Kategori Buku</h4>
            </div>

            <div class="flex items-center gap-5">
                <button class="relative text-slate-500 hover:text-blue-600 transition-colors">
                    <i class="bi bi-bell text-xl"></i>
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <a href="#" class="block w-10 h-10 rounded-full overflow-hidden border-2 border-slate-100 hover:border-blue-300 transition-colors">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile" class="w-full h-full object-cover">
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6 lg:p-10">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-800">Manajemen Kategori</h1>
                <p class="text-slate-500 mt-1 text-base">Kelola kategori buku perpustakaan</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-slate-50">
                    <div class="w-16 h-16 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-purple-200">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-800"><?= isset($totalKategori) ? $totalKategori : 0 ?></h2>
                    <p class="text-slate-500 mt-1 text-base">Total Kategori</p>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-50">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <h4 class="text-xl font-bold text-slate-800 m-0">Data Kategori</h4>
                    <button onclick="openModal('modalTambah')" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md transition-colors">
                        <i class="bi bi-plus-circle text-lg"></i> Tambah Kategori
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-500">
                                <th class="pb-4 font-semibold w-16">No</th>
                                <th class="pb-4 font-semibold px-4">Nama Kategori</th>
                                <th class="pb-4 font-semibold pl-4 w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php if(!empty($kategori)){ $no=1; foreach($kategori as $k){ ?>
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="py-4 text-slate-600 font-medium"><?= $no++ ?></td>
                                <td class="py-4 px-4 text-slate-800 font-semibold text-lg"><?= htmlspecialchars($k['nama_kategori']) ?></td>
                                <td class="py-4 pl-4">
                                    <div class="flex items-center gap-2">
                                        <button onclick="openModal('edit<?= $k['id'] ?>')" class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-500 hover:text-white flex items-center justify-center transition-colors" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <a href="hapus_kategori.php?id=<?= $k['id'] ?>" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors" onclick="return confirm('Yakin ingin hapus kategori ini?')" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php }} else { ?>
                            <tr>
                                <td colspan="3" class="text-center text-slate-500 py-12 text-lg">
                                    <i class="bi bi-inbox text-4xl mb-3 block text-slate-300"></i>
                                    Data kategori belum ada
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL TAMBAH -->
    <div id="modalTambah" class="fixed inset-0 z-[60] hidden flex-col items-center justify-center p-4 sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0" onclick="closeModal('modalTambah')"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-3xl shadow-xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h5 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-tags text-blue-600"></i> Tambah Kategori
                </h5>
                <button onclick="closeModal('modalTambah')" class="text-slate-400 hover:text-red-500 text-xl transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            
            <form action="store_kategori.php" method="POST">
                <div class="p-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700" placeholder="Masukkan nama kategori" required>
                </div>
                
                <div class="px-6 py-5 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('modalTambah')" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-md transition-colors">Tambah Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT LOOP -->
    <?php if(!empty($kategori)){ foreach($kategori as $k){ ?>
    <div id="edit<?= $k['id'] ?>" class="fixed inset-0 z-[60] hidden flex-col items-center justify-center p-4 sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0" onclick="closeModal('edit<?= $k['id'] ?>')"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-3xl shadow-xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h5 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-pencil-square text-yellow-500"></i> Edit Kategori
                </h5>
                <button onclick="closeModal('edit<?= $k['id'] ?>')" class="text-slate-400 hover:text-red-500 text-xl transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            
            <form action="update_kategori.php" method="POST">
                <div class="p-6 space-y-4">
                    <input type="hidden" name="id" value="<?= $k['id'] ?>">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori</label>
                        <input type="text" name="nama_kategori" value="<?= htmlspecialchars($k['nama_kategori']) ?>" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700" required>
                    </div>
                </div>
                
                <div class="px-6 py-5 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('edit<?= $k['id'] ?>')" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 shadow-md transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <?php }} ?>

    <!-- Scripts -->
    <script>
        // Sidebar Script
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            document.body.classList.add('overflow-hidden'); 
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
            document.body.classList.remove('overflow-hidden');
        }

        openBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Modal Scripts
        function openModal(id) {
            const modal = document.getElementById(id);
            const backdrop = modal.querySelector('.fixed.inset-0.bg-slate-900\\/50');
            const content = modal.querySelector('.relative.bg-white');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
            
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            const backdrop = modal.querySelector('.fixed.inset-0.bg-slate-900\\/50');
            const content = modal.querySelector('.relative.bg-white');
            
            backdrop.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                
                // Cek jika sidebar overlay aktif, jangan remove body overflow-hidden
                if(overlay.classList.contains('hidden')) {
                    document.body.classList.remove('overflow-hidden');
                }
            }, 300);
        }
    </script>
</body>
</html>