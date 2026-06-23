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
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Peminjaman - Sistem Perpustakaan Digital</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --bg:#f4f7fe;
  --card-bg:#ffffff;
  --text:#1a1a1a;
  --text-muted:#6c757d;
  --radius:24px;
}

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}

body{
  background:var(--bg);
  font-family:'Poppins','DM Sans',sans-serif;
  min-height:100vh;
  overflow-x:hidden;
}

/* Animasi */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Toast Notification */
.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    animation: slideInRight 0.3s ease-out;
}

.toast-notification.hide {
    animation: slideOutRight 0.3s ease-out forwards;
}

.toast-card {
    background: white;
    border-radius: 16px;
    padding: 16px 20px;
    min-width: 320px;
    max-width: 450px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 15px;
    border-left: 5px solid;
}

.toast-success {
    border-left-color: #28a745;
}
.toast-success .toast-icon {
    background: #e8f5e9;
    color: #28a745;
}

.toast-error {
    border-left-color: #dc3545;
}
.toast-error .toast-icon {
    background: #fee;
    color: #dc3545;
}

.toast-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

.toast-content {
    flex: 1;
}

.toast-title {
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 4px;
}

.toast-message {
    font-size: 13px;
    color: #6c757d;
    line-height: 1.4;
}

.toast-close {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #999;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s;
}

.toast-close:hover {
    background: #f0f0f0;
    color: #333;
}

@keyframes slideOutRight {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100px);
    }
}

.navbar{
  height:75px;
  border-radius:0 0 20px 20px;
  z-index:1020;
  animation: slideInLeft 0.5s ease;
}

.content{
  padding:30px;
  transition:0.3s;
  animation: fadeInUp 0.6s ease;
}

.shifted{
  margin-left:280px;
}

.offcanvas{
  border:none;
  box-shadow:0 0 30px rgba(0,0,0,0.08);
}

.nav-link-custom{
  padding:14px 18px;
  border-radius:14px;
  color:#444;
  font-weight:500;
  margin-bottom:8px;
  display:flex;
  align-items:center;
  gap:12px;
  text-decoration:none;
  transition: all 0.3s ease;
}

.nav-link-custom:hover,
.nav-link-custom.active{
  background:#0d6efd;
  color:white !important;
  transform: translateX(5px);
}

.section-box{
  background:white;
  border-radius:24px;
  padding:25px;
  box-shadow:0 10px 25px rgba(0,0,0,0.05);
  border:1px solid #f0f2f5;
  transition: all 0.3s ease;
  animation: fadeInUp 0.6s ease;
}

.section-box:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.pinjam-header{
  margin-bottom:25px;
  animation: slideInLeft 0.5s ease;
}

.pinjam-header h3{
  font-size:1.35rem;
  font-weight:700;
  border-left:5px solid #0d6efd;
  padding-left:18px;
  margin:0;
  color:#1e293b;
}

/* ========== FILTER STYLING ========== */
.filter-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8fafc;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
}

