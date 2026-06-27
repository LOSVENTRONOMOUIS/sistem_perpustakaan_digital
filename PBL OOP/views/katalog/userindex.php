<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect ke public/katalog.php jika file view ini diakses langsung
if (!isset($bukuList)) {
    header("Location: ../../public/katalog.php");
    exit;
}

if (!isset($_SESSION['user_id']) && !isset($_SESSION['id'])) {
    header("Location: ../../public/login.php");
    exit;
}
// Gunakan $currentUser jika ada, jika tidak fallback ke $_SESSION
$namaUser = $currentUser['nama'] ?? $_SESSION['nama'] ?? 'Mahasiswa';
$emailUser = $currentUser['email'] ?? $_SESSION['email'] ?? 'Library User';
$nimUser = $_SESSION['nim'] ?? 'Library User';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Katalog - Sistem Perpustakaan Digital</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
@keyframes cardFadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
@keyframes modalShow { from { opacity: 0; transform: scale(0.95) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
@keyframes notifPop { 0% { transform: scale(0.85); opacity: 0; } 80% { transform: scale(1.02); } 100% { transform: scale(1); opacity: 1; } }

.animate-fade-up { animation: fadeInUp 0.5s ease-out forwards; }
.animate-card-fade-in { animation: cardFadeIn 0.4s ease-out backwards; }

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
      <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" width="110" class="mb-3 mx-auto" alt="User">
      <h5 class="font-bold mb-0 text-[#1a1a2e]"><?= htmlspecialchars($namaUser) ?></h5>
      <small class="text-gray-500"><?= htmlspecialchars($nimUser) ?></small>
    </div>
    
    <ul class="flex flex-col gap-2">
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-gray-600 hover:bg-blue-600 hover:text-white hover:translate-x-1" href="dashboard_anggota.php">
          <i class="bi bi-grid-fill text-lg"></i> Dashboard
        </a>
      </li>
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-gray-600 hover:bg-blue-600 hover:text-white hover:translate-x-1" href="peminjaman_user.php">
          <i class="bi bi-journal-check text-lg"></i> Peminjaman
        </a>
      </li>
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 bg-blue-600 text-white translate-x-1" href="katalog.php">
          <i class="bi bi-book-half text-lg"></i> Katalog
        </a>
      </li>
    </ul>
  </div>
  
  <div class="p-5 border-t border-[#e9ecef]">
    <a href="../public/logout.php" class="flex items-center justify-center gap-2 w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors font-medium">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  </div>
</aside>

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 lg:left-[280px] right-0 h-[75px] bg-white shadow-sm rounded-b-[20px] z-[1000] flex justify-between items-center px-6 lg:px-10">
  <div class="flex items-center">
    <button class="bg-transparent border-none text-blue-600 text-2xl cursor-pointer p-2 rounded-lg transition-all lg:hidden hover:bg-black/5 hover:scale-105" id="openSidebarBtn">
      <i class="bi bi-list"></i>
    </button>
    <h4 class="ml-3 mt-1 font-bold text-lg hidden sm:block text-blue-600">📚 Dashboard Perpustakaan</h4>
  </div>
  <div class="flex items-center gap-4">
    <i class="bi bi-bell text-xl text-gray-600"></i>
    <a href="../views/auth/profile.php">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="45" class="rounded-full border-2 border-transparent hover:border-blue-500 transition-colors">
    </a>
  </div>
</nav>

<!-- MAIN CONTENT -->
<main class="mt-[75px] p-6 lg:p-8 transition-all duration-300 min-h-[calc(100vh-75px)] lg:ml-[280px]" id="mainContent">
    <div class="mb-8 animate-fade-up">
        <h1 class="text-3xl font-bold text-blue-600">📚 Katalog Buku</h1>
        <p class="mt-2 text-gray-500">Jelajahi koleksi buku digital dan fisik yang tersedia di perpustakaan kami</p>
    </div>

    <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-[0_10px_25px_rgba(0,0,0,0.05)] animate-fade-up border border-gray-100" style="animation-delay: 0.1s">
        <!-- Section Header & Search -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h3 class="text-xl font-bold text-[#1e293b] border-l-4 border-blue-600 pl-3 m-0">Koleksi Buku</h3>
            <div class="flex items-center bg-gray-50 border border-gray-200 rounded-full px-4 py-2 gap-2 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 transition-all w-full sm:w-auto">
                <i class="bi bi-search text-gray-400"></i>
                <input type="text" id="searchKatalog" class="bg-transparent border-none outline-none text-sm w-full sm:w-56 text-gray-700" placeholder="Cari judul atau penulis...">
            </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap gap-2 mb-4 p-4 bg-gray-50 rounded-2xl border border-gray-200" id="categoryFilter">
            <button class="px-5 py-2 rounded-full border-2 border-transparent bg-blue-600 text-white text-sm font-semibold transition-all hover:-translate-y-0.5 filter-btn" data-cat="all">Semua</button>
            <?php 
            if(isset($bukuList) && !empty($bukuList)) {
                $categories = array_unique(array_column($bukuList, 'nama_kategori'));
                foreach($categories as $cat): 
                    if(!empty($cat)): 
            ?>
            <button class="px-5 py-2 rounded-full border-2 border-gray-200 bg-white text-gray-600 text-sm font-semibold transition-all hover:border-blue-600 hover:text-blue-600 hover:-translate-y-0.5 filter-btn" data-cat="<?= strtolower($cat); ?>"><?= htmlspecialchars($cat); ?></button>
            <?php 
                    endif;
                endforeach; 
            }
            ?>
        </div>

        <div class="flex flex-wrap gap-2 mb-6 p-4 bg-gray-50 rounded-2xl border border-gray-200" id="statusFilter">
            <button class="px-5 py-2 rounded-full border-2 border-transparent bg-blue-600 text-white text-sm font-semibold transition-all hover:-translate-y-0.5 filter-btn" data-stat="all">Semua Status</button>
            <button class="px-5 py-2 rounded-full border-2 border-gray-200 bg-white text-gray-600 text-sm font-semibold transition-all hover:border-blue-600 hover:text-blue-600 hover:-translate-y-0.5 filter-btn" data-stat="tersedia">Tersedia</button>
            <button class="px-5 py-2 rounded-full border-2 border-gray-200 bg-white text-gray-600 text-sm font-semibold transition-all hover:border-blue-600 hover:text-blue-600 hover:-translate-y-0.5 filter-btn" data-stat="terbatas">Terbatas</button>
            <button class="px-5 py-2 rounded-full border-2 border-gray-200 bg-white text-gray-600 text-sm font-semibold transition-all hover:border-blue-600 hover:text-blue-600 hover:-translate-y-0.5 filter-btn" data-stat="habis">Habis</button>
        </div>

        <div id="emptyState" class="hidden text-center py-16 px-4 bg-gray-50 rounded-2xl border border-gray-100 animate-fade-up">
            <i class="bi bi-journal-x text-6xl text-gray-300 mb-4 block"></i>
            <h4 class="text-xl font-bold text-gray-700">Buku tidak ditemukan</h4>
            <p class="text-gray-500 mt-2">Coba gunakan kata kunci atau filter lain.</p>
        </div>

        <!-- Grid Buku -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="katalogGrid">
            <?php 
            if(isset($bukuList) && !empty($bukuList)): 
                $i = 0;
                foreach($bukuList as $buku): 
                    $i++;
                    $stok = (int)$buku['stok'];
                    if($stok <= 0){
                        $badgeText  = "Habis";
                        $badgeClass = "bg-red-100 text-red-800 border-red-200";
                        $status     = "habis";
                    } elseif($stok <= 5){
                        $badgeText  = $stok . " Tersisa";
                        $badgeClass = "bg-yellow-100 text-yellow-800 border-yellow-200";
                        $status     = "terbatas";
                    } else{
                        $badgeText  = "Tersedia";
                        $badgeClass = "bg-green-100 text-green-800 border-green-200";
                        $status     = "tersedia";
                    }
            ?>
            <div class="flex gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-blue-500 items-center book-card animate-card-fade-in"
                 style="animation-delay: <?= $i * 0.05 ?>s;"
                 data-category="<?= strtolower($buku['nama_kategori'] ?? 'lainnya'); ?>"
                 data-status="<?= $status; ?>"
                 data-title="<?= strtolower($buku['judul']); ?>"
                 data-author="<?= strtolower($buku['penulis']); ?>">

                <div class="w-16 h-24 rounded-xl flex items-center justify-center text-3xl shrink-0 shadow-sm overflow-hidden bg-gray-100">
                    <?php if(!empty($buku['cover'])): ?>
                        <img src="../assets/images/covers/<?= htmlspecialchars($buku['cover']); ?>" alt="Cover <?= htmlspecialchars($buku['judul']); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <span>📘</span>
                    <?php endif; ?>
                </div>

                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-bold text-gray-900 mb-1 truncate" title="<?= htmlspecialchars($buku['judul']); ?>"><?= htmlspecialchars($buku['judul']); ?></h4>
                    <div class="text-[11px] text-gray-500 mb-2 truncate">
                        <?= htmlspecialchars($buku['penulis']); ?> · <?= htmlspecialchars($buku['nama_kategori'] ?? 'Tidak Berkategori'); ?>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-[10px] px-2.5 py-1 rounded-full font-bold border <?= $badgeClass; ?>"><?= $badgeText; ?></span>

                        <?php if($stok <= 0): ?>
                            <button class="px-3 py-1 rounded-full bg-gray-300 text-gray-500 text-[10px] font-bold cursor-not-allowed" disabled>Stok Habis</button>
                        <?php else: ?>
                            <button class="px-3 py-1 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold transition-all hover:-translate-y-0.5 shadow-sm" 
                                onclick="pinjamBuku('<?= $buku['id']; ?>', '<?= addslashes(htmlspecialchars($buku['judul'])); ?>', '<?= addslashes(htmlspecialchars($buku['penulis'])); ?>', '<?= addslashes(htmlspecialchars($buku['cover'] ?? '')); ?>')">
                                Pinjam
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                endforeach; 
            endif;
            ?>
        </div>
    </div>
</main>

<!-- Modal Peminjaman -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[1060] flex items-center justify-center opacity-0 invisible transition-all duration-300" id="modalOverlay">
  <div class="bg-white rounded-3xl w-[95%] max-w-[450px] p-6 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.3)] transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto" id="modalBox">
    
    <form id="formPinjam" onsubmit="memprosesPeminjaman(event)">
        <h4 class="text-xl font-bold text-center text-gray-900 mb-6">Form Peminjaman</h4>
        
        <input type="hidden" name="buku_id" id="idBuku">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['id'] ?? $_SESSION['user_id'] ?? 1); ?>">
        <input type="hidden" name="status" value="dipinjam">

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                <input type="email" id="inputEmail" value="<?= htmlspecialchars($emailUser); ?>" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 font-medium outline-none" readonly>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama</label>
                <input type="text" id="inputNama" value="<?= htmlspecialchars($namaUser); ?>" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 font-medium outline-none" readonly>
            </div>
        </div>

        <div class="flex items-center gap-4 bg-gray-50 rounded-2xl p-3 mb-4 border border-gray-200">
            <div class="w-12 h-16 rounded-xl flex items-center justify-center text-3xl shrink-0 overflow-hidden bg-blue-100" id="modalPreviewCover">📘</div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-bold text-gray-900 mb-1 truncate" id="mJudul2">—</div>
                <div class="text-[11px] text-gray-500 mb-1.5 truncate" id="mPenulis2">—</div>
                <span class="inline-block text-[10px] px-2 py-0.5 rounded-full font-bold bg-green-100 text-green-800 border border-green-200">Tersedia</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tgl Pinjam</label>
                <input type="date" name="tanggal_pinjam" id="tanggalPinjam" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 font-medium outline-none" readonly>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tgl Kembali</label>
                <input type="date" name="tanggal_kembali" id="tanggalKembali" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 font-medium outline-none" readonly>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Durasi</label>
            <input type="text" value="14 Hari" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-blue-700 font-bold outline-none" readonly>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" class="px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold transition-colors" onclick="closeModal()">Batal</button>
            <button type="submit" class="px-5 py-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold transition-all hover:-translate-y-0.5 shadow-md shadow-blue-500/30">Proses Pinjam</button>
        </div>
    </form>
  </div>
</div>

<!-- Notifikasi Besar -->
<div class="fixed inset-0 bg-black/65 backdrop-blur-md z-[1100] flex items-center justify-center opacity-0 invisible transition-opacity duration-300" id="bigNotifCenter">
  <div class="bg-gradient-to-br from-white to-gray-50 rounded-[40px] w-[90%] max-w-[420px] p-8 text-center shadow-[0_40px_65px_rgba(0,0,0,0.25)] border border-blue-100 transform scale-90 transition-transform duration-400" id="bigNotifCard">
    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-5xl mb-6 shadow-[0_12px_25px_rgba(59,130,246,0.3)]">
        <i class="bi bi-check2-circle"></i>
    </div>
    <div class="text-3xl font-extrabold mb-3 bg-gradient-to-br from-blue-600 to-blue-800 bg-clip-text text-transparent">Peminjaman Berhasil!</div>
    <div class="text-lg font-medium text-gray-700 mb-5 leading-snug">
      Silahkan ambil buku di perpustakaan.<br>
      <span id="bigNotifBookName" class="font-bold block mt-2 text-blue-600">—</span>
    </div>
    <div class="text-sm text-gray-500 mb-8 font-medium" id="bigNotifUser">Terima kasih telah meminjam</div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-bold text-lg transition-all hover:scale-105 shadow-[0_8px_20px_rgba(37,99,235,0.3)]" id="closeBigNotifBtn" onclick="selesai()">OK, Mengerti</button>
  </div>
</div>

<script>
// Sidebar Toggle Logic
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

// FILTER dan SEARCH
let currentCategory = 'all';
let currentStatus = 'all';

function filterBooks() {
    const searchInput = document.getElementById('searchKatalog');
    const keyword = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const items = document.querySelectorAll('#katalogGrid .book-card');
    let visibleCount = 0;

    items.forEach(item => {
        const category = item.getAttribute('data-category');
        const status = item.getAttribute('data-status');
        const title = item.getAttribute('data-title') || '';
        const author = item.getAttribute('data-author') || '';

        const matchCategory = currentCategory === 'all' || category === currentCategory;
        const matchStatus = currentStatus === 'all' || status === currentStatus;
        const matchSearch = keyword === '' || title.includes(keyword) || author.includes(keyword);
        
        const show = matchCategory && matchStatus && matchSearch;
        
        if (show) {
            item.style.display = 'flex';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    const emptyState = document.getElementById('emptyState');
    if (emptyState) {
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }
}

document.querySelectorAll('#categoryFilter .filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('#categoryFilter .filter-btn').forEach(b => {
            b.classList.remove('bg-blue-600', 'text-white', 'border-transparent');
            b.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
        });
        this.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');
        this.classList.add('bg-blue-600', 'text-white', 'border-transparent');
        
        currentCategory = this.getAttribute('data-cat');
        filterBooks();
    });
});

