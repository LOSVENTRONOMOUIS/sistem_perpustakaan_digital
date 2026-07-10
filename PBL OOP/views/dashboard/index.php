<?php
// Letakkan logika PHP Anda di sini
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fe;
        }
    </style>
</head>

<body class="text-slate-800 antialiased overflow-x-hidden">

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
            <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 bg-blue-600 text-white rounded-xl shadow-md shadow-blue-200 transition-all">
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
    <div id="mainWrapper" class="lg:ml-72 transition-all duration-300 min-h-screen flex flex-col">
        
        <!-- Navbar -->
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-6 lg:px-10 z-30 sticky top-0 rounded-b-3xl">
            <div class="flex items-center gap-4">
                <button id="openSidebarBtn" class="lg:hidden text-slate-600 hover:text-blue-600 bg-slate-50 p-2 rounded-lg transition-colors">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <h4 class="text-xl font-bold text-slate-800 hidden sm:block">Dashboard Perpustakaan</h4>
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
            
            <!-- Welcome Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-800">Welcome Back,</h1>
                <p class="text-slate-500 mt-1">Sistem Perpustakaan Digital Modern</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                
                <!-- Stat Card 1 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-slate-50">
                    <div class="w-16 h-16 rounded-2xl bg-blue-500 text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-blue-200">
                        <i class="bi bi-book-fill"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-800"><?= isset($totalBuku) ? $totalBuku : 0 ?></h2>
                    <p class="text-slate-500 mt-1">Total Buku</p>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-slate-50">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-emerald-200">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-800"><?= isset($totalAnggota) ? $totalAnggota : 0 ?></h2>
                    <p class="text-slate-500 mt-1">Total Anggota</p>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-slate-50">
                    <div class="w-16 h-16 rounded-2xl bg-orange-500 text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-orange-200">
                        <i class="bi bi-journal-check"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-800"><?= isset($totalPeminjaman) ? $totalPeminjaman : 0 ?></h2>
                    <p class="text-slate-500 mt-1">Peminjaman Aktif</p>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-slate-50">
                    <div class="w-16 h-16 rounded-2xl bg-purple-500 text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-purple-200">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-800"><?= isset($totalKategori) ? $totalKategori : 0 ?></h2>
                    <p class="text-slate-500 mt-1">Kategori Buku</p>
                </div>

                <!-- Stat Card 5 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-slate-50">
                    <div class="w-16 h-16 rounded-2xl bg-red-500 text-white flex items-center justify-center text-3xl mb-4 shadow-lg shadow-red-200">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800">Rp <?= isset($totalPendapatanDenda) ? number_format($totalPendapatanDenda, 0, ',', '.') : 0 ?></h2>
                    <p class="text-slate-500 mt-1">Pendapatan Denda</p>
                </div>
                <!-- Stat Card 6 (Chart) -->
                <div class="lg:col-span-3 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-50">
                    <h4 class="text-xl font-bold text-slate-800 mb-6">
                        Grafik Pendapatan Denda
                    </h4>
                    <div class="w-full h-80">
                        <canvas id="dendaChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Main Sections Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-50 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-xl font-bold text-slate-800">Aktivitas Terbaru</h4>
                    </div>
                    
                    <div class="space-y-5 flex-1">
                        <?php if(!empty($aktivitas)) { foreach($aktivitas as $a){ ?>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div>
                                <h6 class="font-bold text-slate-800"><?= $a['nama'] ?></h6>
                                <p class="text-slate-500 text-sm mt-0.5">
                                    Meminjam buku <strong class="text-slate-700"><?= $a['judul'] ?></strong>
                                </p>
                                <span class="text-xs text-slate-400 mt-1 block"><?= $a['tanggal_pinjam'] ?></span>
                            </div>
                        </div>
                        <?php } } else { echo "<p class='text-slate-500 italic'>Belum ada aktivitas terbaru.</p>"; } ?>
                    </div>
                </div>

                <!-- Quick Menu -->
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-50 flex flex-col h-full">
                    <h4 class="text-xl font-bold text-slate-800 mb-6">Quick Menu</h4>
                    
                    <div class="flex flex-col gap-4 flex-1">
                        <a href="buku.php" class="flex items-center justify-center gap-2 py-4 px-6 border-2 border-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 rounded-2xl transition-all font-semibold">
                            <span>📚</span> Kelola Buku
                        </a>
                        <a href="anggota.php" class="flex items-center justify-center gap-2 py-4 px-6 border-2 border-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 rounded-2xl transition-all font-semibold">
                            <span>👥</span> Data Anggota
                        </a>
                        <a href="peminjaman.php" class="flex items-center justify-center gap-2 py-4 px-6 border-2 border-orange-100 text-orange-600 hover:bg-orange-600 hover:text-white hover:border-orange-600 rounded-2xl transition-all font-semibold">
                            <span>📖</span> Peminjaman Buku
                        </a>
                        <a href="kategori.php" class="flex items-center justify-center gap-2 py-4 px-6 border-2 border-slate-200 text-slate-700 hover:bg-slate-800 hover:text-white hover:border-slate-800 rounded-2xl transition-all font-semibold">
                            <span>📊</span> Kategori Buku
                        </a>
                    </div>
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
            // Small delay to allow display block to apply before opacity transition
            setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            document.body.classList.add('overflow-hidden'); // Prevent scrolling
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300); // Wait for transition
            document.body.classList.remove('overflow-hidden');
        }

        openBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Pie/Doughnut Chart Configuration
        const pieDataRaw = <?= json_encode(isset($statusDenda) ? $statusDenda : []) ?>;
        const pieLabels = pieDataRaw.map(item => item.status.toUpperCase());
        const pieValues = pieDataRaw.map(item => parseInt(item.total));

        // Chart.js Configuration
        const chartData = <?= json_encode(isset($chartDenda) ? $chartDenda : []) ?>;
        const labels = chartData.map(item => item.tanggal);
        const data = chartData.map(item => parseInt(item.total));
        const ctx = document.getElementById('dendaChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.length ? labels : ['Belum ada data'],
                datasets: [{
                    label: 'Pendapatan Denda (Rp)',
                    data: data.length ? data : [0],
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>