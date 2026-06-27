<?php
/**
 * VIEW TEMPLATE: User Peminjaman
 * Data disiapkan oleh public/peminjaman_user.php
 * Variabel yang tersedia:
 * @var int $totalSemua
 * @var int $totalDipinjam
 * @var int $totalTerlambat
 * @var int $totalKembali
 * @var int $totalBatal
 * @var string $peminjamanTableHtml
 * @var string $toastMessage
 * @var string $toastType
 */

if (!isset($totalSemua)) {
    header('Location: ../../public/peminjaman_user.php');
    exit;
}

$namaUser = $_SESSION['nama'] ?? 'Mahasiswa';
$nimUser = $_SESSION['nim'] ?? 'Library User';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Peminjaman - Sistem Perpustakaan Digital</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style type="text/tailwindcss">
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
@keyframes cardFadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
@keyframes slideInRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
@keyframes slideOutRight { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }

.animate-fade-up { animation: fadeInUp 0.5s ease-out forwards; }
.animate-card-fade-in { animation: cardFadeIn 0.4s ease-out backwards; }

::-webkit-scrollbar { width: 8px; height: 8px; }
::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }

/* Custom table styles to match previous design */
.pinjam-table th { @apply bg-gray-50 px-4 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b-2 border-gray-200 whitespace-nowrap sticky top-0 z-10; }
.pinjam-table td { @apply px-4 py-4 border-b border-gray-100 align-middle text-sm text-gray-700; }
.pinjam-table tr { @apply transition-all duration-200 animate-[slideInRight_0.4s_ease_both]; }
.pinjam-table tr:hover { @apply bg-gray-50 scale-[1.005]; }
.pinjam-table tr.hidden-row { display: none !important; }

/* Filter buttons */
.filter-btn { @apply px-5 py-2 rounded-full border-2 border-gray-200 bg-white text-gray-600 text-sm font-semibold transition-all hover:border-blue-600 hover:text-blue-600 hover:-translate-y-0.5 inline-flex items-center gap-1.5; }
.filter-btn.active { @apply bg-blue-600 text-white border-transparent shadow-[0_4px_12px_rgba(13,110,253,0.3)]; }
.filter-btn .badge-count { @apply bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full text-[11px] font-bold ml-1 transition-colors; }
.filter-btn.active .badge-count { @apply bg-white/30 text-white; }

/* Status Pills */
.status-pill { @apply inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border transition-colors; }
.status-pill-primary { @apply bg-blue-50 text-blue-700 border-blue-200; }
.status-pill-danger { @apply bg-red-50 text-red-700 border-red-200; }
.status-pill-success { @apply bg-emerald-50 text-emerald-700 border-emerald-200; }
.status-pill-secondary { @apply bg-gray-50 text-gray-700 border-gray-200; }

/* Action Buttons */
.btn-lihat { @apply inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white rounded-lg text-xs font-bold transition-all duration-200 border border-blue-200 hover:border-blue-600 shadow-sm hover:shadow-md; }
.btn-batalkan { @apply inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-lg text-xs font-bold transition-all duration-200 border border-red-200 hover:border-red-600 shadow-sm hover:shadow-md; }
</style>
</head>
<body class="font-['Poppins'] min-h-screen overflow-x-hidden bg-[#f4f7fe] text-[#333] transition-all duration-300">