document.querySelectorAll('#statusFilter .filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('#statusFilter .filter-btn').forEach(b => {
            b.classList.remove('bg-blue-600', 'text-white', 'border-transparent');
            b.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
        });
        this.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');
        this.classList.add('bg-blue-600', 'text-white', 'border-transparent');
        
        currentStatus = this.getAttribute('data-stat');
        filterBooks();
    });
});

const searchKatalog = document.getElementById('searchKatalog');
if (searchKatalog) {
    searchKatalog.addEventListener('input', filterBooks);
}

// VARIABEL PEMINJAMAN
let currentBook = {};
const modalOverlay = document.getElementById('modalOverlay');
const modalBox = document.getElementById('modalBox');

// MEMPERSIAPKAN DATA MODAL SAAT TOMBOL PINJAM DIKLIK
function pinjamBuku(id, judul, penulis, cover) {
    currentBook = { id: id, judul: judul, penulis: penulis };

    document.getElementById('idBuku').value = id;
    document.getElementById('mJudul2').innerText = judul;
    document.getElementById('mPenulis2').innerText = penulis;

    let coverEl = document.getElementById('modalPreviewCover');
    if (cover && cover.trim() !== '') {
        coverEl.innerHTML = `<img src="../assets/images/covers/${cover}" class="w-full h-full object-cover">`;
        coverEl.classList.remove('bg-blue-100');
    } else {
        coverEl.innerHTML = '📘';
        coverEl.classList.add('bg-blue-100');
    }

    // Set Tanggal Pinjam & Kembali otomatis (format YYYY-MM-DD)
    let today = new Date();
    let kembali = new Date();
    kembali.setDate(today.getDate() + 14); // 14 Hari peminjaman

    // Konversi ke format string ISO
    document.getElementById('tanggalPinjam').value = today.toISOString().split('T')[0];
    document.getElementById('tanggalKembali').value = kembali.toISOString().split('T')[0];

    // Show Modal
    modalOverlay.classList.remove('opacity-0', 'invisible');
    modalOverlay.classList.add('opacity-100', 'visible');
    setTimeout(() => {
        modalBox.classList.remove('scale-95');
        modalBox.classList.add('scale-100');
    }, 10);
}

