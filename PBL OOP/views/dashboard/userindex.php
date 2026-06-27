<?php
/**
 * VIEW TEMPLATE: User Dashboard
 * Data disiapkan oleh public/dashboard_anggota.php
 * @var bool $is_locked
 * @var string $user_nama
 * @var string $user_nim
 * @var int $totalKoleksi
 * @var int $totalDipinjam
 * @var int $totalTerlambat
 * @var array $bukuPopuler
 */

if (!isset($is_locked)) {
  header('Location: ../../public/dashboard_anggota.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Sistem Perpustakaan Digital <?= $is_locked ? '- Akses Terkunci' : '' ?></title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
@keyframes cardFadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-up { animation: fadeInUp 0.5s ease-out forwards; }
.animate-card-fade-in { animation: cardFadeIn 0.4s ease-out backwards; }

.custom-checkbox.checked i { opacity: 1 !important; }
.custom-checkbox.checked { background-color: #ef4444 !important; border-color: #ef4444 !important; }
.payment-card.selected { border-color: #3b82f6 !important; }
.payment-card.selected i { color: #3b82f6 !important; }
<?= $is_locked ? '.payment-card.selected { background-color: rgba(59,130,246,0.1) !important; }' : '.payment-card.selected { background-color: #eff6ff !important; }' ?>
</style>
</head>
<body class="font-['Poppins'] min-h-screen overflow-x-hidden transition-all duration-300 <?= $is_locked ? 'bg-[#0f0f1a] text-[#e0e0e0]' : 'bg-[#f4f7fe] text-[#333]' ?>">

<!-- Sidebar Overlay -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[1040] opacity-0 invisible transition-all duration-300 lg:hidden" id="sidebarOverlay"></div>

<!-- SIDEBAR -->
<aside class="fixed top-0 left-0 w-[280px] h-screen shadow-[2px_0_20px_rgba(0,0,0,0.1)] z-[1050] -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col <?= $is_locked ? 'bg-[#16213e]' : 'bg-white' ?>" id="sidebar">
  <div class="p-5 border-b flex justify-between items-center <?= $is_locked ? 'border-[#ef4444]' : 'border-[#e9ecef]' ?>">
    <h4 class="m-0 text-[1.2rem] font-bold <?= $is_locked ? 'text-[#ef4444]' : 'text-blue-600' ?>">
      <i class="bi bi-book-half"></i> Digital Library
    </h4>
    <button class="text-2xl cursor-pointer bg-transparent border-none lg:hidden transition-transform hover:rotate-90 <?= $is_locked ? 'text-[#ef4444] hover:text-[#ef4444]' : 'text-gray-500 hover:text-blue-600' ?>" id="closeSidebarBtn">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
  
  <div class="flex-1 p-5 overflow-y-auto">
    <div class="text-center mb-6">
      <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" width="110" class="mb-3 mx-auto <?= $is_locked ? 'drop-shadow-[0_0_10px_rgba(239,68,68,0.5)]' : '' ?>" alt="User">
      <h5 class="font-bold mb-0 <?= $is_locked ? 'text-white' : 'text-[#1a1a2e]' ?>"><?= htmlspecialchars($user_nama) ?></h5>
      <small class="text-gray-500"><?= htmlspecialchars($user_nim) ?></small>
    </div>
    
    <ul class="flex flex-col gap-2">
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 bg-blue-600 text-white translate-x-1" href="dashboard_anggota.php">
          <i class="bi bi-grid-fill text-lg"></i> Dashboard
        </a>
      </li>
      <li>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-gray-600 hover:bg-blue-600 hover:text-white hover:translate-x-1" href="peminjaman_user.php">
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
  
  <div class="p-5 border-t <?= $is_locked ? 'border-[#2a2a3e]' : 'border-[#e9ecef]' ?>">
    <a href="../public/logout.php" class="flex items-center justify-center gap-2 w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors font-medium" onclick="return confirmLogout()">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  </div>
</aside>

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 lg:left-[280px] right-0 h-[75px] rounded-b-[20px] z-[1000] flex justify-between items-center px-6 lg:px-10 <?= $is_locked ? 'bg-gradient-to-br from-[#16213e] to-[#0f0f1a] border-b-2 border-red-500 shadow-[0_4px_20px_rgba(239,68,68,0.2)]' : 'bg-white shadow-sm' ?>">
  <div class="flex items-center">
    <button class="bg-transparent border-none text-2xl cursor-pointer p-2 rounded-lg transition-all lg:hidden hover:bg-black/5 hover:scale-105 <?= $is_locked ? 'text-red-500' : 'text-blue-600' ?>" id="openSidebarBtn">
      <i class="bi bi-list"></i>
    </button>
    <h4 class="ml-3 mt-1 font-bold text-lg hidden sm:block <?= $is_locked ? 'text-white' : 'text-blue-600' ?>">📚 Dashboard Perpustakaan</h4>
  </div>
  <div class="flex items-center gap-4">
    <i class="bi bi-bell text-xl <?= $is_locked ? 'text-white' : 'text-gray-600' ?>"></i>
    <a href="../views/auth/profile.php">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="45" class="rounded-full border-2 border-transparent hover:border-blue-500 transition-colors">
    </a>
  </div>
</nav>

<!-- MAIN CONTENT -->
<main class="mt-[75px] p-6 lg:p-8 transition-all duration-300 min-h-[calc(100vh-75px)] lg:ml-[280px]" id="mainContent">

  <div class="mb-8">
    <h1 class="text-3xl font-bold <?= $is_locked ? 'text-white' : 'text-blue-600' ?>">👋 Welcome Back, <?= htmlspecialchars($user_nama) ?>!</h1>
    <p class="mt-2 <?= $is_locked ? 'text-gray-400' : 'text-gray-500' ?>">
      <i class="bi bi-building"></i> Sistem Perpustakaan Digital Modern — Temukan dan pinjam buku favorit Anda
    </p>
  </div>

  <!-- WARNING BANNER jika user terlambat -->
  <?php if($is_locked && !empty($late_books_detail)): ?>
  <div class="animate-fade-up bg-gradient-to-br from-red-800 to-red-900 text-white rounded-2xl p-6 mb-8 flex flex-wrap items-center justify-between gap-4 border border-red-500 shadow-lg shadow-red-500/20">
      <div class="flex items-center gap-4">
          <i class="bi bi-exclamation-octagon-fill text-4xl text-red-200"></i>
          <div>
              <h5 class="text-xl font-bold mb-1">⚠️ AKSES DIBLOKIR - KETERLAMBATAN PENGEMBALIAN</h5>
              <p class="m-0 text-red-100">Anda memiliki <strong><?= $totalTerlambat ?></strong> buku yang terlambat dikembalikan dengan total denda <strong><?= formatRupiah($total_denda) ?></strong></p>
          </div>
      </div>
      <button class="bg-white/20 hover:bg-white/30 border border-white/30 text-white rounded-full px-6 py-3 font-semibold transition-all hover:scale-105" onclick="openFinePaymentModal()">
          <i class="bi bi-calculator-fill mr-2"></i> Lihat & Bayar Denda
      </button>
  </div>
  <?php endif; ?>

  <!-- CARD STATISTIK -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="rounded-3xl p-6 transition-all duration-300 flex flex-col min-h-[180px] animate-fade-up hover:-translate-y-1 <?= $is_locked ? 'bg-[#1e1e2e] border border-[#2a2a3e] hover:border-red-500 hover:shadow-[0_15px_35px_rgba(239,68,68,0.15)]' : 'bg-white shadow-[0_10px_25px_rgba(0,0,0,0.05)] hover:shadow-[0_15px_35px_rgba(0,0,0,0.1)]' ?>">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-2xl mb-4 bg-gradient-to-br from-blue-600 to-blue-800 shadow-lg shadow-blue-500/30">
            <i class="bi bi-book-fill"></i>
        </div>
        <div class="text-3xl font-bold mb-1 <?= $is_locked ? 'text-white' : 'text-[#1a1a2e]' ?>"><?= number_format($totalKoleksi) ?></div>
        <div class="text-sm font-medium <?= $is_locked ? 'text-gray-400' : 'text-gray-500' ?>">Total Koleksi Buku</div>
    </div>
    
    <div class="rounded-3xl p-6 transition-all duration-300 flex flex-col min-h-[180px] animate-fade-up hover:-translate-y-1 <?= $is_locked ? 'bg-[#1e1e2e] border border-[#2a2a3e] hover:border-red-500 hover:shadow-[0_15px_35px_rgba(239,68,68,0.15)]' : 'bg-white shadow-[0_10px_25px_rgba(0,0,0,0.05)] hover:shadow-[0_15px_35px_rgba(0,0,0,0.1)]' ?>" style="animation-delay: 0.1s">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-2xl mb-4 bg-gradient-to-br from-green-600 to-green-800 shadow-lg shadow-green-500/30">
            <i class="bi bi-journal-check"></i>
        </div>
        <div class="text-3xl font-bold mb-1 <?= $is_locked ? 'text-white' : 'text-[#1a1a2e]' ?>"><?= number_format($totalDipinjam) ?></div>
        <div class="text-sm font-medium <?= $is_locked ? 'text-gray-400' : 'text-gray-500' ?>">Dipinjam Aktif</div>
    </div>
    
    <div class="rounded-3xl p-6 transition-all duration-300 flex flex-col min-h-[180px] animate-fade-up hover:-translate-y-1 <?= $is_locked ? 'bg-gradient-to-br from-red-800 to-red-900 text-white border-2 border-red-500 hover:shadow-[0_15px_35px_rgba(239,68,68,0.3)]' : 'bg-white shadow-[0_10px_25px_rgba(0,0,0,0.05)] hover:shadow-[0_15px_35px_rgba(0,0,0,0.1)]' ?>" style="animation-delay: 0.2s">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-2xl mb-4 <?= $is_locked ? 'bg-gradient-to-br from-red-600 to-red-900 shadow-lg shadow-red-500/30' : 'bg-gradient-to-br from-orange-500 to-orange-700 shadow-lg shadow-orange-500/30' ?>">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div class="text-3xl font-bold mb-1 <?= $is_locked ? 'text-white' : 'text-[#1a1a2e]' ?>"><?= $totalTerlambat ?></div>
        <div class="text-sm font-medium <?= $is_locked ? 'text-white/80' : 'text-gray-500' ?>">Terlambat</div>
        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold mt-3 w-fit border <?= $is_locked ? 'bg-red-500/20 text-red-200 border-red-300' : 'bg-yellow-100 text-yellow-800 border-yellow-200' ?>">
            <i class="bi <?= $is_locked ? 'bi-lock-fill' : 'bi-clock-history' ?>"></i>
            <?= $is_locked ? 'AKSES TERKUNCI' : 'Perlu Tindakan' ?>
        </div>
    </div>
  </div>

  <!-- BUKU PALING DIMINATI -->
  <div class="rounded-3xl p-6 lg:p-8 animate-fade-up <?= $is_locked ? 'bg-[#1a1a2e] border border-[#2a2a3e]' : 'bg-white shadow-sm border border-gray-100' ?>" style="animation-delay: 0.3s">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h4 class="text-xl font-bold m-0 <?= $is_locked ? 'text-white' : 'text-[#1a1a2e]' ?>"><i class="bi bi-trophy-fill text-yellow-500 mr-2"></i> Buku Paling Diminati</h4>
        <a href="katalog.php" class="inline-flex items-center gap-2 px-4 py-2 border-2 rounded-full text-sm font-semibold transition-colors <?= $is_locked ? 'border-gray-600 text-gray-500 cursor-not-allowed opacity-70' : 'border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white' ?>" <?= $is_locked ? 'onclick="showLockAlert(); return false;"' : '' ?>>
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <!-- Search Box -->
    <div class="mb-6">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="bi bi-search <?= $is_locked ? 'text-gray-500' : 'text-gray-400' ?>"></i>
            </div>
            <input type="text" id="searchBookInput" class="w-full pl-11 pr-4 py-3 rounded-full border focus:outline-none focus:ring-2 transition-all <?= $is_locked ? 'bg-[#252540] border-[#3a3a5e] text-gray-300 placeholder-gray-500 focus:ring-red-500 focus:border-red-500 cursor-not-allowed' : 'bg-gray-50 border-gray-200 text-gray-700 placeholder-gray-400 focus:bg-white focus:ring-blue-500 focus:border-blue-500' ?>" placeholder="Cari buku favorit..." <?= $is_locked ? 'disabled' : '' ?>>
        </div>
    </div>

    <?php if(!$is_locked): ?>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4" id="bookGrid">
        <?php if(empty($bukuPopuler)): ?>
        <div class="text-center text-gray-500 py-8 col-span-full">Belum ada data buku</div>
        <?php else: ?>
        <?php $i=0; foreach($bukuPopuler as $book): $i++; ?>
        <div class="flex gap-4 p-3 rounded-2xl border cursor-pointer animate-card-fade-in transition-all duration-300 bg-gray-50 border-gray-200 hover:-translate-y-1 hover:shadow-md hover:border-blue-500 group" style="animation-delay: <?= $i*0.05 ?>s" onclick="window.location.href='katalog.php'">
            <div class="w-14 h-[75px] rounded-xl flex items-center justify-center text-3xl shrink-0 group-hover:scale-105 transition-transform" style="background: <?= getCoverBg($book['kategori_id'] ?? 1); ?>;">
                <?= getCoverEmoji($book['kategori_id'] ?? 1); ?>
            </div>
            <div class="flex flex-col justify-center">
                <h6 class="text-sm font-bold text-gray-800 mb-1 line-clamp-1"><?= htmlspecialchars($book['judul']); ?></h6>
                <p class="text-xs text-gray-500 mb-2 line-clamp-1"><?= htmlspecialchars($book['penulis']); ?></p>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold w-fit <?= getBadgeClass($book) === 'badge-tersedia' ? 'bg-green-100 text-green-700' : (getBadgeClass($book) === 'badge-habis' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') ?>">
                    <?= getBadgeText($book); ?>
                </span>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="text-center p-10 rounded-3xl border-2 border-red-500 bg-gradient-to-br from-[#1e1e2e] to-[#0f0f1a]">
        <i class="bi bi-lock-fill text-7xl text-red-500 mb-4 inline-block"></i>
        <h5 class="font-bold mb-3 text-red-300 text-xl">⚠️ AKSES DITOLAK</h5>
        <p class="text-gray-400 mb-6 max-w-md mx-auto">Anda tidak dapat mengakses Katalog Buku karena memiliki keterlambatan pengembalian.</p>
        <button class="bg-red-600 hover:bg-red-700 text-white rounded-full px-8 py-3 font-semibold transition-all hover:scale-105 shadow-lg shadow-red-500/30" onclick="openFinePaymentModal()">
            <i class="bi bi-cash-stack mr-2"></i> Lihat & Bayar Denda
        </button>
    </div>
    <?php endif; ?>

    <div id="noBookResult" class="text-center text-gray-500 py-8 hidden">
        <i class="bi bi-emoji-frown text-5xl mb-3 inline-block"></i>
        <p>Buku tidak ditemukan</p>
    </div>

  </div>

</main>

<!-- MODAL DETAIL DENDA & PEMBAYARAN -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[1060] flex items-center justify-center opacity-0 invisible transition-all duration-300 p-4" id="finePaymentModalOverlay">
    <div class="rounded-[28px] w-full max-w-5xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.3)] transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-hidden flex flex-col <?= $is_locked ? 'bg-[#1a1a2e]' : 'bg-white' ?>" id="finePaymentModalBox">
        <div class="overflow-y-auto w-full">
            <div class="bg-gradient-to-br from-red-600 to-red-800 p-5 flex justify-between items-center text-white sticky top-0 z-10">
                <h5 class="text-xl font-bold m-0 flex items-center gap-2"><i class="bi bi-calculator-fill"></i> Detail Denda & Pembayaran</h5>
                <button type="button" class="text-white hover:text-gray-200 text-2xl leading-none bg-transparent border-0 cursor-pointer" onclick="closeFinePaymentModal()">&times;</button>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <!-- KIRI: Daftar Buku -->
                    <div class="lg:col-span-7 space-y-4">
                        <div class="border rounded-2xl p-4 flex flex-wrap justify-between items-center gap-3 <?= $is_locked ? 'bg-[#252540] border-[#3a3a5e]' : 'bg-gray-50 border-gray-200' ?>">
                            <h6 class="font-bold m-0 flex items-center gap-2 <?= $is_locked ? 'text-white' : 'text-gray-800' ?>">
                                <i class="bi bi-journal-bookmark-fill text-red-500"></i> Daftar Buku Terlambat
                            </h6>
                            <div class="flex gap-2">
                                <?php 
                                $hasUnpaidBooks = false;
                                foreach($late_books_detail as $book) {
                                    if(($book['denda_status'] ?? '') !== 'pending') {
                                        $hasUnpaidBooks = true;
                                        break;
                                    }
                                }
                                ?>
                                <?php if($is_locked && $hasUnpaidBooks): ?>
                                <button class="px-3 py-1.5 text-xs font-semibold border rounded-full transition-colors <?= $is_locked ? 'border-red-500 text-red-400 hover:bg-red-500 hover:text-white' : 'border-red-500 text-red-500 hover:bg-red-50' ?>" onclick="selectAllBooks()">
                                    <i class="bi bi-check-all"></i> Pilih Semua
                                </button>
                                <button class="px-3 py-1.5 text-xs font-semibold border rounded-full transition-colors <?= $is_locked ? 'border-gray-500 text-gray-400 hover:bg-gray-600 hover:text-white' : 'border-gray-400 text-gray-600 hover:bg-gray-100' ?>" onclick="deselectAllBooks()">
                                    <i class="bi bi-x-circle"></i> Batal
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div id="fineBooksList" class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                            <?php if(empty($late_books_detail)): ?>
                                <div class="text-center py-12">
                                    <i class="bi bi-emoji-smile text-6xl text-green-500 mb-4 inline-block"></i>
                                    <h5 class="font-bold text-xl mb-2 <?= $is_locked ? 'text-white' : 'text-gray-800' ?>">🎉 Tidak ada buku yang terlambat!</h5>
                                    <p class="text-gray-500">Semua peminjaman Anda dalam status baik.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach($late_books_detail as $index => $book): 
                                    $fine_amount = $book['late_days'] * $denda_per_hari;
                                    $denda_status = $book['denda_status'] ?? 'unpaid';
                                    $is_waiting_confirmation = ($denda_status === 'pending');
                                    $kode_konfirmasi = $book['kode_konfirmasi'] ?? '';
                                ?>
                                <div class="fine-item-card <?= $is_waiting_confirmation ? 'waiting-confirmation' : '' ?> p-4 rounded-2xl border-2 transition-all cursor-pointer relative <?= $is_waiting_confirmation ? ($is_locked ? 'bg-[#2e2e50] border-yellow-500 opacity-95' : 'bg-yellow-50 border-yellow-500 opacity-95') : ($is_locked ? 'bg-[#252540] border-[#3a3a5e] hover:border-red-500' : 'bg-white border-gray-200 hover:border-red-500 hover:shadow-md') ?>" 
                                     data-id="<?= $book['buku_id'] ?>" 
                                     data-peminjaman-id="<?= $book['id'] ?>" 
                                     data-late-days="<?= $book['late_days'] ?>" 
                                     data-denda-status="<?= $denda_status ?>"
                                     onclick="<?= !$is_waiting_confirmation && $is_locked ? 'toggleSelectFineBook(this, event)' : '' ?>">
                                    
                                    <div class="flex items-start gap-4">
                                        <?php if($is_waiting_confirmation): ?>
                                            <div class="w-8 h-8 rounded-full bg-yellow-100 border-2 border-yellow-500 flex items-center justify-center animate-pulse shrink-0">
                                                <i class="bi bi-hourglass-split text-yellow-600 text-sm"></i>
                                            </div>
                                        <?php else: ?>
                                            <div class="custom-checkbox w-6 h-6 rounded border-2 border-red-500 flex items-center justify-center shrink-0 transition-colors mt-1 <?= $is_locked ? 'bg-[#252540]' : 'bg-white' ?>" id="fineCheckbox_<?= $book['buku_id'] ?>">
                                                <i class="bi bi-check-lg text-sm opacity-0 text-white transition-opacity"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="w-12 h-16 rounded-xl flex items-center justify-center text-3xl shrink-0" style="background: <?= getCoverBg($book['kategori_id'] ?? 1); ?>;">
                                            <?= getCoverEmoji($book['kategori_id'] ?? 1); ?>
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap justify-between items-start gap-2 mb-2">
                                                <h6 class="font-bold m-0 text-base line-clamp-1 <?= $is_locked ? 'text-white' : 'text-gray-900' ?>">
                                                    <?= htmlspecialchars($book['judul']) ?>
                                                </h6>
                                                <?php if($is_waiting_confirmation): ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-100 text-yellow-800 text-[10px] font-bold rounded-full">
                                                        <i class="bi bi-clock-history"></i> Menunggu Konfirmasi
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-full">
                                                        <i class="bi bi-exclamation-triangle"></i> Belum Dibayar
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-2 mb-3">
                                                <div>
                                                    <small class="text-gray-500 text-[10px] block mb-0.5">📅 Jatuh Tempo</small>
                                                    <div class="font-semibold text-xs <?= $is_locked ? 'text-gray-300' : 'text-gray-700' ?>"><?= formatDate($book['tanggal_kembali']) ?></div>
                                                </div>
                                                <div>
                                                    <small class="text-gray-500 text-[10px] block mb-0.5">⏰ Terlambat</small>
                                                    <div class="font-semibold text-xs text-red-500"><?= $book['late_days'] ?> Hari</div>
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-between items-center bg-black/5 p-2 rounded-lg <?= $is_locked ? 'bg-white/5' : 'bg-gray-50' ?>">
                                                <span class="text-[10px] font-medium <?= $is_locked ? 'text-yellow-400' : 'text-yellow-600' ?>">Denda: <?= formatRupiah($denda_per_hari) ?>/hari</span>
                                                <strong class="text-sm <?= $is_waiting_confirmation ? 'text-yellow-500' : 'text-red-600' ?>" id="fineAmount_<?= $book['buku_id'] ?>">
                                                    <?= $is_waiting_confirmation ? 'Menunggu...' : formatRupiah($fine_amount) ?>
                                                </strong>
                                            </div>
                                            
                                            <?php if($is_waiting_confirmation && $kode_konfirmasi): ?>
                                            <div class="mt-3 pt-3 border-t <?= $is_locked ? 'border-gray-700' : 'border-gray-200' ?>">
                                                <div class="flex items-center justify-between">
                                                    <small class="text-gray-500 flex items-center gap-2">
                                                        <i class="bi bi-upc-scan"></i> Kode: 
                                                        <code class="font-bold text-gray-900 bg-gray-200 px-2 py-0.5 rounded <?= $is_locked ? 'text-gray-200 bg-gray-700' : '' ?>"><?= htmlspecialchars($kode_konfirmasi) ?></code>
                                                    </small>
                                                    <a href="konfirmasi_pembayaran.php?kode=<?= $kode_konfirmasi ?>" class="text-xs font-semibold text-blue-600 hover:underline" target="_blank">
                                                        Detail <i class="bi bi-box-arrow-up-right ml-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- KANAN: Total & Pembayaran -->
                    <div class="lg:col-span-5 space-y-6">
                        <?php
                        $allWaiting = true;
                        $anyUnpaid = false;
                        foreach($late_books_detail as $book) {
                            $denda_status = $book['denda_status'] ?? 'unpaid';
                            if($denda_status !== 'pending') {
                                $allWaiting = false;
                                $anyUnpaid = true;
                            }
                        }
                        ?>
                        
                        <?php if($allWaiting && !empty($late_books_detail)): ?>
                            <div class="text-center p-6 border rounded-3xl <?= $is_locked ? 'bg-[#252540] border-[#3a3a5e]' : 'bg-yellow-50 border-yellow-200' ?>">
                                <div class="w-16 h-16 bg-yellow-100 rounded-full border-2 border-yellow-400 flex items-center justify-center text-3xl mx-auto mb-4 animate-pulse">
                                    <i class="bi bi-hourglass-split text-yellow-600"></i>
                                </div>
                                <h5 class="font-bold text-lg text-yellow-600 mb-2">Menunggu Konfirmasi</h5>
                                <p class="text-sm text-gray-600 mb-4 <?= $is_locked ? 'text-gray-400' : '' ?>">Semua buku yang terlambat sudah dalam proses konfirmasi pembayaran oleh Admin.</p>
                                <?php 
                                $firstKode = $late_books_detail[0]['kode_konfirmasi'] ?? '';
                                if($firstKode):
                                ?>
                                <a href="konfirmasi_pembayaran.php?kode=<?= $firstKode ?>" class="inline-block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-4 rounded-xl transition-colors">
                                    <i class="bi bi-eye mr-2"></i> Lihat Status
                                </a>
                                <?php endif; ?>
                            </div>
                        <?php elseif($anyUnpaid): ?>
                            <div class="bg-gradient-to-br from-red-600 to-red-800 rounded-3xl p-6 text-white text-center shadow-lg">
                                <i class="bi bi-receipt text-3xl mb-2 inline-block opacity-80"></i>
                                <h6 class="text-red-100 font-medium mb-1">Total Yang Akan Dibayar</h6>
                                <div class="text-4xl font-black mb-3" id="totalFineAmountDisplay">Rp 0</div>
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-black/20 rounded-full text-[11px] text-red-100">
                                    <i class="bi bi-info-circle"></i> Denda terus bertambah setiap hari
                                </div>
                            </div>
                            
                            <div class="border rounded-2xl p-5 <?= $is_locked ? 'bg-[#252540] border-[#3a3a5e]' : 'bg-gray-50 border-gray-200' ?>">
                                <h6 class="font-bold mb-4 flex items-center gap-2 <?= $is_locked ? 'text-white' : 'text-gray-800' ?>">
                                    <i class="bi bi-credit-card text-blue-500"></i> Metode Pembayaran
                                </h6>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="payment-card border-2 rounded-xl p-3 text-center cursor-pointer transition-all <?= $is_locked ? 'bg-[#1a1a2e] border-[#3a3a5e] hover:border-blue-500 text-gray-300' : 'bg-white border-gray-200 hover:border-blue-500 text-gray-600' ?>" data-method="qris" onclick="selectPaymentMethod('qris')">
                                        <i class="bi bi-qr-code-scan text-2xl mb-1 block <?= $is_locked ? 'text-gray-400' : 'text-gray-400' ?>"></i>
                                        <div class="font-bold text-sm">QRIS</div>
                                        <div class="text-[10px] text-gray-500">Scan QR Code</div>
                                    </div>
                                    <div class="payment-card border-2 rounded-xl p-3 text-center cursor-pointer transition-all <?= $is_locked ? 'bg-[#1a1a2e] border-[#3a3a5e] hover:border-blue-500 text-gray-300' : 'bg-white border-gray-200 hover:border-blue-500 text-gray-600' ?>" data-method="transfer" onclick="selectPaymentMethod('transfer')">
                                        <i class="bi bi-bank text-2xl mb-1 block <?= $is_locked ? 'text-gray-400' : 'text-gray-400' ?>"></i>
                                        <div class="font-bold text-sm">Transfer</div>
                                        <div class="text-[10px] text-gray-500">BCA/BRI/Mandiri</div>
                                    </div>
                                    <div class="payment-card border-2 rounded-xl p-3 text-center cursor-pointer transition-all <?= $is_locked ? 'bg-[#1a1a2e] border-[#3a3a5e] hover:border-blue-500 text-gray-300' : 'bg-white border-gray-200 hover:border-blue-500 text-gray-600' ?>" data-method="ewallet" onclick="selectPaymentMethod('ewallet')">
                                        <i class="bi bi-phone text-2xl mb-1 block <?= $is_locked ? 'text-gray-400' : 'text-gray-400' ?>"></i>
                                        <div class="font-bold text-sm">E-Wallet</div>
                                        <div class="text-[10px] text-gray-500">OVO/GoPay/DANA</div>
                                    </div>
                                    <div class="payment-card border-2 rounded-xl p-3 text-center cursor-pointer transition-all <?= $is_locked ? 'bg-[#1a1a2e] border-[#3a3a5e] hover:border-blue-500 text-gray-300' : 'bg-white border-gray-200 hover:border-blue-500 text-gray-600' ?>" data-method="tunai" onclick="selectPaymentMethod('tunai')">
                                        <i class="bi bi-cash-stack text-2xl mb-1 block <?= $is_locked ? 'text-gray-400' : 'text-gray-400' ?>"></i>
                                        <div class="font-bold text-sm">Tunai</div>
                                        <div class="text-[10px] text-gray-500">Di perpustakaan</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-2 border-dashed rounded-2xl p-6 text-center <?= $is_locked ? 'bg-[#1a1a2e] border-[#3a3a5e]' : 'bg-white border-gray-200' ?>" id="paymentDetailBox">
                                <div class="w-32 h-32 mx-auto mb-4 rounded-xl flex items-center justify-center text-5xl <?= $is_locked ? 'bg-[#252540] text-gray-600' : 'bg-gray-100 text-gray-400' ?>" id="qrPlaceholder">
                                    <i class="bi bi-qr-code"></i>
                                </div>
                                <h6 class="font-bold mb-1 <?= $is_locked ? 'text-white' : 'text-gray-800' ?>" id="paymentTitle">Pilih Metode Pembayaran</h6>
                                <p class="text-xs text-gray-500 m-0" id="paymentDesc">Silakan pilih salah satu metode di atas</p>
                            </div>
                            
                            <button class="w-full py-4 rounded-full font-bold text-white transition-all disabled:opacity-50 disabled:cursor-not-allowed bg-red-600 hover:bg-red-700 hover:shadow-[0_8px_20px_rgba(220,38,38,0.3)]" id="payFineButton" onclick="processFinePayment()" disabled>
                                <i class="bi bi-lock-fill mr-2"></i> Pilih Buku Terlebih Dahulu
                            </button>
                        <?php else: ?>
                            <div class="text-center p-8 border rounded-3xl <?= $is_locked ? 'bg-[#252540] border-[#3a3a5e]' : 'bg-green-50 border-green-200' ?>">
                                <i class="bi bi-check-circle-fill text-6xl text-green-500 mb-4 inline-block"></i>
                                <h5 class="font-bold text-xl text-green-600 mb-2">Tidak Ada Denda</h5>
                                <p class="text-gray-500 mb-0">Terima kasih telah mengembalikan tepat waktu.</p>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
            
            <div class="p-4 border-t flex justify-end <?= $is_locked ? 'bg-[#16213e] border-[#2a2a3e]' : 'bg-gray-50 border-gray-200' ?>">
                <button type="button" class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-xl transition-colors" onclick="closeFinePaymentModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="fixed top-5 right-5 z-[9999] flex flex-col gap-3"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ==================== SIDEBAR ====================
let isSidebarOpen = false;
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
const openBtn = document.getElementById('openSidebarBtn');
const closeBtn = document.getElementById('closeSidebarBtn');
const body = document.body;

function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('opacity-0', 'invisible');
    overlay.classList.add('opacity-100', 'visible');
    isSidebarOpen = true;
    if (window.innerWidth < 1024) body.style.overflow = 'hidden';
}

function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.remove('opacity-100', 'visible');
    overlay.classList.add('opacity-0', 'invisible');
    isSidebarOpen = false;
    if (window.innerWidth < 1024) body.style.overflow = '';
}

if (openBtn) openBtn.addEventListener('click', openSidebar);
if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
if (overlay) overlay.addEventListener('click', closeSidebar);
document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && isSidebarOpen) closeSidebar(); });

// ==================== DATA DARI PHP ====================
let lateBooks = <?php echo json_encode($late_books_detail); ?>;
const isLocked = <?php echo json_encode($is_locked); ?>;
const dendaPerHari = <?php echo $denda_per_hari; ?>;

let selectedFineBooks = new Set();
let selectedPaymentMethod = null;
let statusCheckInterval = null;

// ==================== FUNGSI UMUM ====================
function formatRupiah(amount) {
    return 'Rp ' + amount.toLocaleString('id-ID');
}

function formatDate(dateString) {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function showToast(title, message, type = 'success', duration = 4000) {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
    const toastId = 'toast_' + Date.now();
    const icons = { success: 'bi-check-circle', error: 'bi-x-circle', warning: 'bi-exclamation-triangle', info: 'bi-info-circle' };
    const icon = icons[type] || 'bi-info-circle';
    const bgColors = { success: 'bg-green-100 text-green-600', error: 'bg-red-100 text-red-600', warning: 'bg-yellow-100 text-yellow-600', info: 'bg-blue-100 text-blue-600' };
    const borderColors = { success: 'border-green-500', error: 'border-red-500', warning: 'border-yellow-500', info: 'border-blue-500' };
    
    const toastHTML = `
        <div id="${toastId}" class="bg-white rounded-xl shadow-lg border-l-4 ${borderColors[type]} flex items-start gap-3 p-4 min-w-[300px] max-w-[400px] transform transition-all duration-300 translate-x-full">
            <div class="w-8 h-8 rounded-full ${bgColors[type]} flex items-center justify-center shrink-0">
                <i class="bi ${icon} text-lg"></i>
            </div>
            <div class="flex-1">
                <h6 class="font-bold text-gray-800 m-0 text-sm">${title}</h6>
                <p class="text-gray-500 text-xs m-0 mt-1">${message}</p>
            </div>
            <button class="text-gray-400 hover:text-gray-700" onclick="this.closest('#${toastId}').remove()"><i class="bi bi-x-lg"></i></button>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', toastHTML);
    const toastEl = document.getElementById(toastId);
    
    // Animate in
    setTimeout(() => { toastEl.classList.remove('translate-x-full'); }, 10);
    
    // Auto remove
    setTimeout(() => { 
        if(toastEl) {
            toastEl.classList.add('translate-x-full');
            setTimeout(() => toastEl.remove(), 300);
        }
    }, duration);
}

// ==================== AUTO CHECK STATUS ====================
function startStatusCheck() {
    if (statusCheckInterval) clearInterval(statusCheckInterval);
    
    statusCheckInterval = setInterval(function() {
        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'action=get_latest_denda_status'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.has_unpaid === false && data.all_waiting === true) {
                if (statusCheckInterval) clearInterval(statusCheckInterval);
                showToast('✅ Status Berubah', 'Pembayaran Anda sedang diproses admin', 'success', 3000);
                setTimeout(() => location.reload(), 2000);
            }
        })
        .catch(error => console.log('Check status error:', error));
    }, 5000);
}

// ==================== FUNGSI PEMBAYARAN DENDA ====================
function openFinePaymentModal() {
    selectedFineBooks.clear();
    selectedPaymentMethod = null;
    updateFineTotal();
    updatePayButton();
    
    document.querySelectorAll('.payment-card').forEach(card => card.classList.remove('selected'));
    
    const qrPlaceholder = document.getElementById('qrPlaceholder');
    const paymentTitle = document.getElementById('paymentTitle');
    const paymentDesc = document.getElementById('paymentDesc');
    if(qrPlaceholder) {
        qrPlaceholder.innerHTML = '<i class="bi bi-qr-code"></i>';
        qrPlaceholder.className = `w-32 h-32 mx-auto mb-4 rounded-xl flex items-center justify-center text-5xl ${isLocked ? 'bg-[#252540] text-gray-600' : 'bg-gray-100 text-gray-400'}`;
    }
    if(paymentTitle) paymentTitle.innerHTML = 'Pilih Metode Pembayaran';
    if(paymentDesc) paymentDesc.innerHTML = 'Silakan pilih salah satu metode di atas';
    const overlay = document.getElementById('finePaymentModalOverlay');
    const box = document.getElementById('finePaymentModalBox');
    if (overlay && box) {
        overlay.classList.remove('opacity-0', 'invisible');
        box.classList.remove('scale-95');
        box.classList.add('scale-100');
        document.body.classList.add('overflow-hidden');
    }
}

function closeFinePaymentModal() {
    const overlay = document.getElementById('finePaymentModalOverlay');
    const box = document.getElementById('finePaymentModalBox');
    if (overlay && box) {
        overlay.classList.add('opacity-0', 'invisible');
        box.classList.remove('scale-100');
        box.classList.add('scale-95');
        document.body.classList.remove('overflow-hidden');
    }
}

function toggleSelectFineBook(element, event) {
    const bookId = element.dataset.id;
    const checkbox = document.getElementById('fineCheckbox_' + bookId);
    
    if (selectedFineBooks.has(bookId)) {
        selectedFineBooks.delete(bookId);
        if(isLocked) {
            element.classList.remove('border-red-500', 'bg-[#2e2e50]');
            element.classList.add('border-[#3a3a5e]', 'bg-[#252540]');
        } else {
            element.classList.remove('border-red-500', 'bg-red-50');
            element.classList.add('border-gray-200', 'bg-white');
        }
        if (checkbox) checkbox.classList.remove('checked');
    } else {
        selectedFineBooks.add(bookId);
        if(isLocked) {
            element.classList.remove('border-[#3a3a5e]', 'bg-[#252540]');
            element.classList.add('border-red-500', 'bg-[#2e2e50]');
        } else {
            element.classList.remove('border-gray-200', 'bg-white');
            element.classList.add('border-red-500', 'bg-red-50');
        }
        if (checkbox) checkbox.classList.add('checked');
    }
    
    updateFineTotal();
    updatePayButton();
}

function selectAllBooks() {
    document.querySelectorAll('.fine-item-card:not(.waiting-confirmation)').forEach(card => {
        const bookId = card.dataset.id;
        if (!selectedFineBooks.has(bookId)) {
            selectedFineBooks.add(bookId);
            const checkbox = document.getElementById('fineCheckbox_' + bookId);
            if(isLocked) {
                card.classList.remove('border-[#3a3a5e]', 'bg-[#252540]');
                card.classList.add('border-red-500', 'bg-[#2e2e50]');
            } else {
                card.classList.remove('border-gray-200', 'bg-white');
                card.classList.add('border-red-500', 'bg-red-50');
            }
            if (checkbox) checkbox.classList.add('checked');
        }
    });
    updateFineTotal();
    updatePayButton();
}

function deselectAllBooks() {
    selectedFineBooks.clear();
    document.querySelectorAll('.fine-item-card').forEach(card => {
        const checkbox = document.getElementById('fineCheckbox_' + card.dataset.id);
        if(isLocked) {
            card.classList.remove('border-red-500', 'bg-[#2e2e50]');
            card.classList.add('border-[#3a3a5e]', 'bg-[#252540]');
        } else {
            card.classList.remove('border-red-500', 'bg-red-50');
            card.classList.add('border-gray-200', 'bg-white');
        }
        if (checkbox) checkbox.classList.remove('checked');
    });
    updateFineTotal();
    updatePayButton();
}

function updateFineTotal() {
    let total = 0;
    selectedFineBooks.forEach(bookId => {
        const book = lateBooks.find(b => b.buku_id == bookId);
        if (book) {
            const lateDays = parseInt(book.late_days) || 0;
            total += lateDays * dendaPerHari;
        }
    });
    const totalDisplay = document.getElementById('totalFineAmountDisplay');
    if (totalDisplay) totalDisplay.innerHTML = formatRupiah(total);
}

function updatePayButton() {
    const payButton = document.getElementById('payFineButton');
    if (payButton) {
        if (selectedFineBooks.size > 0 && selectedPaymentMethod) {
            let total = 0;
            selectedFineBooks.forEach(bookId => {
                const book = lateBooks.find(b => b.buku_id == bookId);
                if (book) {
                    const lateDays = parseInt(book.late_days) || 0;
                    total += lateDays * dendaPerHari;
                }
            });
            payButton.disabled = false;
            payButton.innerHTML = '<i class="bi bi-cash-stack mr-2"></i> Bayar ' + formatRupiah(total);
        } else if (selectedFineBooks.size > 0) {
            payButton.disabled = true;
            payButton.innerHTML = '<i class="bi bi-credit-card mr-2"></i> Pilih Metode Pembayaran';
        } else {
            payButton.disabled = true;
            payButton.innerHTML = '<i class="bi bi-lock-fill mr-2"></i> Pilih Buku Terlebih Dahulu';
        }
    }
}

function selectPaymentMethod(method) {
    selectedPaymentMethod = method;
    
    document.querySelectorAll('.payment-card').forEach(card => card.classList.remove('selected'));
    const selectedCard = document.querySelector(`.payment-card[data-method="${method}"]`);
    if (selectedCard) selectedCard.classList.add('selected');
    
    const qrPlaceholder = document.getElementById('qrPlaceholder');
    const paymentTitle = document.getElementById('paymentTitle');
    const paymentDesc = document.getElementById('paymentDesc');
    
    if (qrPlaceholder && paymentTitle && paymentDesc) {
        qrPlaceholder.className = `w-32 h-32 mx-auto mb-4 rounded-xl flex items-center justify-center text-5xl bg-red-100 text-red-500`;
        switch(method) {
            case 'qris':
                qrPlaceholder.innerHTML = '<i class="bi bi-qr-code"></i>';
                paymentTitle.innerHTML = 'Scan QR Code untuk membayar';
                paymentDesc.innerHTML = 'Gunakan aplikasi mobile banking atau e-wallet';
                break;
            case 'transfer':
                qrPlaceholder.innerHTML = '<i class="bi bi-bank"></i>';
                paymentTitle.innerHTML = 'Transfer Bank';
                paymentDesc.innerHTML = 'BCA: 1234567890 a.n Perpustakaan<br>BRI: 0987654321 a.n Perpustakaan';
                break;
            case 'ewallet':
                qrPlaceholder.innerHTML = '<i class="bi bi-phone"></i>';
                paymentTitle.innerHTML = 'Pembayaran E-Wallet';
                paymentDesc.innerHTML = 'OVO/GoPay/DANA: 081234567890';
                break;
            case 'tunai':
                qrPlaceholder.innerHTML = '<i class="bi bi-cash-stack"></i>';
                paymentTitle.innerHTML = 'Pembayaran Tunai';
                paymentDesc.innerHTML = 'Silakan datang ke petugas perpustakaan';
                break;
        }
    }
    
    updatePayButton();
}

function processFinePayment() {
    if (selectedFineBooks.size === 0) {
        showToast('⚠️ Peringatan', 'Pilih buku terlebih dahulu!', 'warning');
        return;
    }
    
    if (!selectedPaymentMethod) {
        showToast('⚠️ Peringatan', 'Pilih metode pembayaran terlebih dahulu!', 'warning');
        return;
    }
    
    let totalDenda = 0;
    const bookTitles = [];
    const bookData = [];
    
    selectedFineBooks.forEach(bookId => {
        const book = lateBooks.find(b => b.buku_id == bookId);
        if (book) {
            const lateDays = parseInt(book.late_days) || 0;
            totalDenda += lateDays * dendaPerHari;
            bookTitles.push(book.judul);
            bookData.push({
                id: book.buku_id,
                late_days: lateDays,
                judul: book.judul
            });
        }
    });
    
    if (selectedPaymentMethod === 'tunai') {
        Swal.fire({
            title: '💰 Pembayaran Tunai',
            html: `
                <div style="text-align: left;">
                    <p><strong>Total Denda:</strong> ${formatRupiah(totalDenda)}</p>
                    <p><strong>Buku:</strong> ${bookTitles.join(', ')}</p>
                    <hr>
                    <p><i class="bi bi-info-circle"></i> Instruksi Pembayaran:</p>
                    <ol style="text-align: left;">
                        <li>Klik "Bayar" untuk mendapatkan kode konfirmasi</li>
                        <li>Datang ke petugas perpustakaan</li>
                        <li>Tunjukkan kode konfirmasi kepada petugas</li>
                        <li>Lakukan pembayaran tunai</li>
                        <li>Petugas akan memverifikasi dan memulihkan akses Anda</li>
                    </ol>
                    <p class="text-muted mt-2"><i class="bi bi-info-circle"></i> Halaman akan otomatis refresh setelah status berubah.</p>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                const bookIds = bookData.map(b => b.id).join(',');
                processPaymentToServer(bookIds, selectedPaymentMethod, totalDenda);
            }
        });
    } else {
        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            html: `
                <p><strong>Total:</strong> ${formatRupiah(totalDenda)}</p>
                <p><strong>Metode:</strong> ${selectedPaymentMethod.toUpperCase()}</p>
                <p><strong>Buku:</strong> ${bookTitles.join(', ')}</p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Bayar Sekarang',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745'
        }).then((result) => {
            if (result.isConfirmed) {
                const bookIds = bookData.map(b => b.id).join(',');
                processPaymentToServer(bookIds, selectedPaymentMethod, totalDenda);
            }
        });
    }
}

function processPaymentToServer(bookIds, method, total) {
    const payButton = document.getElementById('payFineButton');
    const originalText = payButton ? payButton.innerHTML : '';
    if (payButton) {
        payButton.disabled = true;
        payButton.innerHTML = '<i class="bi bi-hourglass-split mr-2"></i> Memproses...';
    }
    
    fetch(window.location.href, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `action=pay_fine&book_ids=${bookIds}&method=${method}&total=${total}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (method === 'tunai') {
                startStatusCheck();
                closeFinePaymentModal();
                showToast('⏳ Menunggu Konfirmasi', 'Status pembayaran akan diperbarui otomatis', 'info', 5000);
                
                Swal.fire({
                    title: '💰 Menunggu Konfirmasi',
                    html: `
                        <div style="text-align: left;">
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill"></i> ${data.message}
                            </div>
                            <div class="alert alert-info mt-3" style="background: #e3f2fd;">
                                <strong>Kode Konfirmasi Anda:</strong><br>
                                <code style="font-size: 28px; font-weight: bold; letter-spacing: 2px;">${data.kode_konfirmasi}</code>
                            </div>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Simpan Kode',
                    confirmButtonColor: '#ffc107',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(`konfirmasi_pembayaran.php?kode=${data.kode_konfirmasi}&status=pending`, '_blank');
                    }
                });
            } else {
                Swal.fire({
                    title: '✅ Pembayaran Berhasil',
                    html: `<p>${data.message}</p><p>Akses Anda telah dipulihkan.</p>`,
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    location.reload();
                });
            }
        } else {
            Swal.fire({
                title: '❌ Pembayaran Gagal',
                text: data.message,
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            if (payButton) {
                payButton.disabled = false;
                payButton.innerHTML = originalText;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: '❌ Error',
            text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
            icon: 'error'
        });
        if (payButton) {
            payButton.disabled = false;
            payButton.innerHTML = originalText;
        }
    });
}

// ==================== FUNGSI LAINNYA ====================
function showLockAlert() {
    Swal.fire({
        title: '⚠️ AKSES DITOLAK!',
        text: 'Anda memiliki buku yang terlambat dikembalikan. Silahkan selesaikan kewajiban Anda terlebih dahulu untuk mengakses fitur ini.',
        icon: 'warning',
        confirmButtonColor: '#dc3545'
    });
}

function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah Anda yakin ingin logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../public/logout.php';
        }
    });
    return false;
}

// ==================== SEARCH BUKU ====================
let searchTimeout;
const searchInput = document.getElementById('searchBookInput');

if(searchInput && !isLocked) {
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const keyword = e.target.value;
        
        searchTimeout = setTimeout(() => {
            if (keyword.trim() === '') {
                location.reload();
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `action=search&keyword=${encodeURIComponent(keyword)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) updateBookGrid(data.books);
            })
            .catch(error => console.error('Error:', error));
        }, 300);
    });
}