<!-- Toast Container -->
<div id="toastContainer" class="fixed top-5 right-5 z-[9999] flex flex-col gap-3"></div>

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
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 bg-blue-600 text-white translate-x-1" href="peminjaman_user.php">
          <i class="bi bi-journal-check text-lg"></i> Peminjaman
        </a>
      </li>
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-gray-600 hover:bg-blue-600 hover:text-white hover:translate-x-1" href="katalog.php">
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
    
    <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-[0_10px_25px_rgba(0,0,0,0.05)] animate-fade-up border border-gray-100">
        
        <div class="mb-6">
            <h3 class="text-xl font-bold text-[#1e293b] border-l-4 border-blue-600 pl-3 m-0"><i class="bi bi-journal-check mr-2"></i>Data Peminjaman Saya</h3>
        </div>
        
        <!-- ========== FILTER STATUS ========== -->
        <div class="flex flex-wrap gap-2 mb-6 p-4 bg-gray-50 rounded-2xl border border-gray-200">
            <button class="filter-btn active" data-filter="all" onclick="filterTable('all')">
                <i class="bi bi-grid-3x3-gap-fill"></i> Semua
                <span class="badge-count"><?= $totalSemua ?></span>
            </button>
            <button class="filter-btn" data-filter="dipinjam" onclick="filterTable('dipinjam')">
                <i class="bi bi-book"></i> Dipinjam
                <span class="badge-count"><?= $totalDipinjam ?></span>
            </button>
            <button class="filter-btn" data-filter="terlambat" onclick="filterTable('terlambat')">
                <i class="bi bi-exclamation-triangle-fill"></i> Terlambat
                <span class="badge-count"><?= $totalTerlambat ?></span>
            </button>
            <button class="filter-btn" data-filter="kembali" onclick="filterTable('kembali')">
                <i class="bi bi-check-circle-fill"></i> Dikembalikan
                <span class="badge-count"><?= $totalKembali ?></span>
            </button>
            <button class="filter-btn" data-filter="batal" onclick="filterTable('batal')">
                <i class="bi bi-x-circle-fill"></i> Dibatalkan
                <span class="badge-count"><?= $totalBatal ?></span>
            </button>
        </div>
        
        <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm">
            <table class="pinjam-table w-full border-collapse" id="peminjamanTable">
                <thead>
                <tr>
                    <th class="w-[5%]">No</th>
                    <th class="w-[35%]">Judul Buku</th>
                    <th class="w-[15%]">Nama Peminjam</th>
                    <th class="w-[12%]">Tgl Pinjam</th>
                    <th class="w-[12%]">Tgl Kembali</th>
                    <th class="w-[12%]">Status</th>
                    <th class="w-[9%]">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?= $peminjamanTableHtml ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-right text-sm text-gray-500 font-medium">
            <span id="rowCounter">Menampilkan <?= $totalSemua ?> data</span>
        </div>
    </div>
</main>

