<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../public/login.php");
    exit;
}

require_once "../../config/database.php";
$db = new Database();
$conn = $db->getConnection();

$userId = $_SESSION['id'];
$namaUser = $_SESSION['nama'] ?? 'Mahasiswa';
$nimUser = $_SESSION['nim'] ?? '-';
$roleUser = $_SESSION['role'] ?? 'anggota';

// Get current borrowed books
$query = "SELECT p.*, b.judul, b.penulis FROM peminjaman p 
          JOIN buku b ON p.buku_id = b.id 
          WHERE p.anggota_id = :anggota_id AND (p.status = 'dipinjam' OR p.status = 'terlambat')
          ORDER BY p.tanggal_pinjam DESC";
$stmt = $conn->prepare($query);
$stmt->execute(['anggota_id' => $userId]);
$borrowedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalDipinjam = count($borrowedBooks);

$isDesktop = true; // For styling
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile Mahasiswa - Sistem Perpustakaan Digital</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-up { animation: fadeInUp 0.5s ease-out forwards; }
::-webkit-scrollbar { width: 8px; height: 8px; }
::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }
</style>
</head>

<body class="font-['Poppins'] min-h-screen overflow-x-hidden bg-[#f4f7fe] text-[#333] transition-all duration-300">

<!-- Sidebar Overlay -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[1040] opacity-0 invisible transition-all duration-300 lg:hidden" id="sidebarOverlay"></div>

<!-- SIDEBAR -->
<aside class="fixed top-0 left-0 w-[280px] h-screen bg-white shadow-[2px_0_20px_rgba(0,0,0,0.1)] z-[1050] -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col" id="sidebar">
  <div class="p-5 border-b border-[#e9ecef] flex justify-between items-center">
    <h4 class="m-0 text-[1.2rem] font-bold text-blue-600">
      <i class="bi bi-book-half"></i> Digital Library
    </h4>
    <button class="text-2xl cursor-pointer bg-transparent border-none lg:hidden transition-transform hover:rotate-90 text-gray-500 hover:text-blue-600" id="closeSidebarBtn">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
  
  <div class="flex-1 p-5 overflow-y-auto">
    <div class="text-center mb-6">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="110" class="mb-3 mx-auto" alt="User">
      <h5 class="font-bold mb-0 text-[#1a1a2e]"><?= htmlspecialchars($namaUser) ?></h5>
      <small class="text-gray-500"><?= htmlspecialchars($nimUser) ?></small>
    </div>
    
    <ul class="flex flex-col gap-2">
      <?php if($roleUser === 'admin'): ?>
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-gray-600 hover:bg-blue-600 hover:text-white hover:translate-x-1" href="../../public/dashboard.php">
          <i class="bi bi-grid-fill text-lg"></i> Dashboard Admin
        </a>
      </li>
      <?php else: ?>
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-gray-600 hover:bg-blue-600 hover:text-white hover:translate-x-1" href="../../public/dashboard_anggota.php">
          <i class="bi bi-grid-fill text-lg"></i> Dashboard
        </a>
      </li>
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-gray-600 hover:bg-blue-600 hover:text-white hover:translate-x-1" href="../../public/peminjaman_user.php">
          <i class="bi bi-journal-check text-lg"></i> Peminjaman
        </a>
      </li>
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-gray-600 hover:bg-blue-600 hover:text-white hover:translate-x-1" href="../../public/katalog.php">
          <i class="bi bi-book-half text-lg"></i> Katalog
        </a>
      </li>
      <?php endif; ?>
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 bg-blue-600 text-white translate-x-1" href="#">
          <i class="bi bi-person-fill text-lg"></i> Profile
        </a>
      </li>
    </ul>
  </div>
  
  <div class="p-5 border-t border-[#e9ecef]">
    <a href="../../public/logout.php" class="flex items-center justify-center gap-2 w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors font-medium">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  </div>
</aside>

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 right-0 h-[75px] bg-white shadow-sm rounded-b-[20px] z-[1000] flex justify-between items-center px-6 lg:px-10">
  <div class="flex items-center">
    <button class="bg-transparent border-none text-blue-600 text-2xl cursor-pointer p-2 rounded-lg transition-all lg:hidden hover:bg-black/5 hover:scale-105" id="openSidebarBtn">
      <i class="bi bi-list"></i>
    </button>
    <h4 class="ml-3 mt-1 font-bold text-lg hidden sm:block text-blue-600">👤 Profile Saya</h4>
  </div>
  <div class="flex items-center gap-4">
    <i class="bi bi-bell text-xl text-gray-600"></i>
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="45" class="rounded-full border-2 border-blue-500 transition-colors">
  </div>
</nav>

<!-- MAIN CONTENT -->
<main class="mt-[75px] p-6 lg:p-8 transition-all duration-300 min-h-[calc(100vh-75px)] lg:ml-[280px]" id="mainContent">
    
    <!-- PROFILE CARD -->
    <div class="bg-white rounded-[24px] p-8 shadow-[0_10px_25px_rgba(0,0,0,0.05)] mb-8 animate-fade-up">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            <div class="shrink-0">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 shadow-sm mx-auto md:mx-0">
            </div>
            <div class="flex-1 w-full text-center md:text-left">
                <h2 class="text-2xl font-bold mb-6 text-gray-900"><?= htmlspecialchars($namaUser) ?></h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Nama Lengkap</div>
                        <div class="font-semibold text-lg text-gray-800"><?= htmlspecialchars($namaUser) ?></div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">NIM / ID Anggota</div>
                        <div class="font-semibold text-lg text-gray-800"><?= htmlspecialchars($nimUser) ?></div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Role</div>
                        <div class="font-semibold text-lg text-gray-800 capitalize"><?= htmlspecialchars($roleUser) ?></div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Buku Aktif Dipinjam</div>
                        <div class="font-semibold text-lg text-blue-600"><?= $totalDipinjam ?> Buku</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- TABLE -->
    <div class="bg-white rounded-[24px] p-8 shadow-[0_10px_25px_rgba(0,0,0,0.05)] animate-fade-up" style="animation-delay: 0.1s;">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-xl font-bold text-gray-900 m-0">Buku Yang Sedang Dipinjam</h4>
            <span class="bg-yellow-100 text-yellow-800 px-4 py-1.5 rounded-full text-sm font-bold border border-yellow-200">
                <?= $totalDipinjam ?> Buku
            </span>
        </div>
        
        <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($borrowedBooks)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <i class="bi bi-journal-x text-4xl mb-3 block text-gray-300"></i>
                                Tidak ada buku yang sedang dipinjam
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($borrowedBooks as $book): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800"><?= htmlspecialchars($book['judul']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($book['penulis']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?= date('d M Y', strtotime($book['tanggal_pinjam'])) ?></td>
                            <td class="px-6 py-4">
                                <?php if($book['status'] === 'terlambat'): ?>
                                    <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold border border-red-200">Terlambat</span>
                                <?php else: ?>
                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold border border-yellow-200">Dipinjam</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
</main>

<script>
// ========== SIDEBAR TOGGLE ==========
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');
const openSidebarBtn = document.getElementById('openSidebarBtn');
const closeSidebarBtn = document.getElementById('closeSidebarBtn');

function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    sidebarOverlay.classList.remove('opacity-0', 'invisible');
    sidebarOverlay.classList.add('opacity-100', 'visible');
}

function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    sidebarOverlay.classList.remove('opacity-100', 'visible');
    sidebarOverlay.classList.add('opacity-0', 'invisible');
}

if (openSidebarBtn) openSidebarBtn.addEventListener('click', openSidebar);
if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
</script>

</body>
</html>