function updateBookGrid(books) {
    const grid = document.getElementById('bookGrid');
    const noResultDiv = document.getElementById('noBookResult');
    
    if (books.length === 0) {
        if (grid) grid.innerHTML = '';
        if (noResultDiv) noResultDiv.classList.remove('hidden');
        return;
    }
    
    if (noResultDiv) noResultDiv.classList.add('hidden');
    if (grid) {
        grid.style.opacity = '0';
        grid.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            grid.innerHTML = books.map((book, index) => {
                const badgeText = book.stok <= 0 ? 'Habis' : (book.stok <= 3 ? book.stok + ' Tersisa' : 'Tersedia');
                const badgeClass = book.stok <= 0 ? 'bg-red-100 text-red-700' : (book.stok <= 3 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700');
                
                return `
                <div class="flex gap-4 p-3 rounded-2xl border cursor-pointer animate-card-fade-in transition-all duration-300 bg-gray-50 border-gray-200 hover:-translate-y-1 hover:shadow-md hover:border-blue-500 group" style="animation-delay: ${index * 0.05}s" onclick="window.location.href='katalog.php'">
                    <div class="w-14 h-[75px] rounded-xl flex items-center justify-center text-3xl shrink-0 group-hover:scale-105 transition-transform" style="background: ${book.bg || '#d4eaf4'};">
                        ${book.cover || '📔'}
                    </div>
                    <div class="flex flex-col justify-center">
                        <h6 class="text-sm font-bold text-gray-800 mb-1 line-clamp-1">${escapeHtml(book.judul)}</h6>
                        <p class="text-xs text-gray-500 mb-2 line-clamp-1">${escapeHtml(book.penulis)}</p>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold w-fit ${badgeClass}">
                            ${badgeText}
                        </span>
                    </div>
                </div>
                `;
            }).join('');
            
            grid.style.opacity = '1';
            grid.style.transform = 'translateY(0)';
            grid.style.transition = 'all 0.3s ease';
        }, 200);
    }
}

// Ekspose fungsi ke global
window.showLockAlert = showLockAlert;
window.confirmLogout = confirmLogout;
window.openFinePaymentModal = openFinePaymentModal;
window.toggleSelectFineBook = toggleSelectFineBook;
window.selectAllBooks = selectAllBooks;
window.deselectAllBooks = deselectAllBooks;
window.selectPaymentMethod = selectPaymentMethod;
window.processFinePayment = processFinePayment;
</script>

</body>
</html>