.filter-btn {
    padding: 8px 20px;
    border-radius: 30px;
    border: 2px solid #e2e8f0;
    background: white;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.filter-btn:hover {
    border-color: #0d6efd;
    color: #0d6efd;
    transform: translateY(-2px);
}

.filter-btn.active {
    background: #0d6efd;
    border-color: #0d6efd;
    color: white;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

.filter-btn .badge-count {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0 8px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.filter-btn:not(.active) .badge-count {
    background: #e2e8f0;
    color: #475569;
}

.filter-btn.active .badge-count {
    background: rgba(255,255,255,0.3);
    color: white;
}

/* Tabel Styling */
.table-responsive {
    overflow-x: auto;
    border-radius: 16px;
}

.pinjam-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
}

.pinjam-table thead th {
    background: #f8fafc;
    padding: 16px 16px;
    font-weight: 600;
    font-size: 13px;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
    white-space: nowrap;
    position: sticky;
    top: 0;
    z-index: 10;
}

.pinjam-table thead th:first-child {
    border-top-left-radius: 12px;
}

.pinjam-table thead th:last-child {
    border-top-right-radius: 12px;
}

.pinjam-table tbody tr {
    transition: all 0.2s ease;
    animation: slideInRight 0.4s ease;
    animation-fill-mode: both;
}

.pinjam-table tbody tr:hover {
    background-color: #f8fafc;
    transform: scale(1.01);
}

.pinjam-table tbody td {
    padding: 16px 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
}

.pinjam-table tbody tr.hidden-row {
    display: none;
}

/* Status Badge */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.status-pill:hover {
    transform: translateY(-1px);
}

.status-pill i {
    font-size: 12px;
}

.status-pill-primary {
    background-color: #dbeafe;
    color: #1e40af;
    box-shadow: 0 2px 6px rgba(30, 64, 175, 0.1);
}

.status-pill-danger {
    background-color: #fee2e2;
    color: #991b1b;
    box-shadow: 0 2px 6px rgba(153, 27, 27, 0.1);
}

.status-pill-success {
    background-color: #dcfce7;
    color: #166534;
    box-shadow: 0 2px 6px rgba(22, 101, 52, 0.1);
}

.status-pill-secondary {
    background-color: #e5e7eb;
    color: #4b5563;
    box-shadow: 0 2px 6px rgba(75, 85, 99, 0.1);
}

.s-dipinjam {
    background-color: #fef3c7;
    color: #92400e;
    box-shadow: 0 2px 6px rgba(146, 64, 14, 0.1);
}

.s-dipinjam i {
    color: #b45309;
}

.s-terlambat {
    background-color: #fee2e2;
    color: #991b1b;
    box-shadow: 0 2px 6px rgba(153, 27, 27, 0.1);
}

.s-terlambat i {
    color: #dc2626;
}

.s-kembali {
    background-color: #dcfce7;
    color: #166534;
    box-shadow: 0 2px 6px rgba(22, 101, 52, 0.1);
}

.s-kembali i {
    color: #059669;
}

.s-batal {
    background-color: #e5e7eb;
    color: #4b5563;
    box-shadow: 0 2px 6px rgba(75, 85, 99, 0.1);
}

.s-batal i {
    color: #6b7280;
}

/* Tombol Aksi */
.btn-lihat {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border: none;
    padding: 6px 12px;
    border-radius: 8px;
    background: #2563eb;
    color: white;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 1px 6px rgba(37, 99, 235, 0.15);
    white-space: nowrap;
    margin-right: 10px;
    margin-bottom: 8px;
}

.btn-lihat i {
    font-size: 13px;
    color: white;
}

.btn-lihat:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
}

.btn-batalkan {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border: none;
    padding: 6px 12px;
    border-radius: 8px;
    background: #fcd34d;
    color: #1f2937;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 1px 6px rgba(252, 211, 77, 0.15);
    white-space: nowrap;
}

.btn-batalkan i {
    font-size: 14px;
    color: #1f2937;
}

.btn-batalkan:hover {
    background: #fbbf24;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(252, 211, 77, 0.2);
}

.btn-batalkan:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
}

.action-group {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

/* Modal Detail Styling */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    transform: scale(0.95);
    opacity: 0;
}

.modal.show .modal-dialog {
    transform: scale(1);
    opacity: 1;
}

.modal-form-container .modal-content {
    border-radius: 28px;
    border: none;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.modal-header-form {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: white;
    padding: 20px 28px;
    text-align: center;
}

.modal-header-form h3 {
    font-weight: 700;
    font-size: 1.3rem;
    margin: 0;
}

.modal-header-form .trx-code-form {
    font-size: 0.7rem;
    opacity: 0.7;
    margin: 5px 0 0 0;
    font-family: monospace;
}

.modal-body-form {
    padding: 24px 28px;
    background: #ffffff;
}

.form-group-box {
    margin-bottom: 18px;
}

.form-group-box label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #64748b;
    margin-bottom: 6px;
    display: block;
}

.form-control-custom {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 10px 16px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #1e293b;
    width: 100%;
    min-height: 48px;
}

.row-2cols {
    display: flex;
    gap: 16px;
    margin-bottom: 18px;
}
.row-2cols .form-group-box {
    flex: 1;
    margin-bottom: 0;
}

.judul-section {
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px dashed #eef2f6;
}

.judul-section h4 {
    font-size: 1.1rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 6px 0;
}