<!-- MODAL DETAIL -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[1060] flex items-center justify-center opacity-0 invisible transition-all duration-300 p-4" id="modalOverlay">
  <div class="bg-white rounded-[28px] w-full max-w-[560px] shadow-[0_25px_50px_-12px_rgba(0,0,0,0.3)] transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-hidden flex flex-col" id="modalBox">
    
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-5 text-center shrink-0">
        <h3 class="text-xl font-bold m-0"><i class="bi bi-journal-bookmark-fill mr-2"></i>Detail Peminjaman</h3>
        <p class="text-[0.7rem] opacity-70 mt-1.5 mb-0 font-mono" id="formTrxCode">#TRX-0001</p>
    </div>
      
    <div class="p-6 bg-white overflow-y-auto">
        
        <div class="mb-5 pb-3 border-b-2 border-dashed border-gray-100">
            <h4 class="text-lg font-extrabold text-slate-900 m-0 mb-1.5" id="formJudulBuku">Algoritma & Pemrograman</h4>
            <p class="text-xs text-slate-500 m-0 flex items-center gap-1.5 font-medium"><i class="bi bi-person-circle"></i> <span id="formNamaPeminjam">Budi Santoso</span></p>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-[0.7rem] font-bold text-slate-500 uppercase tracking-[0.8px] mb-1.5"><i class="bi bi-person mr-1"></i> Nama Lengkap</label>
                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 min-h-[44px] flex items-center" id="formNamaValue">Budi Santoso</div>
            </div>
            <div>
                <label class="block text-[0.7rem] font-bold text-slate-500 uppercase tracking-[0.8px] mb-1.5"><i class="bi bi-envelope mr-1"></i> Email</label>
                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 min-h-[44px] flex items-center truncate" id="formEmailValue">-</div>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-[0.7rem] font-bold text-slate-500 uppercase tracking-[0.8px] mb-1.5"><i class="bi bi-calendar-plus mr-1"></i> Tanggal Pinjam</label>
            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800" id="formTglPinjam">01 Apr 2025</div>
        </div>
        
        <div class="mb-4">
            <label class="block text-[0.7rem] font-bold text-slate-500 uppercase tracking-[0.8px] mb-1.5"><i class="bi bi-calendar-check mr-1"></i> Tanggal Kembali</label>
            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800" id="formTglKembali">15 Apr 2025</div>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-[0.7rem] font-bold text-slate-500 uppercase tracking-[0.8px] mb-1.5"><i class="bi bi-hourglass-split mr-1"></i> Durasi</label>
                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800" id="formDurasi">14 Hari</div>
            </div>
            <div>
                <label class="block text-[0.7rem] font-bold text-slate-500 uppercase tracking-[0.8px] mb-1.5"><i class="bi bi-clock-history mr-1"></i> Sisa / Terlambat</label>
                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800" id="formSisaHari">3 Hari</div>
            </div>
        </div>
        
        <!-- Progress Terlambat -->
        <div id="formProgressTerlambatArea" class="hidden mb-4 mt-1 bg-red-50 border border-red-100 rounded-xl p-3">
            <div class="flex justify-between items-center text-[0.7rem] font-bold text-red-700 mb-2">
                <span><i class="bi bi-exclamation-triangle-fill mr-1"></i> Status Terlambat</span>
                <span id="formPersenTerlambat">0%</span>
            </div>
            <div class="bg-slate-200 rounded-full h-1.5 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-red-600 h-full rounded-full transition-all duration-700 ease-out w-0" id="formProgressFillTerlambat"></div>
            </div>
            <div class="text-[0.7rem] text-red-700 mt-2 font-medium" id="formTerlambatDesc">
                ⚠️ Melebihi batas pengembalian
            </div>
        </div>
        
        <!-- Progress Dipinjam -->
        <div id="formProgressDipinjamArea" class="hidden mb-4 mt-1 bg-blue-50 border border-blue-100 rounded-xl p-3">
            <div class="flex justify-between items-center text-[0.7rem] font-bold text-blue-700 mb-2">
                <span><i class="bi bi-calendar-week mr-1"></i> Progress Peminjaman</span>
                <span id="formPersenDipinjam">0%</span>
            </div>
            <div class="bg-slate-200 rounded-full h-1.5 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full rounded-full transition-all duration-700 ease-out w-0" id="formProgressFillDipinjam"></div>
            </div>
            <div class="text-[0.7rem] text-blue-700 mt-2 font-medium" id="formDipinjamDesc">
                📅 Menghitung masa peminjaman
            </div>
        </div>
        
        <div class="mt-2">
            <div class="text-[0.7rem] font-bold text-slate-500 uppercase tracking-[0.8px] mb-2"><i class="bi bi-flag-fill mr-1"></i> STATUS PEMINJAMAN</div>
            <span class="inline-block px-7 py-2 rounded-full text-sm font-bold bg-gray-200 text-gray-800" id="formStatusBadge">Terlambat</span>
        </div>
        
    </div>
      
    <div class="p-4 bg-white border-t border-slate-100 flex justify-end shrink-0">
        <button class="bg-slate-100 hover:bg-slate-200 border border-slate-200 px-8 py-2.5 rounded-full text-sm font-semibold text-slate-700 transition-all hover:-translate-y-0.5" onclick="closeDetailModal()"><i class="bi bi-x-circle mr-1.5"></i> Tutup</button>
    </div>
      
  </div>
</div>

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

// ========== FUNGSI FILTER ==========
function filterTable(filter) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-blue-600', 'text-white', 'border-transparent');
        btn.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
        if (btn.getAttribute('data-filter') === filter) {
            btn.classList.add('active', 'bg-blue-600', 'text-white', 'border-transparent');
            btn.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');
        }
    });
    
    const rows = document.querySelectorAll('#peminjamanTable tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        if (filter === 'all' || status === filter) {
            row.classList.remove('hidden-row');
            visibleCount++;
        } else {
            row.classList.add('hidden-row');
        }
    });
    
    const counter = document.getElementById('rowCounter');
    if (counter) {
        const total = rows.length;
        counter.textContent = `Menampilkan ${visibleCount} dari ${total} data`;
    }
}