function closeModal() {
    modalBox.classList.remove('scale-100');
    modalBox.classList.add('scale-95');
    setTimeout(() => {
        modalOverlay.classList.remove('opacity-100', 'visible');
        modalOverlay.classList.add('opacity-0', 'invisible');
    }, 200);
}

// MENGIRIM DATA KE CONTROLLER MENGGUNAKAN FETCH API (AJAX)
function memprosesPeminjaman(event) {
    event.preventDefault(); 
    closeModal();
    
    const formElement = document.getElementById('formPinjam');
    const formData = new FormData(formElement);

    formData.append('action', 'pinjam');
    fetch('katalog.php', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success || data.status === 'success') {
            const namaPeminjam = document.getElementById('inputNama').value || "Mahasiswa";
            
            document.getElementById('bigNotifBookName').innerText = `📖 "${currentBook.judul}"`;
            document.getElementById('bigNotifUser').innerText = `Peminjam: ${namaPeminjam} • Selamat membaca!`;
            
            const bigNotifCenter = document.getElementById('bigNotifCenter');
            const bigNotifCard = document.getElementById('bigNotifCard');
            
            bigNotifCenter.classList.remove('opacity-0', 'invisible');
            bigNotifCenter.classList.add('opacity-100', 'visible');
            setTimeout(() => {
                bigNotifCard.classList.remove('scale-90');
                bigNotifCard.classList.add('scale-100');
            }, 10);
            
        } else {
            alert("Gagal memproses peminjaman: " + (data.message || "Kesalahan tidak diketahui"));
            console.log(data);
        }
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert("Gagal menghubungi server database.");
    });
}

// MENUTUP NOTIFIKASI BESAR
function selesai() {
    const bigNotifCenter = document.getElementById('bigNotifCenter');
    const bigNotifCard = document.getElementById('bigNotifCard');
    
    bigNotifCard.classList.remove('scale-100');
    bigNotifCard.classList.add('scale-90');
    
    setTimeout(() => {
        bigNotifCenter.classList.remove('opacity-100', 'visible');
        bigNotifCenter.classList.add('opacity-0', 'invisible');
        window.location.reload(); 
    }, 200);
}
</script>
</body>
</html>