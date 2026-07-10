<?php
// =========================
// views/peminjaman/index.php
// =========================
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku - Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        /* Toast notification */
        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .toast {
            padding: 12px 20px;
            border-radius: 12px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            animation: toastIn 0.4s ease, toastOut 0.4s ease 2.6s forwards;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .toast.success { background: linear-gradient(135deg, #10b981, #059669); }
        .toast.error { background: linear-gradient(135deg, #ef4444, #dc2626); }
        @keyframes toastIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes toastOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(120%); opacity: 0; }
        }
        
        /* Denda dropdown styling */
        .denda-select {
            font-size: 12px;
            font-weight: 600;
            padding: 6px 28px 6px 10px;
            border-radius: 8px;
            border: 1.5px solid;
            cursor: pointer;
            transition: all 0.2s ease;
            appearance: none;
            -webkit-appearance: none;
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 12px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='%2364748b' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
        }
        .denda-select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .denda-select.status-pending {
            background-color: #fef3c7;
            border-color: #f59e0b;
            color: #92400e;
        }
        .denda-select.status-lunas {
            background-color: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }
        .denda-select.status-unpaid {
            background-color: #fee2e2;
            border-color: #ef4444;
            color: #991b1b;
        }
        .denda-select:hover {
            filter: brightness(0.95);
        }
        
        /* Saving spinner */
        .saving-spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(0,0,0,0.1);
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin-left: 6px;
            vertical-align: middle;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
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
            <a href="peminjaman.php" class="flex items-center gap-3 px-4 py-3 bg-blue-600 text-white rounded-xl shadow-md shadow-blue-200 transition-all">
                <i class="bi bi-journal-check text-lg"></i>
                <span class="font-medium">Peminjaman</span>
            </a>
            <a href="kategori.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all">
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
                <h4 class="text-xl font-bold text-slate-800 hidden sm:block">Peminjaman Buku</h4>
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
                <h1 class="text-3xl font-bold text-slate-800">Manajemen Peminjaman</h1>
                <p class="text-slate-500 mt-1 text-base">Kelola data peminjaman buku perpustakaan</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-slate-50">
                    <div class="w-16 h-16 rounded-2xl bg-blue-500 text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-blue-200">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-800"><?= isset($totalPinjam) ? $totalPinjam : 0 ?></h2>
                    <p class="text-slate-500 mt-1 text-base">Total Peminjaman</p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-slate-50">
                    <div class="w-16 h-16 rounded-2xl bg-orange-500 text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-orange-200">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-800"><?= isset($totalDipinjam) ? $totalDipinjam : 0 ?></h2>
                    <p class="text-slate-500 mt-1 text-base">Sedang Dipinjam</p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-slate-50">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-emerald-200">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-800"><?= isset($totalKembali) ? $totalKembali : 0 ?></h2>
                    <p class="text-slate-500 mt-1 text-base">Sudah Dikembalikan</p>
                </div>

            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-50">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <h4 class="text-xl font-bold text-slate-800 m-0">Data Peminjaman</h4>
                    <a href="tambah_peminjaman.php" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md transition-colors">
                        <i class="bi bi-plus-circle text-lg"></i> Tambah Peminjaman
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-500">
                                <th class="pb-4 font-semibold px-4">Nama Peminjam</th>
                                <th class="pb-4 font-semibold px-4">Buku</th>
                                <th class="pb-4 font-semibold px-4">Tanggal Pinjam</th>
                                <th class="pb-4 font-semibold px-4">Tanggal Kembali</th>
                                <th class="pb-4 font-semibold px-4">Status</th>
                                <th class="pb-4 font-semibold px-4">Status Denda</th>
                                <th class="pb-4 font-semibold pl-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php if(!empty($data)){ foreach($data as $d){ 
                                // LANGSUNG AMBIL HASIL DARI DATABASE (Lebih akurat 100%)
                                // Jika is_late dari query bernilai 1, berarti dia telat.
                                $isTelat = (isset($d['is_late']) && $d['is_late'] == 1);
                            ?>
                            <tr class="hover:bg-slate-50 transition-colors group <?= $isTelat ? 'bg-red-50/30' : '' ?>">
                                <td class="py-4 px-4 text-slate-800 font-semibold"><?= htmlspecialchars($d['nama']) ?></td>
                                <td class="py-4 px-4 text-slate-600"><?= htmlspecialchars($d['judul']) ?></td>
                                <td class="py-4 px-4 text-slate-600"><?= htmlspecialchars($d['tanggal_pinjam']) ?></td>
                                <td class="py-4 px-4 <?= $isTelat ? 'text-red-600 font-bold' : 'text-slate-600' ?>">
                                    <?= htmlspecialchars($d['tanggal_kembali']) ?>
                                </td>
                                <td class="py-4 px-4">
                                    <?php if($d['status'] == 'dipinjam'){ ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                            Dipinjam
                                        </span>
                                        <?php if($isTelat): ?>
                                            <div class="mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-600 border border-red-200 uppercase tracking-wide">
                                                    Terlambat!
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    <?php } else { ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            Dikembalikan
                                        </span>
                                    <?php } ?>
                                </td>
                                <td class="py-4 px-4">
                                    <?php if($isTelat && !empty($d['denda'])): ?>
                                        <div class="flex items-center gap-1">
                                            <select 
                                                class="denda-select status-<?= $d['denda']['status'] ?>" 
                                                data-denda-id="<?= $d['denda']['id'] ?>"
                                                onchange="updateDendaStatus(this)"
                                            >
                                                <option value="pending" <?= ($d['denda']['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                                                <option value="lunas" <?= ($d['denda']['status'] == 'lunas') ? 'selected' : '' ?>>Lunas</option>
                                                <option value="unpaid" <?= ($d['denda']['status'] == 'unpaid') ? 'selected' : '' ?>>Unpaid</option>
                                            </select>
                                        </div>
                                        <div class="mt-1 text-[10px] text-slate-400">
                                            Rp <?= number_format($d['denda']['jumlah_denda'], 0, ',', '.') ?>
                                        </div>
                                    <?php elseif($isTelat && empty($d['denda'])): ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-red-100 text-red-600 border border-red-200">
                                            <i class="bi bi-exclamation-circle mr-1"></i> Belum dicatat
                                        </span>
                                    <?php else: ?>
                                        <span class="text-slate-300">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 pl-4">
                                    <div class="flex items-center gap-2">
                                        <a href="peminjaman.php?action=edit&id=<?= $d['id'] ?>" class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-500 hover:text-white flex items-center justify-center transition-colors" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="peminjaman.php?action=destroy&id=<?= $d['id'] ?>" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php }} else { ?>
                            <tr>
                                <td colspan="7" class="text-center text-slate-500 py-12 text-lg">
                                    <i class="bi bi-inbox text-4xl mb-3 block text-slate-300"></i>
                                    Data peminjaman belum ada
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- Sidebar Script -->
    <script>
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

        // ========================
        // Toast notification
        // ========================
        function showToast(message, type = 'success') {
            let container = document.querySelector('.toast-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
            }
            const toast = document.createElement('div');
            toast.className = 'toast ' + type;
            const icon = type === 'success' ? '<i class="bi bi-check-circle-fill"></i>' : '<i class="bi bi-x-circle-fill"></i>';
            toast.innerHTML = icon + ' ' + message;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        // ========================
        // Update Denda Status via AJAX
        // ========================
        function updateDendaStatus(selectEl) {
            const dendaId = selectEl.dataset.dendaId;
            const newStatus = selectEl.value;
            
            // Add a small spinner next to dropdown
            let spinner = selectEl.parentElement.querySelector('.saving-spinner');
            if (!spinner) {
                spinner = document.createElement('span');
                spinner.className = 'saving-spinner';
                selectEl.parentElement.appendChild(spinner);
            }
            selectEl.disabled = true;

            const formData = new FormData();
            formData.append('denda_id', dendaId);
            formData.append('status', newStatus);

            fetch('peminjaman.php?action=updateDendaStatus', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast('Status denda berhasil diperbarui!', 'success');
                    
                    // Update dropdown color classes
                    selectEl.className = 'denda-select status-' + newStatus;
                } else {
                    showToast(data.message || 'Gagal memperbarui status', 'error');
                }
            })
            .catch(() => {
                showToast('Terjadi kesalahan jaringan', 'error');
            })
            .finally(() => {
                selectEl.disabled = false;
                if (spinner) spinner.remove();
            });
        }
    </script>
</body>
</html>