.judul-section p {
    font-size: 0.75rem;
    color: #64748b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Progress Bar */
.progress-box-warning, .progress-box-info {
    border-radius: 14px;
    padding: 12px 16px;
    margin-top: 4px;
    margin-bottom: 18px;
}

.progress-box-warning {
    background: #fef2f2;
    border: 1px solid #fee2e2;
}

.progress-box-info {
    background: #f0f9ff;
    border: 1px solid #bddfff;
}

.progress-header-warning, .progress-header-info {
    font-size: 0.7rem;
    font-weight: 700;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
}

.progress-header-warning { color: #b91c1c; }
.progress-header-info { color: #0c6b9e; }

.progress-bar-bg-custom {
    background: #e2e8f0;
    border-radius: 40px;
    height: 6px;
    overflow: hidden;
}

.progress-fill-red-custom {
    background: linear-gradient(90deg, #ef4444, #dc2626);
    height: 100%;
    border-radius: 40px;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.progress-fill-blue-custom {
    background: linear-gradient(90deg, #3b82f6, #2563eb);
    height: 100%;
    border-radius: 40px;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.status-section {
    margin-top: 8px;
}

.status-label-custom {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #64748b;
    margin-bottom: 8px;
    display: block;
}

.status-badge-large {
    display: inline-block;
    padding: 8px 28px;
    border-radius: 40px;
    font-size: 0.85rem;
    font-weight: 700;
}

.badge-terlambat-form {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fee2e2;
}
.badge-dipinjam-form {
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fef3c7;
}
.badge-kembali-form {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #d1fae5;
}
.badge-batal-form {
    background: #e2e3e5;
    color: #383d41;
    border: 1px solid #d6d8db;
}

.modal-footer-form {
    padding: 16px 28px 24px 28px;
    background: white;
    border-top: 1px solid #edf2f7;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-tutup-form {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    padding: 10px 32px;
    border-radius: 40px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-tutup-form:hover {
    background: #e2e8f0;
    transform: translateY(-2px);
}

/* Alert Empty */
.alert-empty {
    text-align: center;
    padding: 60px 20px;
    background: #f8f9fa;
    border-radius: 20px;
    animation: fadeInUp 0.6s ease;
}

.alert-empty i {
    font-size: 60px;
    color: #adb5bd;
    margin-bottom: 20px;
}

/* Counter Info */
.counter-info {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: #f1f5f9;
    border-radius: 30px;
    font-size: 13px;
    color: #475569;
    margin-left: 12px;
}

.counter-info strong {
    color: #0d6efd;
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #0d6efd;
    border-radius: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-container {
        padding: 10px;
        gap: 6px;
    }
    .filter-btn {
        padding: 6px 14px;
        font-size: 12px;
    }
    .pinjam-table tbody td {
        padding: 12px 10px;
        font-size: 13px;
    }
    .action-group {
        flex-direction: column;
        gap: 4px;
        align-items: flex-start;
    }
    .btn-lihat, .btn-batalkan {
        padding: 4px 12px;
        font-size: 11px;
        margin-right: 0;
    }
    .btn-batalkan i {
        font-size: 12px;
    }
    .row-2cols {
        flex-direction: column;
        gap: 10px;
    }
    .modal-body-form {
        padding: 16px;
    }
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-light bg-white shadow-sm px-4">
<div class="d-flex align-items-center">
<button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
<i class="bi bi-list fs-4"></i>
</button>
<h4 class="ms-3 mt-2 fw-bold">Dashboard Perpustakaan</h4>
</div>
<div class="d-flex align-items-center gap-3">
<i class="bi bi-bell fs-5"></i>
<a href="../views/auth/profile.php"><img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="45" class="rounded-circle"></a>
</div>
</nav>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" style="width:280px;" data-bs-backdrop="false">
<div class="offcanvas-header border-bottom">
    <h4 class="fw-bold text-primary"><i class="bi bi-book-half"></i> Digital Library</h4>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
<div class="offcanvas-body d-flex flex-column">
    <div class="text-center mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" width="110" class="mb-3">
        <h5 class="fw-bold mb-0"><?= htmlspecialchars($_SESSION['nama'] ?? 'Mahasiswa'); ?></h5>
        <small class="text-muted"><?= htmlspecialchars($_SESSION['nim'] ?? 'Library User'); ?></small>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link-custom" href="../views/dashboard/userindex.php"><i class="bi bi-grid-fill me-2"></i>Dashboard</a></li>
        <li class="nav-item"><a class="nav-link-custom active" href="peminjaman.php"><i class="bi bi-journal-check me-2"></i>Peminjaman</a></li>
        <li class="nav-item"><a class="nav-link-custom" href="katalog.php"><i class="bi bi-book-half me-2"></i>Katalog</a></li>
    </ul>
    <div class="mt-auto border-top pt-3">
        <a href="logout.php" class="btn btn-danger w-100 rounded-4"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </div>
</div>
</div>

<!-- Toast Container -->
<div id="toastContainer"></div>

<!-- MAIN CONTENT -->
<div class="content" id="mainContent">
  <div class="section-box">
    <div class="pinjam-header">
      <h3><i class="bi bi-journal-check me-2"></i> Data Peminjaman Saya</h3>
    </div>
    
    <!-- ========== FILTER STATUS ========== -->
    <div class="filter-container">
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
    
    <div class="table-responsive">
      <table class="pinjam-table" id="peminjamanTable">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="35%">Judul Buku</th>
            <th width="15%">Nama Peminjam</th>
            <th width="12%">Tgl Pinjam</th>
            <th width="12%">Tgl Kembali</th>
            <th width="12%">Status</th>
            <th width="9%">Aksi</th>
          </tr>
        </thead>
        <tbody>
            <?= $peminjamanTableHtml ?>
        </tbody>
      </table>
      <div style="margin-top: 15px; text-align: right; font-size: 13px; color: #6c757d;">
          <span id="rowCounter">Menampilkan <?= $totalSemua ?> data</span>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade modal-form-container" id="detailFormModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 560px;">
    <div class="modal-content">
      
      <div class="modal-header-form">
        <h3><i class="bi bi-journal-bookmark-fill"></i> Detail Peminjaman</h3>
        <p class="trx-code-form" id="formTrxCode">#TRX-0001</p>
      </div>
      
      <div class="modal-body-form">
        
        <div class="judul-section">
          <h4 id="formJudulBuku">Algoritma & Pemrograman</h4>
          <p><i class="bi bi-person-circle"></i> <span id="formNamaPeminjam">Budi Santoso</span></p>
        </div>
        
        <div class="row-2cols">
          <div class="form-group-box">
            <label><i class="bi bi-person"></i> Nama Lengkap</label>
            <div class="form-control-custom" id="formNamaValue">Budi Santoso</div>
          </div>
          <div class="form-group-box">
            <label><i class="bi bi-qr-code"></i> NIM</label>
            <div class="form-control-custom" id="formNimValue">-</div>
          </div>
        </div>
        
        <div class="form-group-box">
          <label><i class="bi bi-calendar-plus"></i> Tanggal Pinjam</label>
          <div class="form-control-custom" id="formTglPinjam">01 Apr 2025</div>
        </div>
        
        <div class="form-group-box">
          <label><i class="bi bi-calendar-check"></i> Tanggal Kembali</label>
          <div class="form-control-custom" id="formTglKembali">15 Apr 2025</div>
        </div>
        
        <div class="row-2cols">
          <div class="form-group-box">
            <label><i class="bi bi-hourglass-split"></i> Durasi</label>
            <div class="form-control-custom" id="formDurasi">14 Hari</div>
          </div>
          <div class="form-group-box">
            <label><i class="bi bi-clock-history"></i> Sisa / Terlambat</label>
            <div class="form-control-custom" id="formSisaHari">3 Hari</div>
          </div>
        </div>
        
        <div id="formProgressTerlambatArea" style="display: none;">
          <div class="progress-box-warning">
            <div class="progress-header-warning">
              <span><i class="bi bi-exclamation-triangle-fill"></i> Status Terlambat</span>
              <span id="formPersenTerlambat">0%</span>
            </div>
            <div class="progress-bar-bg-custom">
              <div class="progress-fill-red-custom" id="formProgressFillTerlambat" style="width: 0%;"></div>
            </div>
            <div style="font-size: 0.7rem; color:#b91c1c; margin-top: 10px; font-weight: 500;" id="formTerlambatDesc">
              ⚠️ Melebihi batas pengembalian
            </div>
          </div>
        </div>
        
        <div id="formProgressDipinjamArea" style="display: none;">
          <div class="progress-box-info">
            <div class="progress-header-info">
              <span><i class="bi bi-calendar-week"></i> Progress Peminjaman</span>
              <span id="formPersenDipinjam">0%</span>
            </div>
            <div class="progress-bar-bg-custom">
              <div class="progress-fill-blue-custom" id="formProgressFillDipinjam" style="width: 0%;"></div>
            </div>
            <div style="font-size: 0.7rem; color:#0c6b9e; margin-top: 10px; font-weight: 500;" id="formDipinjamDesc">
              📅 Menghitung masa peminjaman
            </div>
          </div>
        </div>
        
        <div class="status-section">
          <div class="status-label-custom"><i class="bi bi-flag-fill"></i> STATUS PEMINJAMAN</div>
          <span class="status-badge-large" id="formStatusBadge">Terlambat</span>
        </div>
        
      </div>
      
      <div class="modal-footer-form">
        <button class="btn-tutup-form" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Tutup</button>
      </div>
      
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ========== FUNGSI FILTER ==========
function filterTable(filter) {
    // Update active button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-filter') === filter) {
            btn.classList.add('active');
        }
    });
    
    // Filter rows
    const rows = document.querySelectorAll('#peminjamanTable tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        if (filter === 'all' || status === filter) {
            row.classList.remove('hidden-row');
            row.style.display = '';
            visibleCount++;
        } else {
            row.classList.add('hidden-row');
            row.style.display = 'none';
        }
    });
    
    // Update counter
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
    
    const toastHTML = `
        <div id="${toastId}" class="toast-notification">
            <div class="toast-card toast-${type}">
                <div class="toast-icon">${icon}</div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="closeToast('${toastId}')">×</button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', toastHTML);
    
    setTimeout(() => { closeToast(toastId); }, duration);
}

function closeToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
        toast.classList.add('hide');
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
        
        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'action=batalkan&id=' + id
        })
        .then(response => response.json())
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
            showToast('❌ Error', 'Terjadi kesalahan jaringan: ' + error.message, 'error');
            if (targetButton) {
                targetButton.innerHTML = '<i class="bi bi-x-circle"></i> Batalkan';
                targetButton.disabled = false;
            }
        });
    }
}

// ========== SIDEBAR ==========
const sidebarElem = document.getElementById('sidebar');
const contentDiv = document.querySelector('.content');
const navbarElem = document.querySelector('.navbar');

function isDesktop(){ return window.innerWidth > 992; }

if(sidebarElem) {
    sidebarElem.addEventListener('shown.bs.offcanvas', function () { if(isDesktop()){ contentDiv.classList.add('shifted'); navbarElem.classList.add('shifted'); } });
    sidebarElem.addEventListener('hidden.bs.offcanvas', function () { contentDiv.classList.remove('shifted'); navbarElem.classList.remove('shifted'); });
}
window.addEventListener('resize', () => { if(window.innerWidth <= 992){ contentDiv.classList.remove('shifted'); navbarElem.classList.remove('shifted'); } else if(!sidebarElem.classList.contains('show')) { contentDiv.classList.remove('shifted'); navbarElem.classList.remove('shifted'); } });

// ========== PARSE TANGGAL ==========
function parseIndonesianDate(dateStr) {
    const months = {
        'Jan':0,'Feb':1,'Mar':2,'Apr':3,'May':4,'Jun':5,
        'Jul':6,'Aug':7,'Sep':8,'Oct':9,'Nov':10,'Dec':11
    };
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
    
    const pinjam = new Date(tglPinjam);
    pinjam.setHours(0,0,0,0);
    
    const tglKembaliDatabaseDate = new Date(tglKembaliDatabase);
    tglKembaliDatabaseDate.setHours(0,0,0,0);
    
    const sekarang = new Date(today);
    sekarang.setHours(0,0,0,0);
    
    const tglBatas = new Date(pinjam);
    tglBatas.setDate(tglBatas.getDate() + BATAS_MAKSIMAL);
    
    const durasiSebenarnya = Math.ceil((tglKembaliDatabaseDate.getTime() - pinjam.getTime()) / (1000 * 60 * 60 * 24));
    
    let hariBerjalan = Math.ceil((sekarang.getTime() - pinjam.getTime()) / (1000 * 60 * 60 * 24));
    hariBerjalan = Math.max(0, hariBerjalan);
    
    let sisaHari = Math.ceil((tglBatas.getTime() - sekarang.getTime()) / (1000 * 60 * 60 * 24));
    sisaHari = Math.max(0, sisaHari);
    
    let hariTerlambat = 0;
    if (sekarang > tglBatas) {
        hariTerlambat = Math.ceil((sekarang.getTime() - tglBatas.getTime()) / (1000 * 60 * 60 * 24));
    }
    
    let persenProgress = 0;
    if (hariBerjalan <= BATAS_MAKSIMAL) {
        persenProgress = (hariBerjalan / BATAS_MAKSIMAL) * 100;
    } else {
        persenProgress = 100;
    }
    persenProgress = Math.min(Math.max(persenProgress, 0), 100);
    
    let persenTerlambat = 0;
    if (hariTerlambat > 0) {
        persenTerlambat = (hariTerlambat / BATAS_MAKSIMAL) * 100;
        persenTerlambat = Math.min(persenTerlambat, 100);
    }
    
    return {
        durasiSebenarnya: durasiSebenarnya,
        batasMaksimal: BATAS_MAKSIMAL,
        hariBerjalan: hariBerjalan,
        sisaHari: sisaHari,
        hariTerlambat: hariTerlambat,
        persenProgress: persenProgress,
        persenTerlambat: persenTerlambat,
        tglBatas: tglBatas
    };
}

// ========== SHOW DETAIL ==========
function showDetail(id) {
    const modalElement = document.getElementById('detailFormModal');
    
    fetch(window.location.href, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'action=get_detail&id=' + id
    })
    .then(response => response.json())
    .then(result => {
        if(result.success) {
            const data = result.data;
            
            document.getElementById('formTrxCode').innerHTML = `#TRX-${String(data.id).padStart(4, '0')}`;
            document.getElementById('formJudulBuku').innerHTML = data.judul;
            document.getElementById('formNamaPeminjam').innerHTML = data.nama;
            document.getElementById('formNamaValue').innerHTML = data.nama;
            document.getElementById('formNimValue').innerHTML = data.nim || '-';
            document.getElementById('formTglPinjam').innerHTML = data.tanggal_pinjam;
            document.getElementById('formTglKembali').innerHTML = data.tanggal_kembali;
            
            const pinjamDate = parseIndonesianDate(data.tanggal_pinjam);
            const kembaliDate = parseIndonesianDate(data.tanggal_kembali);
            const today = new Date();
            today.setHours(0,0,0,0);
            
            const progress = hitungProgressPeminjaman(pinjamDate, kembaliDate, today);
            
            document.getElementById('formDurasi').innerHTML = `${progress.durasiSebenarnya} Hari (Maksimal ${progress.batasMaksimal} hari)`;
            
            const statusBadge = document.getElementById('formStatusBadge');
            const progressTerlambatArea = document.getElementById('formProgressTerlambatArea');
            const progressDipinjamArea = document.getElementById('formProgressDipinjamArea');
            const sisaElement = document.getElementById('formSisaHari');
            
            progressTerlambatArea.style.display = 'none';
            progressDipinjamArea.style.display = 'none';
            
            const isTerlambat = progress.hariTerlambat > 0;
            
            if(data.status === 'kembali') {
                statusBadge.innerHTML = 'Dikembalikan';
                statusBadge.className = 'status-badge-large badge-kembali-form';
                sisaElement.innerHTML = `✔️ Selesai (sudah dikembalikan)`;
            }
            else if(data.status === 'batal') {
                statusBadge.innerHTML = 'Dibatalkan';
                statusBadge.className = 'status-badge-large badge-batal-form';
                sisaElement.innerHTML = `✖️ Peminjaman dibatalkan`;
            }
            else if(isTerlambat) {
                statusBadge.innerHTML = 'Terlambat';
                statusBadge.className = 'status-badge-large badge-terlambat-form';
                sisaElement.innerHTML = `Terlambat ${progress.hariTerlambat} hari`;
                
                progressTerlambatArea.style.display = 'block';
                const persenBulat = Math.round(progress.persenTerlambat);
                document.getElementById('formPersenTerlambat').innerHTML = `${persenBulat}%`;
                setTimeout(() => {
                    document.getElementById('formProgressFillTerlambat').style.width = `${persenBulat}%`;
                }, 100);
                
                let descText = `⚠️ Terlambat ${progress.hariTerlambat} hari dari batas maksimal ${progress.batasMaksimal} hari`;
                document.getElementById('formTerlambatDesc').innerHTML = descText;
            } 
            else if(data.status === 'dipinjam' && !isTerlambat) {
                statusBadge.innerHTML = 'Dipinjam';
                statusBadge.className = 'status-badge-large badge-dipinjam-form';
                
                if(progress.sisaHari > 0) {
                    sisaElement.innerHTML = `${progress.sisaHari} Hari`;
                } else {
                    sisaElement.innerHTML = `Jatuh tempo hari ini`;
                }
                
                progressDipinjamArea.style.display = 'block';
                const persenBulat = Math.round(progress.persenProgress);
                document.getElementById('formPersenDipinjam').innerHTML = `${persenBulat}%`;
                setTimeout(() => {
                    document.getElementById('formProgressFillDipinjam').style.width = `${persenBulat}%`;
                }, 100);
                
                document.getElementById('formDipinjamDesc').innerHTML = `📅 ${progress.hariBerjalan} dari ${progress.batasMaksimal} hari terpakai • Sisa ${progress.sisaHari} hari lagi`;
            }
            
            const modalInstance = new bootstrap.Modal(modalElement);
            modalInstance.show();
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
</script>

</body>
</html>