// ========== FUNGSI TOAST ==========
function showToast(title, message, type = 'success', duration = 4000) {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
    const toastId = 'toast_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    
    const icons = { success: '✓', error: '✕', warning: '⚠' };
    const icon = icons[type] || 'ℹ';
    
    let colorClasses = '';
    if (type === 'success') colorClasses = 'border-l-4 border-green-500';
    else if (type === 'error') colorClasses = 'border-l-4 border-red-500';
    else if (type === 'warning') colorClasses = 'border-l-4 border-yellow-500';
    else colorClasses = 'border-l-4 border-blue-500';
    
    let iconBg = '';
    let iconColor = '';
    if (type === 'success') { iconBg = 'bg-green-100'; iconColor = 'text-green-500'; }
    else if (type === 'error') { iconBg = 'bg-red-100'; iconColor = 'text-red-500'; }
    else if (type === 'warning') { iconBg = 'bg-yellow-100'; iconColor = 'text-yellow-500'; }
    else { iconBg = 'bg-blue-100'; iconColor = 'text-blue-500'; }
    
    const toastHTML = `
        <div id="${toastId}" class="bg-white rounded-2xl p-4 min-w-[320px] max-w-[450px] shadow-[0_10px_40px_rgba(0,0,0,0.15)] flex items-center gap-4 animate-[slideInRight_0.3s_ease-out] ${colorClasses}">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl shrink-0 ${iconBg} ${iconColor}">${icon}</div>
            <div class="flex-1">
                <div class="font-bold text-base mb-1 text-gray-800">${title}</div>
                <div class="text-[13px] text-gray-500 leading-snug">${message}</div>
            </div>
            <button class="bg-transparent border-none text-xl cursor-pointer text-gray-400 w-6 h-6 flex items-center justify-center rounded-full transition-all hover:bg-gray-100 hover:text-gray-800" onclick="closeToast('${toastId}')">×</button>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', toastHTML);
    setTimeout(() => { closeToast(toastId); }, duration);
}

function closeToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
        toast.classList.replace('animate-[slideInRight_0.3s_ease-out]', 'animate-[slideOutRight_0.3s_ease-out_forwards]');
        setTimeout(() => toast.remove(), 300);
    }
}

// ========== FUNGSI BATALKAN ==========
function batalkanPeminjaman(id, judul) {
    if (confirm(`Apakah Anda yakin ingin membatalkan peminjaman buku "${judul}"?\n\nStatus akan diubah menjadi DIBATALKAN.\nStok buku akan dikembalikan.`)) {
        const buttons = document.querySelectorAll(`.btn-batalkan`);
        let targetButton = null;
        for (let btn of buttons) {
            if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(`batalkanPeminjaman(${id}`)) {
                targetButton = btn;
                break;
            }
        }
        
        if (targetButton) {
            const originalText = targetButton.innerHTML;
            targetButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
            targetButton.disabled = true;
        }
        
        fetch('peminjaman_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=batalkan&id=' + id
        })
        .then(response => {
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            }
            return response.text().then(text => {
                console.error('Server mengembalikan non-JSON:', text.substring(0, 500));
                throw new Error('Server error: respons bukan JSON');
            });
        })
        .then(data => {
            if (data.success) {
                showToast('✅ Berhasil', data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('❌ Gagal', data.message, 'error');
                if (targetButton) {
                    targetButton.innerHTML = '<i class="bi bi-x-circle"></i> Batalkan';
                    targetButton.disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('❌ Error', 'Terjadi kesalahan: ' + error.message, 'error');
            if (targetButton) {
                targetButton.innerHTML = '<i class="bi bi-x-circle"></i> Batalkan';
                targetButton.disabled = false;
            }
        });
    }
}

// ========== PARSE TANGGAL ==========
function parseIndonesianDate(dateStr) {
    const months = { 'Jan':0,'Feb':1,'Mar':2,'Apr':3,'May':4,'Jun':5, 'Jul':6,'Aug':7,'Sep':8,'Oct':9,'Nov':10,'Dec':11 };
    let parts = dateStr.split(' ');
    if(parts.length === 3) {
        let day = parseInt(parts[0]);
        let month = months[parts[1]];
        let year = parseInt(parts[2]);
        if(!isNaN(day) && month !== undefined && !isNaN(year)) {
            return new Date(year, month, day);
        }
    }
    return new Date(dateStr);
}

// ========== HITUNG PROGRESS ==========
function hitungProgressPeminjaman(tglPinjam, tglKembaliDatabase, today) {
    const BATAS_MAKSIMAL = 14;
    const pinjam = new Date(tglPinjam); pinjam.setHours(0,0,0,0);
    const tglKembaliDatabaseDate = new Date(tglKembaliDatabase); tglKembaliDatabaseDate.setHours(0,0,0,0);
    const sekarang = new Date(today); sekarang.setHours(0,0,0,0);
    
    const tglBatas = new Date(pinjam); tglBatas.setDate(tglBatas.getDate() + BATAS_MAKSIMAL);
    
    const durasiSebenarnya = Math.ceil((tglKembaliDatabaseDate.getTime() - pinjam.getTime()) / (1000 * 60 * 60 * 24));
    let hariBerjalan = Math.max(0, Math.ceil((sekarang.getTime() - pinjam.getTime()) / (1000 * 60 * 60 * 24)));
    let sisaHari = Math.max(0, Math.ceil((tglBatas.getTime() - sekarang.getTime()) / (1000 * 60 * 60 * 24)));
    
    let hariTerlambat = 0;
    if (sekarang > tglBatas) {
        hariTerlambat = Math.ceil((sekarang.getTime() - tglBatas.getTime()) / (1000 * 60 * 60 * 24));
    }
    
    let persenProgress = hariBerjalan <= BATAS_MAKSIMAL ? (hariBerjalan / BATAS_MAKSIMAL) * 100 : 100;
    persenProgress = Math.min(Math.max(persenProgress, 0), 100);
    
    let persenTerlambat = hariTerlambat > 0 ? Math.min((hariTerlambat / BATAS_MAKSIMAL) * 100, 100) : 0;
    
    return { durasiSebenarnya, batasMaksimal: BATAS_MAKSIMAL, hariBerjalan, sisaHari, hariTerlambat, persenProgress, persenTerlambat, tglBatas };
}

// ========== MODAL TOGGLE ==========
function openDetailModal() {
    const modalOverlay = document.getElementById('modalOverlay');
    const modalBox = document.getElementById('modalBox');
    modalOverlay.classList.remove('opacity-0', 'invisible');
    modalOverlay.classList.add('opacity-100', 'visible');
    setTimeout(() => {
        modalBox.classList.remove('scale-95');
        modalBox.classList.add('scale-100');
    }, 10);
}

function closeDetailModal() {
    const modalOverlay = document.getElementById('modalOverlay');
    const modalBox = document.getElementById('modalBox');
    modalBox.classList.remove('scale-100');
    modalBox.classList.add('scale-95');
    setTimeout(() => {
        modalOverlay.classList.remove('opacity-100', 'visible');
        modalOverlay.classList.add('opacity-0', 'invisible');
    }, 200);
}

// ========== SHOW DETAIL ==========
function showDetail(id) {
    fetch('peminjaman_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=get_detail&id=' + id
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        }
        return response.text().then(text => {
            console.error('Server mengembalikan non-JSON:', text.substring(0, 500));
            throw new Error('Server error: respons bukan JSON');
        });
    })
    .then(result => {
        if(result.success) {
            const data = result.data;
            
            document.getElementById('formTrxCode').innerHTML = `#TRX-${String(data.id).padStart(4, '0')}`;
            document.getElementById('formJudulBuku').innerHTML = data.judul;
            document.getElementById('formNamaPeminjam').innerHTML = data.nama;
            document.getElementById('formNamaValue').innerHTML = data.nama;
            document.getElementById('formEmailValue').innerHTML = data.email || '-';
            document.getElementById('formTglPinjam').innerHTML = data.tanggal_pinjam;
            document.getElementById('formTglKembali').innerHTML = data.tanggal_kembali;
            
            const pinjamDate = parseIndonesianDate(data.tanggal_pinjam);
            const kembaliDate = parseIndonesianDate(data.tanggal_kembali);
            const today = new Date(); today.setHours(0,0,0,0);
            
            const progress = hitungProgressPeminjaman(pinjamDate, kembaliDate, today);
            document.getElementById('formDurasi').innerHTML = `${progress.durasiSebenarnya} Hari (Maksimal ${progress.batasMaksimal} hari)`;
            
            const statusBadge = document.getElementById('formStatusBadge');
            const progressTerlambatArea = document.getElementById('formProgressTerlambatArea');
            const progressDipinjamArea = document.getElementById('formProgressDipinjamArea');
            const sisaElement = document.getElementById('formSisaHari');
            
            progressTerlambatArea.classList.add('hidden');
            progressDipinjamArea.classList.add('hidden');
            progressTerlambatArea.classList.remove('block');
            progressDipinjamArea.classList.remove('block');
            
            const isTerlambat = progress.hariTerlambat > 0;
            
            if(data.status === 'kembali') {
                statusBadge.innerHTML = 'Dikembalikan';
                statusBadge.className = 'inline-block px-7 py-2 rounded-full text-sm font-bold bg-green-100 text-green-700 border border-green-200';
                sisaElement.innerHTML = `✔️ Selesai (sudah dikembalikan)`;
            }
            else if(data.status === 'batal') {
                statusBadge.innerHTML = 'Dibatalkan';
                statusBadge.className = 'inline-block px-7 py-2 rounded-full text-sm font-bold bg-gray-200 text-gray-700 border border-gray-300';
                sisaElement.innerHTML = `✖️ Peminjaman dibatalkan`;
            }
            else if(isTerlambat) {
                statusBadge.innerHTML = 'Terlambat';
                statusBadge.className = 'inline-block px-7 py-2 rounded-full text-sm font-bold bg-red-100 text-red-700 border border-red-200';
                sisaElement.innerHTML = `Terlambat ${progress.hariTerlambat} hari`;
                
                progressTerlambatArea.classList.remove('hidden');
                progressTerlambatArea.classList.add('block');
                const persenBulat = Math.round(progress.persenTerlambat);
                document.getElementById('formPersenTerlambat').innerHTML = `${persenBulat}%`;
                setTimeout(() => {
                    document.getElementById('formProgressFillTerlambat').style.width = `${persenBulat}%`;
                }, 100);
                
                document.getElementById('formTerlambatDesc').innerHTML = `⚠️ Terlambat ${progress.hariTerlambat} hari dari batas maksimal ${progress.batasMaksimal} hari`;
            } 
            else if(data.status === 'dipinjam' && !isTerlambat) {
                statusBadge.innerHTML = 'Dipinjam';
                statusBadge.className = 'inline-block px-7 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-700 border border-yellow-200';
                
                if(progress.sisaHari > 0) {
                    sisaElement.innerHTML = `${progress.sisaHari} Hari`;
                } else {
                    sisaElement.innerHTML = `Jatuh tempo hari ini`;
                }
                
                progressDipinjamArea.classList.remove('hidden');
                progressDipinjamArea.classList.add('block');
                const persenBulat = Math.round(progress.persenProgress);
                document.getElementById('formPersenDipinjam').innerHTML = `${persenBulat}%`;
                setTimeout(() => {
                    document.getElementById('formProgressFillDipinjam').style.width = `${persenBulat}%`;
                }, 100);
                
                document.getElementById('formDipinjamDesc').innerHTML = `📅 ${progress.hariBerjalan} dari ${progress.batasMaksimal} hari terpakai • Sisa ${progress.sisaHari} hari lagi`;
            }
            
            openDetailModal();
        } else {
            showToast('❌ Gagal', result.message || 'Unknown error', 'error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showToast('❌ Error', 'Terjadi kesalahan: ' + error.message, 'error');
    });
}

// ========== TAMPILKAN TOAST DARI SESSION ==========
<?php if($toastMessage): ?>
    showToast('<?= $toastType === 'success' ? '✅ Berhasil' : '❌ Gagal' ?>', '<?= addslashes($toastMessage) ?>', '<?= $toastType ?>');
<?php endif; ?>

// ========== EXPOSE FUNCTIONS ==========
window.showDetail = showDetail;
window.batalkanPeminjaman = batalkanPeminjaman;
window.showToast = showToast;
window.filterTable = filterTable;
window.closeDetailModal = closeDetailModal;
</script>

</body>
</html>